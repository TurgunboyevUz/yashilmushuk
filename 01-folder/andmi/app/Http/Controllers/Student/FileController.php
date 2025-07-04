<?php

namespace App\Http\Controllers\Student;

use App\Facade\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreAchievementRequest;
use App\Http\Requests\Student\StoreArticleRequest;
use App\Http\Requests\Student\StoreDistinguishedScholarshipRequest;
use App\Http\Requests\Student\StoreGrandEconomyRequest;
use App\Http\Requests\Student\StoreInventionRequest;
use App\Http\Requests\Student\StoreLangCertificateRequest;
use App\Http\Requests\Student\StoreOlympicRequest;
use App\Http\Requests\Student\StoreScholarshipRequest;
use App\Http\Requests\Student\StoreStartupRequest;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function article(StoreArticleRequest $request)
    {
        File::user($request)->article($request);

        $this->upload_toast('Maqola');

        return redirect()->route($request->route()->getName());
    }

    public function scholarship(StoreScholarshipRequest $request)
    {
        File::user($request)->scholarship($request);

        $this->upload_toast('Stipendiyat');

        return redirect()->route($request->route()->getName());
    }

    public function invention(StoreInventionRequest $request)
    {
        File::user($request)->invention($request);

        $this->upload_toast('Ixtiro');

        return redirect()->route($request->route()->getName());
    }

    public function startup(StoreStartupRequest $request)
    {
        File::user($request)->startup($request);

        $this->upload_toast('Startup');

        return redirect()->route($request->route()->getName());
    }

    public function grand_economy(StoreGrandEconomyRequest $request)
    {
        File::user($request)->grand_economy($request);

        $this->upload_toast('Shartnoma');

        return redirect()->route($request->route()->getName());
    }

    public function olympics(StoreOlympicRequest $request)
    {
        File::user($request)->olympics($request);

        $this->upload_toast('Olimpiada');

        return redirect()->route($request->route()->getName());
    }

    public function lang_certificate(StoreLangCertificateRequest $request)
    {
        File::user($request)->lang_certificate($request);

        $this->upload_toast('Til sertifikati');

        return redirect()->route($request->route()->getName());
    }

    public function distinguished_scholarship(StoreDistinguishedScholarshipRequest $request)
    {
        File::user($request)->distinguished_scholarship($request);

        $this->upload_toast('Ariza');

        return redirect()->route($request->route()->getName());
    }

    public function achievement(StoreAchievementRequest $request)
    {
        File::user($request)->achievement($request);

        $this->upload_toast('Yutuqlar');

        return redirect()->route($request->route()->getName());
    }

    public function destroy_article(Request $request)
    {
        File::destroy_article($request->input('id'));

        $this->destroy_toast('Maqola');

        return redirect()->back();
    }

    public function destroy_scholarship(Request $request)
    {
        File::destroy_scholarship($request->input('id'));

        $this->destroy_toast('Stipendiyat');

        return redirect()->back();
    }

    public function destroy_invention(Request $request)
    {
        File::destroy_invention($request->input('id'));

        $this->destroy_toast('Ixtiro');

        return redirect()->back();
    }

    public function destroy_startup(Request $request)
    {
        File::destroy_startup($request->input('id'));

        $this->destroy_toast('Startup');

        return redirect()->back();
    }

    public function destroy_grand_economy(Request $request)
    {
        File::destroy_grand_economy($request->input('id'));

        $this->destroy_toast('Shartnoma');

        return redirect()->back();
    }

    public function destroy_olympics(Request $request)
    {
        File::destroy_olympics($request->input('id'));

        $this->destroy_toast('Olimpiada');

        return redirect()->back();
    }

    public function destroy_lang_certificate(Request $request)
    {
        File::destroy_lang_certificate($request->input('id'));

        $this->destroy_toast('Til sertifikati');

        return redirect()->back();
    }

    public function destroy_distinguished_scholarship(Request $request)
    {
        File::destroy_distinguished_scholarship($request->input('id'));

        $this->destroy_toast('Ariza');

        return redirect()->back();
    }

    public function destroy_achievement(Request $request)
    {
        File::destroy_achievement($request->input('id'));

        $this->destroy_toast('Yutuqlar');

        return redirect()->back();
    }

    public function upload_toast($file_type)
    {
        toast($file_type.' muvaffaqiyatli yuklandi!', 'success', 'top-end')->width('25rem')
            ->background('#f5f6f7')
            ->showCloseButton()
            ->timerProgressBar();
    }

    public function destroy_toast($file_type)
    {
        toast($file_type.' muvaffaqiyatli o\'chirildi!', 'info', 'top-end')->width('25rem')
            ->background('#f5f6f7')
            ->showCloseButton()
            ->timerProgressBar();
    }
}