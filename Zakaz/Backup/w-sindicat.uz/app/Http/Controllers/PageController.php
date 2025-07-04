<?php

namespace App\Http\Controllers;

use App\Models\AboutImage;
use App\Models\Bonus;
use App\Models\Catalog;
use App\Models\Client;
use App\Models\FAQ;
use App\Models\Social;
use App\Models\Video;
use App\Models\YouTube;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function locale($lang)
    {
        App::setLocale($lang);
        Session::put('locale', $lang);

        return redirect()->back();
    }

    public function index()
    {
        seo()
            ->social(Social::whereIn('key', ['telegram', 'instagram', 'facebook', 'tiktok'])->pluck('value'))
            ->title(__('index.title'))
            ->description(__('index.description'))
            ->logo(asset('logo/ru.png'));

        $videos = Video::all();
        $bonuses = Bonus::where('status', 1)->get();
        $catalogs = Catalog::where('status', 1)->get();
        $youtubes = YouTube::where('status', 1)->get();
        $show_question_banner = true;

        return view('pages.index', compact('videos', 'bonuses', 'catalogs', 'youtubes', 'show_question_banner'));
    }

    public function about()
    {
        $abouts = AboutImage::all();
        $video = Video::where('key', 'about')->first();
        $clients = Client::where('status', 1)->get();
        $faqs = FAQ::where('status', 1)->get();
        $youtubes = YouTube::where('status', 1)->get();
        $show_question_banner = true;

        return view('pages.about', compact('abouts', 'video', 'clients', 'faqs', 'youtubes', 'show_question_banner'));
    }

    public function faq()
    {
        $faqs = FAQ::where('status', 1)->get();
        $show_question_banner = true;

        return view('pages.faq', compact('faqs', 'show_question_banner'));
    }

    public function contacts()
    {
        $socials = Social::all();

        return view('pages.contacts', compact('socials'));
    }
}
