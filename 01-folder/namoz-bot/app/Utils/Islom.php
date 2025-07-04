<?php

namespace App\Utils;

use App\Models\Time;
use Illuminate\Support\Facades\Http;

class Islom
{
    public static function getTime($id, $month = null, $day = null)
    {
        $month = $month ?? date('n');
        $day = $day ?? date('j');

        $time = Time::where('month', $month)->where('region_id', $id)->first();

        if(!$time){
            self::load($id);
            
            return self::getTime($id, $day, $month);
        }

        $data = json_decode($time->data, true);
        $filter = array_filter($data, function ($item) use ($day) {
            return $item['day'] == $day;
        });

        return (object) array_shift($filter);
    }

    public static function load($id)
    {
        $times = self::getTimesAsArray($id);

        Time::where('region_id', $id)->delete();
        
        Time::create([
            'region_id' => $id,
            'month' => date('n'),
            'data' => json_encode($times),
        ]);
    }

    public static function getTimesAsArray($id)
    {
        $body = Http::get('https://islom.uz/vaqtlar/' . $id . '/' . date('n'))->body();

        $dom = new \DOMDocument();
        @$dom->loadHTML($body);

        $xpath = new \DOMXPath($dom);
        $query = $xpath->query('//*[@id="large_screen"]/div/div[2]/div/div[5]/div[1]/table/tbody');

        $tbody = $query->item(0);
        $trs = $tbody->getElementsByTagName('tr');

        $arr = [];
        $month_names = ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avqust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'];

        for ($i = 0; $i < $trs->length; $i++) {
            $tr = $trs->item($i);

            $tds = $tr->getElementsByTagName('td');
            $arr[] = [
                'region_id' => $id,
                'day' => $tds->item(1)->textContent,
                'month' => $month_names[date('n') - 1],
                'tong' => $tds->item(3)->textContent,
                'bomdod' => date('H:i', strtotime($tds->item(4)->textContent . ' -40 minutes')),
                'quyosh' => $tds->item(4)->textContent,
                'peshin' => $tds->item(5)->textContent,
                'asr' => $tds->item(6)->textContent,
                'shom' => $tds->item(7)->textContent,
                'xufton' => $tds->item(8)->textContent,
            ];
        }

        return $arr;
    }
}