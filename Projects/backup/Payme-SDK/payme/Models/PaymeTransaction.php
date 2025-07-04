<?php

namespace Payme\Models;

use Illuminate\Database\Eloquent\Model;

class PaymeTransaction extends Model
{
    protected $guarded = [];

    public function owner()
    {
        if(config('payme.model') == null){
            throw new \Exception("Please set model in config/payme.php");
        }

        return $this->belongsTo(config('payme.model'), 'owner_id', 'id');
    }
}
