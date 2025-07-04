<?php
namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SergiX44\Nutgram\Nutgram;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    use HttpResponse;

    public function handle(Request $request, Closure $next): Response
    {
        $bot = app(Nutgram::class);

        $request->setUserResolver(function () use ($bot, $request) {
            if ($request->has('telegram_id')) {
                return User::where('telegram_id', $request->telegram_id)->first();
            }

            if (! $request->header('X-Telegram-Init-Data') || empty($request->header('X-Telegram-Init-Data'))) {
                return null;
            }

            try {
                $data = $bot->validateWebAppData($request->header('X-Telegram-Init-Data'));

                $user = User::where('telegram_id', $data->user->id)->first();

                if ($user) {
                    return $user;
                }

                $user = User::create([
                    'telegram_id' => $data->user->id,
                    'name'        => $data->user->first_name,
                    'username'    => $data->user->username
                ]);

                return $user;
            } catch (\Exception $e) {
                return null;
            }
        });

        if (! $request->user()) {
            return $this->error('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
