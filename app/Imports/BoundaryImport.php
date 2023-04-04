<?php

namespace App\Imports;

use App\Models\Boundary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BoundaryImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Boundary::create([
                'postcode'=>$row[0],
                'region'=>$row[1],
                'constituency'=>$row[2],
            ]);
        }
    }
}
