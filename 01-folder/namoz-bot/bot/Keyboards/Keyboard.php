<?php

namespace Bot\Keyboards;

trait Keyboard
{
    public function main_key()
    {
        return inlineKeyboard([
            ['text' => "🕓 Namoz vaqtlari", 'callback_data' => 'pray-time'],
            ['text' => "📚 Namoz darslari", 'callback_data' => 'pray-lessons'],
            ['text' => "🎧 Suralar", 'callback_data' => 'pray-surahs'],
        ]);
    }

    public function back_key()
    {
        return inlineKeyboard([
            ['text' => '🔙 Orqaga', 'callback_data' => 'back'],
        ]);
    }

    public function times_key()
    {
        return inlineKeyboard([
            [['text' => "📍 Toshkent", 'callback_data' => 'time/27'], ['text' => "📍 Andijon", 'callback_data' => 'time/1']],
            [['text' => "📍 Buxoro", 'callback_data' => 'time/4'], ['text' => "📍 Jizzax", 'callback_data' => 'time/9']],
            [['text' => "📍 Qarshi", 'callback_data' => 'time/25'], ['text' => "📍 Namangan", 'callback_data' => 'time/15']],
            [['text' => "📍 Navoiy", 'callback_data' => 'time/14'], ['text' => "📍 Samarqand", 'callback_data' => 'time/18']],
            [['text' => "📍 Guliston", 'callback_data' => 'time/5'], ['text' => "📍 Termiz", 'callback_data' => 'time/74']],
            [['text' => "📍 Farg'ona", 'callback_data' => 'time/37'], ['text' => "📍 Xorazm", 'callback_data' => 'time/78']],
            ['text' => "📍 Nukus", 'callback_data' => 'time/16'],
            ['text' => "🔙 Orqaga", 'callback_data' => 'back']
        ]);
    }

    public function update_time_key($id)
    {
        return inlineKeyboard([
            ['text' => "🔄 Yangilash", 'callback_data' => 'time/' . $id],
            ['text' => "🔙 Orqaga", 'callback_data' => 'back'],
        ]);
    }

    public function gender_key()
    {
        return inlineKeyboard([
            ['text' => "👳‍♂ Erkaklar uchun", 'callback_data' => 'gender/male'],
            ['text' => "🧕 Ayollar uchun", 'callback_data' => 'gender/female'],
            ['text' => "🔙 Orqaga", 'callback_data' => 'back']
        ]);
    }

    public function male_key()
    {
        return inlineKeyboard([
            [['text' => "Bomdod", 'callback_data' => 'male/4'], ['text' => "Peshin", 'callback_data' => 'male/5']],
            [['text' => "Asr", 'callback_data' => 'male/6'], ['text' => "Shom", 'callback_data' => 'male/7']],
            [['text' => "Xufton", 'callback_data' => 'male/8'], ['text' => "Vitr", 'callback_data' => 'male/9']],
            [['text' => "Tahajjud", 'callback_data' => 'male/11'], ['text' => "Tahorat", 'callback_data' => 'male/12']],
            [['text' => "Tahorat olish", 'callback_data' => 'male/2'], ['text' => "Namoz qoidalari", 'callback_data' => 'male/3']],
            ['text' => "Namozga kechikkan odam", 'callback_data' => 'male/13'],
            ['text' => "Namozdagi xatoliklar", 'callback_data' => 'male/14'],
            ['text' => "🔙 Orqaga", 'callback_data' => 'back']
        ]);
    }

    public function female_key()
    {
        return inlineKeyboard([
            [['text' => "Bomdod", 'callback_data' => 'female/18'], ['text' => "Peshin", 'callback_data' => 'female/19']],
            [['text' => "Asr", 'callback_data' => 'female/20'], ['text' => "Shom", 'callback_data' => 'female/21']],
            [['text' => "Xufton", 'callback_data' => 'female/22'], ['text' => "Tahajjud", 'callback_data' => 'female/23']],
            ['text' => "Eng muhim qoidalar", 'callback_data' => 'female/17'],
            ['text' => "🔙 Orqaga", 'callback_data' => 'back']
        ]);
    }

    public function surahs_key()
    {
        return inlineKeyboard([
            ['text' => "🎞 Video", 'callback_data' => 'video'],
            ['text' => "🎧 Audio", 'url' => env('APP_AUDIO_CHANNEL')],
            ['text' => '🔙 Orqaga', 'callback_data' => 'back'],
        ]);
    }

