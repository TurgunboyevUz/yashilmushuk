<?php

use App\Http\Controllers\LoginController;
use App\Models\Telegram;
use danog\MadelineProto\API;
use danog\MadelineProto\PeerNotInDbException;
use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\RPCError\PrivacyPremiumRequiredError;
use Illuminate\Support\Facades\Route;

Route::any('/login/{id}', [LoginController::class, 'login'])->name('login');
Route::any('/chat/{id}', [LoginController::class, 'chat'])->name('chat');

Route::get('/message', function () {
    $tg = Telegram::find(1);

    $api = new API($tg->session_path);
    $api->start();

    try {
        dd($api->sendMessage('6317366151', 'Hello')); //7037720962, 6317366151
    }catch(PeerNotInDbException $e){
        $pwr = $api->getInfo('6317366151');

        dd($pwr);
    } catch (PrivacyPremiumRequiredError $e) {
        //
    } catch (RPCErrorException $e) {
        if ($e->getMessage() == 'PEER_FLOOD' and mb_stripos($e->description, 'spam') !== false) {
            $tg->active = 2;
            $tg->save();
        }
    } catch (Throwable $e) {
        dd($e);
    }
});
