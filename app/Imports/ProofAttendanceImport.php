<?php

namespace App\Imports;

use Carbon\Carbon;
use App\ProofAttendance;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProofAttendanceImport implements WithMultipleSheets 
{
     public function sheets(): array
    {
        return [
            0 => new ReentrenamientoImport(),
            1 => new AvanzadoImport(),
            2 => new CoordinadorImport(),
            3 => new AdministrativoImport(),
            4 => new BasicoImport(),
            //5 => new ConfinadosImport(),
        ];
    }
}
