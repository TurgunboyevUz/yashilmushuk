<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale(session('locale', 'uz-latn'));

        $socials = View::getShared()['socials'];

        if (app()->getLocale() == 'ru') {
            $contact_button = [
                'label' => 'WhatsApp',
                'icon' => 'whatsapp',
                'url' => $socials->where('key', 'whatsapp')->first()->value,
            ];
        } else {
            $contact_button = [
                'label' => 'Telegram',
                'icon' => 'telegram',
                'url' => $socials->where('key', 'telegram')->first()->value,
            ];
        }

        View::share('contact_button', $contact_button);

        return $next($request);
    }
}
