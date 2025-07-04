<?php

namespace App\Models\File;

use App\Models\User;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;

class LangCertificate extends Model
{
    use Fileable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lang()
    {
        $arr = ['ru' => 'Rus tili', 'en' => 'Ingliz tili', 'de' => 'Nemis tili'];

        return $arr[$this->lang];
    }

    public function type()
    {
        $arr = [
            'national' => 'Milliy sertifikat',
            'cambridge' => 'Cambridge Assessment English (FCE, CAE, CPE)',
            'toefl-itp' => 'Test of English Foreign Language (TOEFL, ITP)',
            'toefl-ibt' => 'Test of English Foreign Language (TOEFL, IBT)',
            'ielts' => 'International English Language Testing System (IELTS)',
            'itep' => 'iTEP Academic — Plus',
        ];

        return $arr[$this->type];
    }
}
