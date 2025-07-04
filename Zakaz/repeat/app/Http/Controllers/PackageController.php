<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Traits\HttpResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Paketlar')]
class PackageController extends Controller
{
    use HttpResponse;

    /**
     * Ro'yxatni olish
     */
    public function all() {
        return $this->success(PackageResource::collection(Package::all()));
    }

    /**
     * Paketni olish
     */
    public function show(Package $package) {
        return $this->success(new PackageResource($package));
    }

    /**
     * Mirpay orqali sotib olish
     */
    public function purchase(Request $request, Package $package) {
        $transaction = $package->createMirpayTransaction($package->price, 'Foydalanuvchi ID: '.$request->user()->id . ' | Paket ID: ' . $package->id);
        $transaction->user_id = $request->user()->id;
        $transaction->save();

        return $this->success(['redirect_url' => $transaction->redirect_url]);
    }
}
