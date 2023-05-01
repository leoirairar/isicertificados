<?php

namespace App\Imports;

use App\ProofAttendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\carbon;

class AdministrativoImport implements ToCollection
{
    public function collection(Collection $rows)
    {   
        foreach ($rows as $row) 
        {
            if ($row[0] != null) {
                ProofAttendance::create([
                    'code' => $row[0],
                    'fullname' => trim($row[1]),
                    'identification' => $row[2],
                    'course' => $row[3],
                    'expedition_date' => $row[4] ,
                    'instructor' => $row[5],
                    'company' => $row[6],
                    'hours' => $row[7],
                ]);
            } else {
                break;
            }
            
            
        }
    }
    // public function model(array $row)
    // {
    //     return new ProofAttendance([
    //         'code' => $row[0],
    //         'fullname' => $row[1],
    //         'indentification' => $row[2],
    //         'course' => $row[3],
    //         'expedition_date' => new Carbon(strtotime($row[4])) ,
    //         'instructor' => $row[5],
    //         'company' => $row[6],
    //     ]);
    // }
}
