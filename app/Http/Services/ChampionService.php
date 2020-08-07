<?php


namespace App\Http\Services;


use App\Champion;
use App\Imports\ChampionsImport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ChampionService
{
    public function getChampions() {
        return $this->createChampions();
    }

    private function createChampions() {
        DB::beginTransaction();
        try {
            $csv = $this->getNewestStats();
            $this->createTmpCsvFile($csv);

            Excel::import(new ChampionsImport, public_path() . '/tmp/characters.csv');

            $this->deleteTmpCsvFile();
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
        $version = $this->getNewestVersion();
        $response = Http::get($url . $version);
        if($response->failed()) {
            throw new \Exception();
        }
        return $response->body();
    }

    private function getNewestVersion() {
        $url = 'https://github.com/TheBlocks/MyLeagueSim-Data/tree/master/champ_stats/';
        $date = Carbon::today()->format('Y-m-d');
        $response = Http::get($url . $date);
        if($response->failed()) {
            $date = Carbon::yesterday()->format('Y-m-d');
            $response = Http::get($url . $date);
        }
        $html = $response->body();
        $needle = 'champ_stats_';
        $index = strrpos($html, $needle);
        $name = $date . '/';
        $length = 45;
//        Other way to get the length
//        $needle2 = '.csv';
//        $index2 = strrpos($response, $needle2) + 3;
//        $length = $index2 - $index + 1;

        for($i = 0; $i < $length; $i++) {
            $name .= $html[$index + $i];
        }

        return $name;
    }
}
