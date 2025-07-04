<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $guarded = [];

    public static function add_id($user_id, $channel_id)
    {
        $data = self::firstOrCreate(['user_id' => $user_id]);
        $json = json_decode($data->data, true);

        $json[] = $channel_id;

        return $data->update(['data' => json_encode($json)]);
    }
}
