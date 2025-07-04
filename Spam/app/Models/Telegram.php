<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    protected $fillable = [
        'name',
        'api_id',
        'api_hash',
        'phone',
        'session_path',
        'last_send_message_at',
        'start_send_message_at',
        'today_send_message_count',
        'active',
    ];
}
