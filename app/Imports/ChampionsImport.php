<?php


namespace App\Imports;

use App\Champion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChampionsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $data = [];
        $index = 0;
        foreach ($rows as $csvLine)
        {

            $data[$index++] = [
                'name' => $csvLine->get('name'),
                'burst' => $csvLine->get('burst'),
                'poke' => $csvLine->get('poke'),
                'basic' => $csvLine->get('basic_attacks'),
                'tank' => $csvLine->get('tank'),
                'sustain' => $csvLine->get('sustain'),
                'utility' => $csvLine->get('utility'),
                'mobility' => $csvLine->get('mobility'),
                'difficulty' => $csvLine->get('difficulty'),
            ];
        }
        Champion::insertOnDuplicateKey($data);

    }
}
