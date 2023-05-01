<?php

namespace App\Exports;

use App\Course;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EnrollmentExport implements WithMultipleSheets
{
   
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $courseNames = collect();
        $Courses = Course::orderBy('id')->get();
        foreach ($Courses as $value) {
            $courseNames->push($value->name);
        }
        
        $sheets = [];
        foreach ($Courses as $Course) {
           
            $sheets[] = new EnrollmentExportSheets($Course->id,$Course->name,$courseNames);
        }
        return $sheets;
    }
}
