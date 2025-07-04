<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseAmountRequest;
use App\Http\Requests\PurchaseCoinRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ExamResource;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Promocode;
use App\Traits\HttpResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TurgunboyevUz\Mirpay\Enums\MirpayState;

#[Group('Imtihonlar')]
class ExamController extends Controller
{
    use HttpResponse;

    /**
     * Kategoriyalarni olish
     */
    public function categories(Request $request) {
        return $this->success(CategoryResource::collection(Category::all()));
    }

    /**
     * Ro'yxatni olish
     */
    public function all(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:speaking,writing',
        ]);

        $exams = Exam::query()->with('category');

        if ($request->type) {
            $exams->where('type', $request->type);
        }

        return $this->success(ExamResource::collection($exams->get()));
    }

    /**
     * Imtihonni olish
     */
    public function show(Request $request, Exam $exam)
    {
        $exam->load('category');

        return $this->success(new ExamResource($exam));
    }

    /**
     * Sevimlilarga qo'shish/o'chirish
     */
    public function toggleFavourite(Request $request, Exam $exam) {
        return $this->success(['is_favourite' => $exam->toggleFavourite($request->user())]);
    }

    /**
     * Promocode ni tekshirish
     */
    public function promocodeValidate(Request $request, Exam $exam) {
        $request->validate(['promocode' => 'required']);

        if(! $promocode = $this->validatePromocode($request, $exam)) {
            return $this->error('Invalid promocode', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->success(array_merge($this->calculateFinalPrice($promocode, $exam), [
            'promocode' => $promocode
        ]));
    }

    /**
     * Tanga bilan sotib olish
     */
    public function purchaseCoin(PurchaseCoinRequest $request, Exam $exam) {
        $data = $request->validated();
        $promocode = $this->validatePromocode($request, $exam);

        if ($request->has('promocode') and ! $promocode) {
            return $this->error('Invalid promocode', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $promocode_data = $this->calculateFinalPrice($promocode, $exam);

        if($request->user()->balance < $promocode_data['final_coin']) {
            return $this->error('Not enough balance', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $request->user()->balance -= $promocode_data['final_coin'];
        $request->user()->save();

        $request->user()->exams()->create([
            'exam_id' => $exam->id,
        ]);

        return $this->success([
            'discount' => $promocode_data['discount_coin'],
            'final_price' => $promocode_data['final_coin'],
        ]);
    }

    /**
     * Mirpay orqali sotib olish
     */
    public function purchaseAmount(PurchaseAmountRequest $request, Exam $exam) {
        $data = $request->validated();
        $promocode = $this->validatePromocode($request, $exam);

        if ($request->has('promocode') and ! $promocode) {
            return $this->error('Invalid promocode', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $promocode_data = $this->calculateFinalPrice($promocode, $exam);
        
        $transaction = $exam->createMirpayTransaction($promocode_data['final_uzs'], 'Foydalanuvchi ID: '.$request->user()->id . ' | Imtihon ID: ' . $exam->id);
        $transaction->user_id = $request->user()->id;
        $transaction->promocode_id = $promocode ? $promocode->id : null;
        $transaction->discount = $promocode_data['discount_uzs'];
        $transaction->save();

        return $this->success(['redirect_url' => $transaction->redirect_url]);
    }

    private function validatePromocode(Request $request, Exam $exam)
    {
        if(! $request->promocode) {
            return null;
        }

        $promocode = Promocode::where('code', $request->promocode)
            ->where('is_active', true)
            ->where(function ($query) use ($request, $exam) {
                $query->where('exam_id', $exam->id)->orWhereNull('exam_id');
            })->first();

        if (! $promocode) {
            return null;
        }

        if ($promocode->valid_from >= now() || ($promocode->valid_until && $promocode->valid_until <= now())) {
            return null;
        }

        if ($promocode->usage_limit && $promocode->used_count >= $promocode->usage_limit) {
            return null;
        }

        if ($exam->mirpayTransactions()->where('promocode_id', $promocode->id)->where('state', MirpayState::SUCCESS)->exists()) {
            return null;
        }

        return $promocode;
    }

    private function calculateFinalPrice($promocode, $exam)
    {
        $discountUzs  = 0;
        $discountCoin = 0;

        if ($promocode) {
            if ($promocode->type === 'percentage') {
                $discountUzs  = ($exam->price_uzs * $promocode->percentage) / 100;
                $discountCoin = ($exam->price_coin * $promocode->percentage) / 100;
            } else {
                $discountUzs  = $promocode->amount ?? 0;
                $discountCoin = $promocode->coin ?? 0;
            }
        }

        return [
            'discount_uzs'  => round($discountUzs, 2),
            'discount_coin' => round($discountCoin, 2),
            'final_uzs'     => max(0, $exam->price_uzs - $discountUzs),
            'final_coin'    => max(0, $exam->price_coin - $discountCoin),
        ];
    }
}
