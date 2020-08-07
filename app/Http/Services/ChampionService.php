<?php


namespace App\Http\Services;


use App\Champion;
use App\Imports\AttributeImport;
use App\Imports\ChampionsImport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;

class ChampionService
{

    public function getChampionsAlphabetically() {
        return Champion::orderBy('name')->get();
    }

    public function getChampionsByRole() {
        return Champion::orderBy('role', 'desc')->orderBy('name')->get();
    }

    public function getRoles() {
        return DB::table('champions')
            ->select('role')
            ->groupBy('role')
            ->orderByDesc('role')
            ->get();
    }

    public function loadChampions() {
        return $this->createChampions();
    }

    private function createChampions() {
        DB::beginTransaction();
        try {
            $csv = $this->getNewestStats();
            $this->createTmpCsvFile($csv);

            Excel::import(new ChampionsImport, public_path() . '/tmp/characters.csv');
            $csv_attr = $this->getNewestAttributes();
            $this->createTmpCsvFile($csv_attr, 'attr');
            Excel::import(new AttributeImport, public_path() . '/tmp/attr.csv');


//            Excel::load('characters.csv')->each(function (Collection $csvLine) {
//
//                Champion::updateOrCreate([
//                    'name' => $csvLine->get('Name'),
//                    'burst' => $csvLine->get('Burst'),
//                    'poke' => $csvLine->get('Poke'),
//                    'basic' => $csvLine->get('Basic Attacks'),
//                    'tank' => $csvLine->get('Tank'),
//                    'sustain' => $csvLine->get('Sustain'),
//                    'utility' => $csvLine->get('Utility'),
//                    'mobility' => $csvLine->get('Mobility'),
//                    'difficulty' => $csvLine->get('Difficulty'),
//                ]);
//
//            });

            $this->deleteTmpCsvFile();
            $this->deleteTmpCsvFile('attr');
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    private function createTmpCsvFile($content ,$name = 'characters') {
        $path = public_path() . '/tmp/';
        if(!File::exists($path)) {
            File::makeDirectory($path);
        }
        $path .= $name . '.csv';

        file_put_contents($path, $content);
    }

    private function deleteTmpCsvFile($name = 'characters') {
        $path = public_path() . '/tmp/' . $name . '.csv';
        File::delete($path);
    }

    private function getNewestStats() {
        $url = 'https://raw.githubusercontent.com/TheBlocks/MyLeagueSim-Data/master/champ_stats/';
        $urlVersions = 'https://github.com/TheBlocks/MyLeagueSim-Data/blob/master/champ_stats/';
        $needle = 'champ_stats_';

        $version = $this->getNewestVersion($urlVersions, $needle);
        $response = Http::get($url . $version);
        if($response->failed()) {
            throw new \Exception();
        }
        return $response->body();
    }

    private function getNewestAttributes() {
        $url = 'https://raw.githubusercontent.com/TheBlocks/MyLeagueSim-Data/master/champ_attributes/';
        $urlVersions = 'https://github.com/TheBlocks/MyLeagueSim-Data/blob/master/champ_attributes/';
        $needle = 'champ_attributes_';
        $version = $this->getNewestVersion($urlVersions, $needle);
        $response = Http::get($url . $version);
        if($response->failed()) {
            throw new \Exception();
        }
        return $response->body();
    }

//    private function getNewestStatVersion()
//    {
//        $url = 'https://github.com/TheBlocks/MyLeagueSim-Data/tree/master/champ_stats/';
//        $html = $this->getNewestVersion($url);
//        $needle = 'champ_stats_';
//        $index = strrpos($html, $needle);
//        $name = $this->getDate() . '/';
//        $length = 45;
////        Other way to get the length
////        $needle2 = '.csv';
////        $index2 = strrpos($response, $needle2) + 3;/
////        $length = $index2 - $index + 1;
//
//        for($i = 0; $i < $length; $i++) {
//            $name .= $html[$index + $i];
//        }
//
//        return $name;
//    }
//
//    private function getNewestAttVersion()
//    {
//        $url = 'https://github.com/TheBlocks/MyLeagueSim-Data/tree/master/champ_stats/';
//        $html = $this->getNewestVersion($url);
//        $needle = 'champ_attributes_';
//        $index = strrpos($html, $needle);
//        $name = $this->getDate() . '/';
//        $length = 50;
////        Other way to get the length
////        $needle2 = '.csv';
////        $index2 = strrpos($response, $needle2) + 3;
////        $length = $index2 - $index + 1;
//
//        for($i = 0; $i < $length; $i++) {
//            $name .= $html[$index + $i];
//        }
//
//        return $name;
//    }

    private function getNewestVersion($url, $needle)
    {
        $date = $this->getDate();
        $response = Http::get($url . $date);
        if ($response->failed()) {
            $date = $this->getDate(false);
            $response = Http::get($url . $date);
        }
        $html = $response->body();

        $index = strrpos($html, $needle);
        $name = $date . '/';

        $needle2 = '.csv';
        $index2 = strrpos($response, $needle2) + 3;
        $length = $index2 - $index + 1;

        for($i = 0; $i < $length; $i++) {
            $name .= $html[$index + $i];
        }

        return $name;
    }

    private function getDate($today = true) {
        return $today ? Carbon::today()->format('Y-m-d')
            : Carbon::yesterday()->format('Y-m-d');
    }
}
