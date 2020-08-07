<?php


namespace App\Imports;


use App\Champion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AttributeImport implements ToCollection, WithStartRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $csvLine)
        {
            $name = $csvLine[0];
            $champion = Champion::where('name', $name)->first();
            if($csvLine->contains('Mage')) {
                $champion->role = 'Mage';
            } else if($csvLine->contains('Marksman')) {
                $champion->role = 'Marksman';
            } else if($csvLine->contains('Hyper Carry')) {
                $champion->role = 'Carry';
            } else if($csvLine->contains('Enchanter')) {
                $champion->role = 'Enchanter';
            } else {
                continue;
            }

            $champion->save();
        }

    }

    public function startRow(): int
    {
        return 2;
    }
}