    public function page_key($page = 1)
    {
        $list = [
            'Fotiha' => 2, 'Baqara' => 3, 'Oli Imron' => 4, 'Niso' => 5, 'Moida' => 6, 'An`om' => 7,
            'A`rof' => 8, 'Anfol' => 9, 'Tavba' => 10, 'Yunus' => 11, 'Hud' => 12, 'Yusuf' => 13,
            'Rad' => 14, 'Ibrahim' => 15, 'Hijr' => 16, 'Nahl' => 17, 'Isro' => 18, 'Kahf' => 19,
            'Maryam' => 20, 'Toho' => 21, 'Anbiyo' => 22, 'Haj' => 23, 'Muminun' => 24, 'Nur' => 25,
            'Furqon' => 26, 'Shu`aro' => 27, 'Naml' => 28, 'Qasas' => 29, 'Ankabut' => 30, 'Rum' => 31,
            'Luqmon' => 32, 'Sajda' => 33, 'Ahzob' => 34, 'Sab`a' => 35, 'Fotir' => 36, 'Yosin' => 37,
            'As-Soffot' => 38, 'Sad' => 39, 'Zumar' => 40, 'G\'ofir' => 41, 'Fussilat' => 42, 'Shuaro' => 43,
            'Zuhruf' => 44, 'Duxon' => 45, 'Josiya' => 46, 'Ahqof' => 47, 'Muhammad' => 48, 'Fath' => 49,
            'Hujurot' => 50, 'Qof' => 51, 'Az-Zariyot' => 52, 'Tur' => 53, 'Najm' => 54, 'Qamar' => 55,
            'Ar-Rahmon' => 56, 'Voqea' => 57, 'Hadid' => 58, 'Mujodala' => 59, 'Hashr' => 60, 'Mumtahana' => 61,
            'Soff' => 62, 'Munofiqun' => 63, 'Jum`a' => 64, 'Tag\'obun' => 65, 'Taloq' => 66, 'Tahrim' => 68,
            'Mulk' => 69, 'Qalam' => 70, 'Al-Haqqa' => 71, 'Ma\'orij' => 72, 'Nuh' => 73, 'Jin' => 74,
            'Muzammil' => 75, 'Muddassir' => 76, 'Qiyomat' => 77, 'Inson' => 78, 'Mursalot' => 79, 'Naba' => 80,
            'Naziyot' => 81, 'Abasa' => 82, 'Takvir' => 83, 'Infitor' => 84, 'Mutaffifun' => 85, 'Inshiqoq' => 86,
            'Buruj' => 87, 'Toriq' => 88, 'A\'laa' => 89, 'G\'oshiya' => 90, 'Al-Fajr' => 91, 'Balad' => 92,
            'Shams' => 93, 'Layl' => 94, 'Zuho' => 95, 'Sharh' => 96, 'Tiyn' => 97, 'Alaq' => 98, 'Qadr' => 99,
            'Bayyina' => 100, 'Zalzala' => 101, 'Al-Adiyot' => 102, 'Al-Qoriya' => 103, 'Takasur' => 104, 'Humaza' => 105,
            'Asr' => 106, 'Fil' => 107, 'Quraysh' => 108, 'Mo`un' => 109, 'Kavsar' => 110, 'Kafirun' => 111,
            'Nasr' => 112, 'Masad' => 113, 'Ixlos' => 114, 'Falaq' => 115, 'Nos' => 116
        ];

        $slice = array_slice($list, ($page - 1) * 14, 14);
        $chunk = array_chunk($slice, 2, true);

        $keyboard = [];

        foreach($chunk as $item)
        {
            $row = [];

            foreach($item as $key => $value)
            {
                $row[] = ['text' => $key, 'callback_data' => 'surah/' . $value];
            }

            $keyboard[] = $row;
        }

        $row = [];
        $count = 114;
        $ceil = ceil($count / 14);

        if($page > 1 and $page != $ceil){
            $row[] = ['text' => "⬅️", 'callback_data' => 'page/' . ($page - 1)];
        }

        $row[] = ['text' => $page . '/' . $ceil, 'callback_data' => 'null'];

        if($page == $ceil){
            $row[] = ['text' => "⬅️", 'callback_data' => 'page/' . ($page - 1)];
        }

        if($page < $ceil){
            $row[] = ['text' => "➡️", 'callback_data' => 'page/' . ($page + 1)];
        }

        $keyboard[] = $row;
        $keyboard[] = ['text' => "🔙 Orqaga", 'callback_data' => 'back'];

        return inlineKeyboard($keyboard);
    }
}