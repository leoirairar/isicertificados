<?php

namespace App\Exports;

use DB;
use App\CourseProgramming;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;


class CourseProgrammingExport implements FromCollection,WithHeadings
{
    public function __construct($id = null)
    {
        $this->id = $id;
    }
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    * es por curso programado. 
    */
    public function collection()
    {
        $arrayCollection = collect();
        $arrayEmployees = DB::table('employees')
            ->join('users as employeeUser', 'employeeUser.id', '=', 'employees.user_id')
            ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
            ->join('course_certificates','course_certificates.enrollments_id','=','course_employees_enrollment.id')
            ->join('academic_degrees','academic_degrees.id','=','employees.academy_degree_id')
            ->join('bills','bills.enrollments_id', '=' ,'course_employees_enrollment.id')
            ->join('companies', 'companies.id', '=', 'employees.company_id')
            ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
            ->join('courses','courses.id', '=' ,'course_programming.course_id')
            ->join('course_instructor', 'course_instructor.course_programming_id', '=', 'course_programming.id')
            ->join('instructors', 'instructors.id', '=', 'course_instructor.instructor_id')
            ->join('users as userInstructor', 'userInstructor.id', '=', 'instructors.user_id')
            ->select(
                    'employeeUser.document_type',
                    'employeeUser.identification_number as identification_number',
                    'employeeUser.name',
                    'employeeUser.last_name',
                    'employees.birthdate',
                    'academic_degrees.name as degreeName',
                    'employees.position'

            )
            ->where('course_certificates.statement','=', 1)
            ->where('bills.payment_status','=',1)
            ->where('course_instructor.supervisor','=',0)
            ->where('course_programming.id','=',$this->id)
            ->get();

        foreach ($arrayEmployees as $value) {
            $name = explode(" ", $value->name);
            $lastName =  explode(" ", $value->last_name);
            $arrayCollection->add([
                $value->document_type,
                $value->identification_number, 
                (isset($name[0])?$name[0]:""), 
                (isset($name[1])?$name[1]:""), 
                (isset($lastName[0])?$lastName[0]:""), 
                (isset($lastName[1])?$lastName[1]:""), 
                'M', 
                'COLOMBIA', 
                 $value->birthdate, 
                 $value->degreeName, 
                'OPERATIVO',
                $value->position,
            ]);
        }

        return $arrayCollection;
        
    }

    public function headings(): array
    {
        return[
            'tipo_documento',
            'documento',
            'priner nombre',
            'segundo nombre',
            'primer apellido',
            'segundo apellido',
            'genero',
            'pais nacimiento',
            'fecha nacimiento',
            'nivel educativo',
            'area de trabajo',
            'cargo actual',
        ];
    }
}
