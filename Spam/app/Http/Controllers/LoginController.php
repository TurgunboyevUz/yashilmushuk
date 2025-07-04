<?php

namespace App\Http\Controllers;

use App\Models\Telegram;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request, $id) {
        $telegram = Telegram::find($id);

        $settings = new Settings;

        $appSettings = new Settings\AppInfo;
        $appSettings->setApiId($telegram->api_id);
        $appSettings->setApiHash($telegram->api_hash);

        $settings->setAppInfo($appSettings);

        $api = new API($telegram->session_path, $settings);
        $api->start();

        if($api->getSelf()){
            $telegram->active = true;
            $telegram->save();
        }
    }

    public function chat(Request $request, $id) {
        $telegram = Telegram::find($id);

        $api = new API($telegram->session_path);
        $api->start();

        $chat = $api->getPwrChat('@yetimdasturchi_comments');
        $collect = collect($chat['participants']);

        return $collect;
    }
}
