<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Magazine\Magazine;
use App\Models\Magazine\MagazineCategory;
use App\Models\Page\About;
use App\Models\Page\Advantage;
use App\Models\Page\Image;
use App\Models\Page\YouTube;
use App\Models\Product\Category;
use App\Models\Product\Color;
use App\Models\Product\Product;
use App\Models\Product\Size;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $advantages = Advantage::where('status', 1)->get();
        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();

        $top_products = Product::withCount('orders')->orderBy('orders_count', 'desc')->take(8)->get();
        $new_products = Product::orderBy('id', 'desc')->with('prices')->take(8)->get();

        $telegram = About::where('key', 'telegram')->first()->value;

        return view('pages.index', compact('advantages', 'categories', 'top_products', 'new_products', 'telegram'));
    }

    public function products(Request $request)
    {
        $query = Product::query();

        if ($request->has('category') && ! empty($request->category) && !in_array('on', $request->category)) {
            $query->whereIn('category_id', $request->category);
        }

        if ($request->has('min_price') && ! empty($request->min_price)) {
            $query->whereHas('prices', function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            });
        }

        if ($request->has('max_price') && ! empty($request->max_price) and $request->max_price > 0) {
            $query->whereHas('prices', function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            });
        }

        if ($request->has('color') && ! empty($request->color) && !in_array('on', $request->color)) {
            foreach ($request->color as $color) {
                $query->where('colors', 'like', '%"' . $color . '"%');
            }
        }

        if ($request->has('size') && ! empty($request->size) && !in_array('on', $request->size)) {
            $query->whereHas('prices', function ($query) use ($request) {
                $query->whereIn('prices.size_id', $request->size);
            });
        }

        $products = $query->paginate(9);
        $products->appends($request->except('page'));

        $categories = Category::withCount('products')
            ->with('products')
            ->orderBy('products_count', 'desc')
            ->get();

        $sizes  = Size::all();
        $colors = Color::all();

        return view('pages.products', compact('categories', 'sizes', 'colors', 'products'));
    }

    public function category(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->with('prices')->paginate(8);

        return view('pages.category-items', compact('category', 'products'));
    }

    public function product(Request $request, $id)
    {
        $product  = Product::findOrFail($id);
        $comments = $product->comments()->orderBy('created_at', 'desc')->get();

        $random_products = Product::inRandomOrder()->with('prices')->take(6)->get();

        return view('pages.product', compact('product', 'comments', 'random_products'));
    }

    public function search(Request $request)
    {
        if ($request->has('q') and ! empty($request->q)) {
            $query = $request->q;

            $products = Product::where('name', 'like', "%{$query}%")->paginate(9);
            $products->appends(['q' => $query]);
            $products->load(['category', 'prices.size']);

            return view('pages.search', compact('products', 'query'));
        }else{
            return redirect()->route('index');
        }
    }

    public function page(Request $request, $slug)
    {
        $page = Blog::where('slug', $slug)->first();

        if (! $page) {
            abort(404);
        }

        return view('pages.page', compact('page'));
    }

    public function news(Request $request)
    {
        if ($request->has('magazine')) {
            $magazine = Magazine::findOrFail($request->magazine);

            $query = $magazine->category->magazines()->orderBy('created_at', 'asc');

            $position = $query->pluck('id')->search($magazine->id) + 1;

            $page = (int) ceil($position / 3);

            $magazines = $query->paginate(3, ['*'], 'page', $page);

            if ($request->query('page') != $page) {
                return redirect()->route('news.category', [
                    'category' => $magazine->category->id,
                    'page'     => $page,
                ]);
            }
        }

        $youtube_urls        = YouTube::all();
        $magazine_categories = MagazineCategory::all();
        $magazines           = Magazine::with('category')->paginate(3);

        foreach ($magazines as $magazine) {
            $magazine_list = session('magazine_list', []);
            if (! in_array($magazine->id, $magazine_list)) {
                $magazine_list[] = $magazine->id;
                $magazine->increment('views');
            }

            session(['magazine_list' => $magazine_list]);
        }

        return view('pages.news', compact('youtube_urls', 'magazine_categories', 'magazines'));
    }

    public function news_category(Request $request, MagazineCategory $category)
    {
        if ($request->has('magazine')) {
            $magazine = Magazine::findOrFail($request->magazine);

            $query = $magazine->category->magazines()->orderBy('created_at', 'asc');

            $position = $query->pluck('id')->search($magazine->id) + 1;

            $page = (int) ceil($position / 3);

            $magazines = $query->paginate(3, ['*'], 'page', $page);

            if ($request->query('page') != $page) {
                return redirect()->route('news.category', [
                    'category' => $magazine->category->id,
                    'page'     => $page,
                ]);
            }
        }

        $magazines = $category->magazines()->paginate(3);

        $all_magazines       = Magazine::all();
        $magazine_categories = MagazineCategory::all();

        return view('pages.news-category', compact('category', 'magazines', 'all_magazines', 'magazine_categories'));
    }

    public function about(Request $request)
    {
        $image = Image::where('key', 'about')->first();
        $image = asset('storage/' . $image->path);

        $company = About::where('key', 'company')->first()->value;
        $company = str($company)->markdown()->sanitizeHtml();

        $additional = About::where('key', 'additional')->get();

        $phone     = About::where('key', 'phone')->first()->value;
        $telegram  = About::where('key', 'telegram')->first()->value;
        $instagram = About::where('key', 'instagram')->first()->value;
        $whatsapp  = About::where('key', 'whatsapp')->first()->value;
        $youtube   = About::where('key', 'youtube')->first()->value;

        $map  = About::where('key', 'map')->first()->value;

        return view('pages.about', compact('image', 'company', 'additional', 'phone', 'telegram', 'instagram', 'whatsapp', 'youtube', 'map'));
    }

    public function contact(Request $request)
    {
        $address   = About::where('key', 'address')->first()->value;
        $email     = About::where('key', 'email')->first()->value;
        $phone     = About::where('key', 'phone')->first()->value;
        $telegram  = About::where('key', 'telegram')->first()->value;
        $instagram = About::where('key', 'instagram')->first()->value;
        $whatsapp  = About::where('key', 'whatsapp')->first()->value;
        $youtube   = About::where('key', 'youtube')->first()->value;

        return view('pages.contact', compact('address', 'email', 'phone', 'telegram', 'instagram', 'whatsapp', 'youtube'));
    }
}
