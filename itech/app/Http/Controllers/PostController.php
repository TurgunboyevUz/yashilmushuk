<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Product\Color;
use App\Models\Product\Comment;
use App\Models\Product\Product;
use App\Models\Product\Size;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function contact(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|max:255',
            'phone_number' => 'required|max:255',
            'title'        => 'required|max:255',
            'message'      => 'required',
        ]);

        Contact::create($data);

        session()->flash('success', 'Xabaringiz muvaffaqiyatli yuborildi!');

        return redirect()->back();
    }

    public function comment(Request $request, $id)
    {
        $data = $request->validate([
            'score'        => 'required|integer|min:1|max:5',
            'name'         => 'required|max:255',
            'phone_number' => 'required|max:255',
            'content'      => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->comments()->create($data);

        session()->flash('success', 'Fikringiz muvaffaqiyatli yuborildi!');

        return redirect()->back();
    }

    public function order(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|max:255',
            'phone'    => 'required|max:255',
            'telegram' => 'nullable|max:255',
            'color'    => 'required|integer|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $data = $request->all();

        $product = Product::findOrFail($id);
        $color   = Color::findOrFail($data['color']);

        $size = Size::find($data['size'] ?? null);
        if (! $size) {
            $size = "O'lchamsiz";
        } else {
            $size = $size->name;
        }

        $price = $product->prices()->pluck('price')->filter();

        if ($price->isEmpty()) {
            $price_list = "Narx belgilanmagan";
        }else{
            $price_list = "";

            foreach ($price->toArray() as $item) {
                $price_list .= number_format($item, 0, '.', ',') . ' so\'m | ';
            }

            $price_list = substr($price_list, 0, -3);
        }

        session([
            'order' => (int) session('order', 0) + 1
        ]);

        if (count($product->image_path) > 1) {
            $images = [];
            $params = [];
        
            foreach ($product->image_path as $index => $image) {
                $attachName = "file{$index}";
                $filePath = storage_path('app/public/' . $image);
        
                $img = [
                    'type' => 'photo',
                    'media' => "attach://{$attachName}"
                ];
        
                if ($index === 0) {
                    $img = array_merge($img, [
                        'caption' => "Buyurtma beruvchi: {$data['name']}\nTelefon raqam: {$data['phone']}\nTelegram: {$data['telegram']}\n\nKategoriya: {$product->category->name}\nMahsulot: {$product->name}\nO'lcham: {$size}\nRang: {$color->name}\nSoni: {$data['quantity']}\nNarx: {$price_list}"
                    ]);
                }
        
                $images[] = $img;
                $params[$attachName] = new CURLFile($filePath);
            }
        
            $params['chat_id'] = env('APP_GROUP_ID');
            $params['media'] = json_encode($images);
            $params['parse_mode'] = 'html';
        
            bot('sendMediaGroup', $params);
            exit;
        }        
        

        bot('sendPhoto', [
            'chat_id'    => env('APP_GROUP_ID'),
            'photo'      => asset('storage/' . $product->image_path[0]),
            'caption'       => "Buyurtma beruvchi: {$data['name']}\nTelefon raqam: {$data['phone']}\nTelegram: {$data['telegram']}\n\nKategoriya: {$product->category->name}\nMahsulot: {$product->name}\nO'lcham: {$size}\nRang: {$color->name}\nSoni: {$data['quantity']}\nNarx: {$price_list}",
            'parse_mode' => 'html',
        ]);
    }

    public function modal(Request $request, $id)
    {
        $data    = $request->all();
        $product = Product::findOrFail($id);

        $sizes  = $product->prices->pluck('size.name')->filter()->implode(', ');
        $prices = $product->prices->pluck('price')->filter();

        $colors = "";
        foreach ($product->colors as $color) {
            $colors .= Color::find($color)->name . ', ';
        }

        $colors = substr($colors, 0, -2);

        $sizes  = $sizes ?: 'O\'lchamlar mavjud emas';

        if($prices->isEmpty()) {
            $price_list = 'Narxlar mavjud emas';
        }else{
            $price_list = "";

            foreach ($prices->toArray() as $item) {
                $price_list .= number_format($item, 0, '.', ',') . ' so\'m | ';
            }

            $price_list = substr($price_list, 0, -3);
        }

        session([
            'order' => (int) session('order', 0) + 1
        ]);

        if (count($product->image_path) > 1) {
            $images = [];
            $params = [];
        
            foreach ($product->image_path as $index => $image) {
                $attachName = "file{$index}";
                $filePath = storage_path('app/public/' . $image);
        
                $img = [
                    'type' => 'photo',
                    'media' => "attach://{$attachName}"
                ];
        
                if ($index === 0) {
                    $img = array_merge($img, [
                        'caption' => "Buyurtma beruvchi: {$data['name']}\nTelefon raqam: {$data['phone']}\nTelegram: {$data['telegram']}\n\nMahsulot: {$product->name}\n\nTavsif: {$product->description}\n\nRanglar: {$colors}\nO'lchamlar: {$sizes}\nNarxlar: {$price_list}"
                    ]);
                }
        
                $images[] = $img;
                $params[$attachName] = new CURLFile($filePath);
            }
        
            $params['chat_id'] = env('APP_GROUP_ID');
            $params['media'] = json_encode($images);
            $params['parse_mode'] = 'html';
        
            bot('sendMediaGroup', $params);
            exit;
        }        

        bot('sendPhoto', [
            'chat_id' => env('APP_GROUP_ID'),
            'photo' => asset('storage/' . $product->image_path[0]),
            'caption'    => "Buyurtma beruvchi: {$data['name']}\nTelefon raqam: {$data['phone']}\nTelegram: {$data['telegram']}\n\nMahsulot: {$product->name}\n\nTavsif: {$product->description}\n\nRanglar: {$colors}\nO'lchamlar: {$sizes}\nNarxlar: {$price_list}",
        ]);
    }
}
