<?php

namespace App\Http\Controllers;

use App\EmployeeEnrollment;
use App\CourseCertificate;
use App\Company;
use App\Course;
use App\Charts\chartController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Response;

class StatisticsController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $companies = Company::orderby('company_name')->get();
        $courses = Course::orderby('name')->get();
        
        return view('showCharts',compact('companies','courses'));
    }


    public function getCertificateUsersBetweenDates($date1,$date2,$companyId,$courseId)
    {
        $date1 = new Carbon($date1);
        $date2 = new Carbon($date2);

        $date1->diffInWeeks($date2);

        $firtsDayOfWeek =  Carbon::parse($date1);
        $lastDayOfWeek = Carbon::parse($date1);

        $certificatesUSersCollection = collect();
        $datesCertificateUsersCollection = collect();

        for ($i=0; $i <= $date1->diffInWeeks($date2) ; $i++) { 
            
            //var_dump($firtsDayOfWeek->startOfWeek()->format('Y-m-d'));

            
                $certificatesUSers = DB::table('course_certificates')
                                        ->join('course_employees_enrollment', 'course_certificates.enrollments_id', '=', 'course_employees_enrollment.id')
                                        ->join('employees', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                        ->join('courses', 'course_programming.course_id', '=', 'courses.id')
                                        ->select(
                                            DB::raw('COUNT(course_certificates.id) as certificates')
                                            
                                        )
                                        ->where('course_certificates.statement', '=', 1)
                                        ->where('course_programming.begin_date','>=',$firtsDayOfWeek->startOfWeek()->format('Y-m-d'))
                                        ->where('course_programming.begin_date','<=', $lastDayOfWeek->endOfWeek()->format('Y-m-d'));

                                        if($companyId != "null" && $courseId != "null"){
                                            $certificatesUSers->where('employees.company_id', $companyId);
                                            $certificatesUSers = $certificatesUSers->where('courses.id', $courseId)->get();
                                        }elseif ($companyId != "null" && $courseId == "null") {
                                            $certificatesUSers = $certificatesUSers->where('employees.company_id', $companyId)->get();
                                        }elseif ($companyId == "null" && $courseId != "null") {
                                            $certificatesUSers = $certificatesUSers->where('courses.id', $courseId)->get();
                                        }
                                        else{
                                            $certificatesUSers = $certificatesUSers->get();
                                        }
                                        


                $certificatesUSersCollection->push($certificatesUSers[0]->certificates);
                $datesCertificateUsersCollection->push($firtsDayOfWeek->startOfWeek()->format('Y-m-d')." al ".$lastDayOfWeek->endOfWeek()->format('Y-m-d'));
            
            $firtsDayOfWeek->addWeek();
            $lastDayOfWeek->addWeek();
        }

        //dd($datesCertificateUsersCollection);

        // $chart = new chartController();
        // $chart->labels($datesCertificateUsersCollection);
        // $chart->dataset('Empleados certificados', 'line', $certificatesUSersCollection)
        // ->color("#ffffff")
        // ->backgroundcolor("#fc6002");
        // return view('charts.certificateByDates', compact('chart'));
        
        return Response::json(['certificatesUSersCollection'=>$certificatesUSersCollection,'datesCertificateUsersCollection'=>$datesCertificateUsersCollection]);
    }

    public function getCertificatesUsersVsUncertificate($date1,$date2,$companyId,$courseId)
    {

        $certificatesEmployess = DB::table('course_certificates')
                                        ->join('course_employees_enrollment', 'course_certificates.enrollments_id', '=', 'course_employees_enrollment.id')
                                        ->join('employees', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                        ->join('courses', 'course_programming.course_id', '=', 'courses.id')
                                        ->select(
                                            DB::raw('COUNT(course_certificates.id) as certificates')
                                            
                                        )
                                        ->where('course_certificates.statement', '=', 1)
                                        ->where('course_programming.begin_date','>=',$date1)
                                        ->where('course_programming.begin_date','<=', $date2);

                                        if($companyId != "null" && $courseId != "null"){
                                            $certificatesEmployess->where('employees.company_id', $companyId);
                                            $certificatesEmployess = $certificatesEmployess->where('courses.id', $courseId)->get();
                                        }elseif ($companyId != "null" && $courseId == "null") {
                                            $certificatesEmployess = $certificatesEmployess->where('employees.company_id', $companyId)->get();
                                        }elseif ($companyId == "null" && $courseId != "null") {
                                            $certificatesEmployess = $certificatesEmployess->where('courses.id', $courseId)->get();
                                        }
                                        else{
                                            $certificatesEmployess = $certificatesEmployess->get();
                                        }
                                        



        $uncertificatesUsers = DB::table('course_certificates')
                                        ->join('course_employees_enrollment', 'course_certificates.enrollments_id', '=', 'course_employees_enrollment.id')
                                        ->join('employees', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                        ->join('courses', 'course_programming.course_id', '=', 'courses.id')
                                        ->select(
                                            DB::raw('COUNT(course_certificates.id) as certificates')

                                        )
                                        ->where('course_certificates.statement', '=', 0)
                                        ->where('course_programming.begin_date','>=',$date1)
                                        ->where('course_programming.begin_date','<=', $date2);

                                        if($companyId != "null" && $courseId != "null"){
                                            $uncertificatesUsers->where('employees.company_id', $companyId);
                                            $uncertificatesUsers = $uncertificatesUsers->where('courses.id', $courseId)->get();
                                        }elseif ($companyId != "null" && $courseId == "null") {
                                            $uncertificatesUsers = $uncertificatesUsers->where('employees.company_id', $companyId)->get();
                                        }elseif ($companyId == "null" && $courseId != "null") {
                                            $uncertificatesUsers = $uncertificatesUsers->where('courses.id', $courseId)->get();
                                        }
                                        else{
                                            $uncertificatesUsers = $uncertificatesUsers->get();
                                        }
                                        

        return Response::json(['certificatesEmployess'=>$certificatesEmployess,'uncertificatesUsers'=>$uncertificatesUsers]);
    

    }

    

    public function getEnrolledEmployeesGroupByCurses($date1,$date2,$companyId,$courseId)
    {

        $employeesByCourses = DB::table('course_employees_enrollment')
        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
        ->join('employees', 'employees.id', '=', 'course_employees_enrollment.employee_id')
        ->join('courses', 'courses.id', '=', 'course_programming.course_id')
        ->select(
            DB::raw('COUNT(course_employees_enrollment.id) as enrolled'),
            'courses.id'
            
        )
        ->where('course_employees_enrollment.status_employee', '=', 1)
        ->where('course_employees_enrollment.cancel', '=', 0)
        ->where('course_employees_enrollment.reschedule', '=', 0)
        ->where('course_programming.begin_date','>=',$date1)
        ->where('course_programming.begin_date','<=', $date2);

        if($companyId != "null" && $courseId != "null"){
            $employeesByCourses->where('employees.company_id', $companyId);
            $employeesByCourses = $employeesByCourses->where('courses.id', $courseId)->groupBy('courses.id')
            ->orderBy('courses.id')
            ->get();
        }elseif ($companyId != "null" && $courseId == "null") {
            $employeesByCourses = $employeesByCourses->where('employees.company_id', $companyId)->groupBy('courses.id')
            ->orderBy('courses.id')
            ->get();
        }elseif ($companyId == "null" && $courseId != "null") {
            $employeesByCourses = $employeesByCourses->where('courses.id', $courseId)->groupBy('courses.id')
            ->orderBy('courses.id')
            ->get();
        }
        else{
            $employeesByCourses = $employeesByCourses->groupBy('courses.id')
            ->orderBy('courses.id')
            ->get();
        }

        

        $coursesLabels = DB::table('courses')->select('courses.name','courses.id')->orderBy('courses.id')->get();


        $employeesByCourse = collect();
        $coursesLabel = collect();
        $backGroundColor = collect();
        $borderColor = collect();

         foreach ($coursesLabels as $value) {
             $flag = false;
            foreach ($employeesByCourses as $value2) {
                if (!$flag) {
                    if($value->id == $value2->id)
                    {
                        $employeesByCourse->push($value2->enrolled);
                        $flag = true;
                    }
                }
                
            }

            if ($flag == false) {
                $employeesByCourse->push(0);
            }
            
         }

        foreach ($coursesLabels as $value) {
            $coursesLabel->push($value->name);
            $backGroundColor->push('#fc6002');
            $borderColor->push('#ffffff');
        }

        return Response::json(['employeesByCourse'=>$employeesByCourse,'coursesLabel'=>$coursesLabel,'backGroundColor'=>$backGroundColor,'borderColor'=>$borderColor]);
    }
}
