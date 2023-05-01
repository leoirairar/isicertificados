<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Http\Controllers\ErrorLogController;
use DB;
use \Exception;

class EnrollmentExportSheets implements FromCollection, WithTitle, WithHeadings
{
    public function __construct(int $courseProgrammingId, string $name, $courseNames)
    {
        $this->courseProgrammingId = $courseProgrammingId;
        $this->name  = $name;
        $this->courseNames = $courseNames;
    }
    
     /**
     * @return Builder
     */
    public function collection()
    {
        try{
            
            $enroll = DB::table('employees')
                   ->join('users', 'users.id', '=', 'employees.user_id')
                   ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                   ->join('course_certificates','course_certificates.enrollments_id','=','course_employees_enrollment.id')
                   ->join('bills','bills.enrollments_id', '=' ,'course_employees_enrollment.id')
                   ->join('companies', 'companies.id', '=', 'employees.company_id')
                   ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                   ->join('courses','courses.id', '=' ,'course_programming.course_id')
                   ->join('course_instructor', 'course_instructor.course_programming_id', '=', 'course_programming.id')
                   ->join('instructors', 'instructors.id', '=', 'course_instructor.instructor_id')
                   ->join('users as userInstructor', 'userInstructor.id', '=', 'instructors.user_id')
                   ->select('course_certificates.isi_code_certification as isi_code_certification',
                            DB::raw('CONCAT(users.name, " ", users.last_name) AS full_name'),
                            'users.identification_number as identification_number',
                            DB::raw('CONCAT(courses.name, " ", courses.course_code) AS course_name'),
                            'course_programming.begin_date',
                            DB::raw('CONCAT(userInstructor.name, " ", userInstructor.last_name) AS instructor_name'),           
                            'companies.company_name as company_name'

                   )
                   ->where('course_instructor.supervisor','=',0)
                   ->where('course_certificates.statement' ,'=',1)
                   ->where('course_employees_enrollment.cancel' ,'=',0)
                   ->where('course_employees_enrollment.reschedule' ,'=',0)
                   ->where('course_programming.status' ,'=',1)
                   ->where('course_programming.course_id' ,'=',$this->courseProgrammingId)
                   ->get();

            return $enroll;

        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        } catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
    }

    /**
     * @return string
     */
    public function title(): string
    { 
        try{
            
            $nameExist = $this->courseNames->search($this->name);
            if ($nameExist) {
                $shortName = substr($this->name, 0, 27).'_';
            }else {
                $shortName = substr($this->name, 0, 28);
            }
            return $shortName; 

        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        } catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
    }

    public function headings(): array
    {
        try{
            return[
                'CODIGO',
                'NOMBRE',
                'CEDULA',
                'NIVEL',
                'FECHA',
                'ENTRENADOR',
                'EMPRESA',
            ];

        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        } catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
    }
}
