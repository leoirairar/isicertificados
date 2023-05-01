<?php

namespace App\Exports;

use App\CourseProgramming;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AttendanceExport implements FromView,WithEvents
{
    public function __construct($id = null)
    {
        //$this->id = $id;
       $this->courseEnrollment =  $courseEnrollment = CourseProgramming::where('id',$id)
        ->with(['employeeEnrollment'=> function($query){
            $query->where('cancel',0);
            $query->with('employee.user','employee.company','employee.academicDegree');
        }])
        ->with(
            'course',
            'courseDays'
            )->first();
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        
            $this->courseEnrollment->employeeEnrollment->prepend(null);
            return view('layouts.attendanceExcel', [
                'courseEnrollment' => $this->courseEnrollment
            ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:V1'; 
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);

                $styleArray = [
                    'fill' => [
                        
                            'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => 'ff9933'],
                        ]
                ];

                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'ff9933',
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A2:V2')->applyFromArray($styleArray);
                $alphabet = range('A','Z');
                $position = array();
                //dd($this->courseEnrollment->courseDays);
                 for ($i=1; $i <=5; $i++) { 
                    $position[] = ($this->courseEnrollment->courseDays->count()+4)+$i;   
                }
                $event->sheet->setCellValue($alphabet[$position[0]].'2', 'CC');
                $event->sheet->setCellValue($alphabet[$position[1]].'2', 'SS');
                $event->sheet->setCellValue($alphabet[$position[2]].'2', 'CM');
                $event->sheet->setCellValue($alphabet[$position[3]].'2', 'CA');
                $event->sheet->setCellValue($alphabet[$position[4]].'2', 'RH');
    
            },
        ];
    }

    public function startRow() {
     return 3;
    }

}
