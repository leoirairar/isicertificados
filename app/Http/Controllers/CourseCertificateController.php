<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseCertificate;
use App\CourseProgramming;
use App\Company;
use App\EmployeeEnrollment;
use App\Bill;
use App\CourseDays;
use App\CourseInstructor;
use App\EmployeeClassAttendance;
use App\CompanyAdministrator;
use App\Consecutive;
use Response;
use DB;
use PDF;
use App;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use \ZipArchive;
use \Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;
use App\Mail\zipCertificateMail;
use App\User;
use App\ProofAttendance;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils;

class CourseCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['getAttendaceCertificateView','getEmployeeAttendaceCertificate','viewAttedanceCertificate','viewAttedanceCertificateHistorical','getAttendaceCertificateViewWeb']]);
        setlocale(LC_ALL,'es_ES.UTF-8');
        PDF::setOptions(['defaultFont' => 'Helvetica']);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $coursesProgrammed = CourseProgramming::orderBy('begin_date','DESC')->where('status',1)->with('course')->get();
            if (Auth::user()->role == 'A') {
                $companies = collect();
                $companiesAdministrator = CompanyAdministrator::where('user_id',Auth::user()->id)->with('company')->get();
                foreach ($companiesAdministrator as $companyAdministrator) {
                    $companies->push($companyAdministrator->company);
                }

            }
            else{
                $companies = Company::where('id','!=',1)->get();
            }

            return view('showEmployeeCertificate',compact('coursesProgrammed','companies'));

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
        $courseProgrammed = CourseProgramming::where('id',$request->programmedCourseId)->with('course.consecutive')->first();
        if($courseProgrammed->status == 0){
            $courseProgrammed->status = 1;
            $courseProgrammed->save();

            $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',$request->company_id)->get();
            $notificationData['detail'] = "Se ha finalizado el curso ".$courseProgrammed->course->name." con fecha de programación ".$courseProgrammed->begin_date;
            $notificationData['adminId'] = $companyAdministrator;
            $notificationData['url'] = "";
            NotificationController::store($notificationData);

            foreach ($companyAdministrator as $compAdmin) {

                $data = new \stdClass();
                $data->message = $notificationData['detail'];
                $data->subject = "Finalización de curso.";
                Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
            }

        }


        //dd($request);
        if($request->courseInstructorId == null){

            $instructor  = new CourseInstructor();
            $instructor->instructor_id = $request->instructorId;
            $instructor->course_programming_id = $request->programmedCourseId;
            $instructor->supervisor = 0;
            $instructor->status = 1;
            $instructor->save();

        }else{
            $instructor = CourseInstructor::where('id','=',$request->courseInstructorId)->first();
            $instructor->instructor_id = $request->instructorId;
            $instructor->save();
        }



        //dd($supervisor);
        if($request->courseSupervisorId == null){

            $supervisor  = new CourseInstructor();
            $supervisor->instructor_id = $request->supervisorId;
            $supervisor->course_programming_id = $request->programmedCourseId;
            $supervisor->supervisor = 1;
            $supervisor->status = 1;
            $supervisor->save();


        }else{
            $supervisor = CourseInstructor::where('id',$request->courseSupervisorId)->first();
            $supervisor->instructor_id = $request->supervisorId;
            $supervisor->save();
        }


        $sumConsecutive = $courseProgrammed->course->consecutive->id;
        foreach ($request->employee as $employee) {


            foreach ($employee['attendance'] as $attendance) {
                if(isset($attendance['value'])){

                    if (!isset($attendance['id'])) {
                        if($attendance['value'] == 1){
                            $atten = EmployeeEnrollment::where('id',$employee['enrollmentId'])->with('attendanceDay')->first();
                            $atten->attendanceDay()->attach($employee['enrollmentId'],['course_day_id'=>$attendance['courseDayId']]);

                            $course_day = CourseDays::where('id',$attendance['courseDayId'])->first();
                            $course_day->status = 1;
                            $course_day->save();
                        }
                    }
                    else {

                       $employeeCourse =  EmployeeClassAttendance::where('id',$attendance['id'])->first();
                       if($employeeCourse != null){
                           if ($attendance['value'] == 1) {
                               $employeeCourse->course_day_id = $attendance['courseDayId'];
                               $employeeCourse->save();
                           } else {
                               $employeeCourse->delete();
                           }


                       }
                    }
                }
            }

                $employeeEnrollment = EmployeeEnrollment::where('id',$employee['enrollmentId'])->first();
                $employeeEnrollment->observations = $employee['observations'];



                if($employee['statement'] == "2"){
                    $employeeEnrollment->reschedule = 1;
                    $employeeEnrollment->save();
                }else{
                    $employeeEnrollment->save();
                    if(isset($employee['certificateId'])){

                        $courseCertificate = CourseCertificate::where('id',$employee['certificateId'])->first();
                        //$courseCertificate->grade = $employee['grade'];
                        $courseCertificate->statement = $employee['statement'];
                        $courseCertificate->save();

                    }else{

                        $sumConsecutive = $sumConsecutive + 1;
                        $isiCode = sprintf("%'.04d\n", $sumConsecutive);
                        $courseProgrammed->course->consecutive->id = $sumConsecutive;
                        $courseProgrammed->course->consecutive->save();


                         CourseCertificate::create([
                            //'grade'=>$employee['grade'],
                            'statement'=>$employee['statement'],
                            'enrollments_id'=>$employeeEnrollment->id,
                            'isi_code_certification'=>$courseProgrammed->course->prefix.''.$isiCode,
                        ]);
                    }
                }




            if (isset($employee['billId'])) {

                $bill = Bill::where('id',$employee['billId'])->first();
                // $bill->payment = $employee['billValue'];
                $bill->bill_serial = $employee['bill'];
                $bill->payment_status = $employee['billStatus'];
                $bill->save();

            } else {
                 Bill::create([
                    'enrollments_id'=>$employeeEnrollment->id,
                    // 'payment'=>$employee['billValue'],
                    'bill_serial'=>$employee['bill'],
                    'payment_status'=>$employee['billStatus'],
                ]);
            }


        }


           return redirect()->action('CourseProgrammingController@getViewCourseFinalization');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getEmployeesCertificateByProgrammedCourse($courseProgrammed)
    {
        try{
           $employeesCertificateByCourse = DB::table('employees')
                                            ->join('users', 'users.id', '=', 'employees.user_id')
                                            ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                            ->join('course_certificates','course_certificates.enrollments_id','=','course_employees_enrollment.id')
                                            ->leftJoin('bills','bills.enrollments_id', '=' ,'course_employees_enrollment.id')
                                            ->join('companies', 'companies.id', '=', 'employees.company_id')
                                            ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                            ->join('courses','courses.id', '=' ,'course_programming.course_id')
                                            ->select('companies.company_name as company_name',
                                                     'users.name as employee_name',
                                                     'users.identification_number as identification',
                                                     'users.last_name as employee_last_name',
                                                     'courses.name as course_name',
                                                     'bills.payment_status',
                                                     'course_certificates.id as course_certificates_id',
                                                     'course_employees_enrollment.id as course_enrollment_id',
                                                     'companies.sector_economico as sector_economico',
                                                     'companies.arl as arl',
                                                     'companies.legal_agent as representante'

                                            )
                                            ->where('course_programming.id',$courseProgrammed)
                                            //->where('course_certificates.grade','>=', 3.0)
                                            ->where('course_certificates.statement','=', 1);

                        if (Auth::user()->role == 'A') {
                        //$companies = collect();
                            $companiesAdministrator = CompanyAdministrator::where('user_id',Auth::user()->id)->with('company')->get();
                            foreach ($companiesAdministrator as $companyAdministrator) {
                                 $employeesCertificateByCourse->Where('employees.company_id','=', $companyAdministrator->company_id);
                            }

                            $employeesCertificateByCourse->get();
                            $employeesCertificateByCourse = $employeesCertificateByCourse->get();

                        }
                        else{
                            $employeesCertificateByCourse->get();
                            $employeesCertificateByCourse = $employeesCertificateByCourse->get();
                        }

            //dd($employeesCertificateByCourse);
            return view('layouts.certificateEmployees',compact('employeesCertificateByCourse'));
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

    public function getEmployeeCertificateByComapnyCourse($company,$courseProgrammed)
    {
        try{
            $employeesCertificateByCourse = DB::table('employees')
                            ->join('users', 'users.id', '=', 'employees.user_id')
                            ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                            ->join('course_certificates','course_certificates.enrollments_id','=','course_employees_enrollment.id')
                            ->leftJoin('bills','bills.enrollments_id', '=' ,'course_employees_enrollment.id')
                            ->join('companies', 'companies.id', '=', 'employees.company_id')
                            ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                            ->join('courses','courses.id', '=' ,'course_programming.course_id')
                            ->select('companies.company_name as company_name',
                                                     'users.name as employee_name',
                                                     'users.identification_number as identification',
                                                     'users.last_name as employee_last_name',
                                                     'courses.name as course_name',
                                                     'bills.payment_status',
                                                     'course_certificates.id as course_certificates_id',
                                                     'course_employees_enrollment.id as course_enrollment_id',
                                                     'companies.sector_economico as sector_economico',
                                                     'companies.arl as arl',
                                                     'companies.legal_agent as representante'

                                            )
                            ->where('course_programming.id',$courseProgrammed)
                            ->where('companies.id',$company)
                            //->where('course_certificates.grade','>=', 3.0)
                            ->where('course_certificates.statement','=', 1)
                            ->get();
             return view('layouts.certificateEmployees',compact('employeesCertificateByCourse'));
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

    public function getEmployeeCertificateByComapny($company)
    {
        try{
            $employeesCertificateByCourse = DB::table('employees')
                            ->join('users', 'users.id', '=', 'employees.user_id')
                            ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                            ->join('course_certificates','course_certificates.enrollments_id','=','course_employees_enrollment.id')
                            ->leftJoin('bills','bills.enrollments_id', '=' ,'course_employees_enrollment.id')
                            ->join('companies', 'companies.id', '=', 'employees.company_id')
                            ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                            ->join('courses','courses.id', '=' ,'course_programming.course_id')
                            ->select('companies.company_name as company_name',
                                     'users.name as employee_name',
                                     'users.last_name as employee_last_name',
                                     'courses.name as course_name',
                                     'bills.payment_status',
                                     'course_certificates.id as course_certificates_id',
                                     'course_employees_enrollment.id as course_enrollment_id',
                                     'companies.sector_economico as sector_economico',
                                     'companies.arl as arl',
                                     'companies.legal_agent as representante'

                                    )
                            ->where('companies.id',$company)
                            //->where('course_certificates.grade','>=', 3.0)
                            ->where('course_certificates.statement','=', 1)
                            ->get();
             return view('layouts.certificateEmployees',compact('employeesCertificateByCourse'));
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

    public function viewCertificate($id)
    {
        try{
            $pdf = null;

            $certificateEnrollment =  EmployeeEnrollment::where('id',$id)->with('employee.user',
            'courseProgramming.course',
            'courseProgramming.courseDays',
            'courseProgramming.courseInstructor.instructor.user',
            'certificate','employee.company')->first();
            
            if($certificateEnrollment->certificate->created_at > '2022-08-26'){
                    
                if ($certificateEnrollment->employee->company->arl !== null && $certificateEnrollment->employee->company->legal_agent !== null && $certificateEnrollment->employee->company->sector_economico !== null) {
                    $pdf = Self::generateNewCertificatePdf($certificateEnrollment);
                   
                }
                else{
                    return back()->withError("Falta actualizar la ARL, el sector económico o el representante legal de la empresa para poder generar el certificado.");
                }
                
            }
            else{

                $pdf =  Self::generatePdf($certificateEnrollment);
            }

            if($pdf != null)
            {
                $storageCertificatesFolder = 'certificates/'.$certificateEnrollment->employee->company->company_name.'_'.$certificateEnrollment->employee->company->id;
                Storage::makeDirectory($storageCertificatesFolder);
                $certificateName = trim($certificateEnrollment->employee->user->name).'-'.trim($certificateEnrollment->employee->user->identification_number).'-'.trim($certificateEnrollment->courseProgramming->course->name).'.pdf';
                Storage::put($storageCertificatesFolder.'/'.$certificateName, $pdf->output());
                return $pdf->download($certificateName);
            }
            return redirect()->back();

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

    public function sendCertificates($company,$courseProgrammed)
    {
        // try{
        $employeesCertificate = DB::table('employees')
                        ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                        ->join('course_certificates','course_certificates.enrollments_id','=','course_employees_enrollment.id')
                        ->leftJoin('bills','bills.enrollments_id', '=' ,'course_employees_enrollment.id')
                        ->join('companies', 'companies.id', '=', 'employees.company_id')
                        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                        ->join('courses','courses.id', '=' ,'course_programming.course_id')
                        ->select('companies.company_name as company_name',
                                 'courses.name as course_name',
                                 'bills.payment_status',
                                 'course_certificates.id as course_certificates_id',
                                 'course_employees_enrollment.id as course_enrollment_id'

                                )
                        //->where('course_certificates.grade','>=', 3.0)
                        ->where('course_certificates.statement','=', 1);


        if ($courseProgrammed != 0) {
            $employeesCertificate->where('course_programming.id',$courseProgrammed);
            $employeesCertificate->where('companies.id',$company);
            $employeesCertificate = $employeesCertificate->get();
            $filename = storage_path("/app/certificates/".$employeesCertificate[0]->company_name."-".$employeesCertificate[0]->course_name.".zip");
            $file = $employeesCertificate[0]->company_name."-".$employeesCertificate[0]->course_name.".zip";


        }
        else{
            $employeesCertificate->where('companies.id',$company);
            $employeesCertificate = $employeesCertificate->get();
            $filename = storage_path("/app/certificates/".$employeesCertificate[0]->company_name.".zip");
            $file = $employeesCertificate[0]->company_name.".zip";
        }

        $zip = new ZipArchive();

        if ($zip->open($filename, ZipArchive::CREATE)) {
            //dd($zip);
            foreach ($employeesCertificate as $employeeCertificate) {

                $certificateEnrollment =  EmployeeEnrollment::where('id',$employeeCertificate->course_enrollment_id)->with('employee.user','courseProgramming.course','certificate','employee.company')->first();
                $pdf =  Self::generatePdf($certificateEnrollment);
                if($pdf != null){
                    $storageCertificatesFolder = 'certificates/'.$certificateEnrollment->employee->company->company_name.'_'.$certificateEnrollment->employee->company->id;
                    Storage::makeDirectory($storageCertificatesFolder);
                    $certificateName = trim($certificateEnrollment->employee->user->name).'-'.trim($certificateEnrollment->employee->user->identification_number).'-'.trim($certificateEnrollment->courseProgramming->course->name).'.pdf';
                    Storage::put($storageCertificatesFolder.'/'.$certificateName, $pdf->output());

                    if ($zip->addFile(storage_path('app/'.$storageCertificatesFolder.'/'.$certificateName),$certificateName)) {
                        continue;
                    }else {
                        throw new Exception("file `{storage/certificates/$storageCertificatesFolder/$certificateName}` could not be added to the zip file: " . $zip->getStatusString());
                    }
                }
            }

            if ($zip->close()) {
                //return response()->download($filename, $file, array('Content-Type: application/octet-stream','Content-Length: '. filesize($filename)))->deleteFileAfterSend(false);

                $companyAdministrators = CompanyAdministrator::select('user_id')->where('company_id',$company)->get();

                foreach ($companyAdministrators as $companyAdministrator) {

                    $data = new \stdClass();
                    if ($courseProgrammed != 0) {

                        $data->message = "Se han generado los certificados para el curso ".$employeesCertificate[0]->course_name;
                        $data->subject = "Generacion de certificados";
                    }else{

                        $data->message = "Se han generado los certificados";
                        $data->subject = "Generación de certificados ";
                    }


                    Mail::to($companyAdministrator->user->email)->send(new zipCertificateMail($data,$file));
                }

                return Response::json(true);
            } else {
                throw new Exception("could not close zip file: " . $filename->getStatusString());
            }
        }

        // } catch (\Throwable $th) {
        //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // } catch (ModelNotFoundException $exception) {
        //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // }
    }

    private static  function generatePdf(EmployeeEnrollment $certificateEnrollment)
    {
        // try{
            if ($certificateEnrollment->certificate != null) {

                if ($certificateEnrollment->certificate->status == 0) {
                    $certificateEnrollment->certificate->expedition_date = Carbon::now();
                    $certificateEnrollment->certificate->status = 1;
                    $certificateEnrollment->certificate->save();
                }

                foreach ($certificateEnrollment->courseProgramming->courseDays as $value) {
                    $courseDay = Carbon::parse($value->date);
                    $courseDaysArr[] = $courseDay->day;
                    $courseMonthArr[] = $courseDay->isoFormat('MMMM');
                }
               
                $place = $certificateEnrollment->courseProgramming->place;
                $expeditionDateString = $place.", ".implode(',',$courseDaysArr).' de '.$courseMonthArr[0].' de '.$courseDay->year;
                //dd($expeditionDateString);

                switch ($certificateEnrollment->employee->user->document_type) {
                    case 'CC':
                        $tipoDocumento = 'cédula de Ciudadanía No.';
                        break;
                    case 'CE':
                        $tipoDocumento = 'cédula de Extranjería No.';
                        break;
                    case 'PE':
                        $tipoDocumento = 'permiso especial';
                        break;
                    default:
                        $tipoDocumento = 'Cédula de Ciudadanía No.';
                        break;
                }

                // $expeditionDate = $date->isoFormat('d [de] MMMM [de] Y');
                //dd($certificateEnrollment->courseProgramming->id);
                $endDate = Carbon::parse($certificateEnrollment->courseProgramming->end_date);
                $day = $endDate->day;
                if ($day == "1") {
                    $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
                    $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a '.$day.' día '.$expeditionLiteralDate;
                }else{
                    $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
                    $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a los '.$day.' días '.$expeditionLiteralDate;
                }

                //return view('certificate.certificate',compact('certificateEnrollment','expeditionDate','literalExpeditionDate'));
                // $view  = \View::make('certificate.certificate',compact('certificateEnrollment','expeditionDate','literalExpeditionDate'))->render();
                // $pdf = App::make('dompdf.wrapper');
                // $pdf->setOptions(['defaultFont' => 'calibri']);
                // $pdf->loadHTML($view)->setPaper('a4', 'landscape');
                // return $pdf->stream();
                $customPaper = array(0,0,842,590);
               return $pdf = PDF::loadView('certificate.certificate',compact('certificateEnrollment','expeditionDateString','literalExpeditionDate','tipoDocumento'))->setPaper($customPaper);
            }
            else {
                return null;
            }
        // } catch (\Throwable $th) {
        //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // } catch (ModelNotFoundException $exception) {
        //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // }
    }

    public function getAttendaceCertificateView()
    {

        return view('attendaceCertificateView');

    }

    public function getEmployeeAttendaceCertificate(int $identification)
    {
        $user = User::Where('identification_number',$identification)->where('role','E')->with('employee')->first();
        $historyEmployee = ProofAttendance::where('identification',$identification)->get();
        $collectionUser = collect([]);
        if (!is_null($user)) {
            $enrollments = EmployeeEnrollment::where('employee_id',$user->employee->id)->whereHas('certificate',function($query){
                $query->where('statement','=',1);
            })->with('certificate','courseProgramming.course','employee.user')->get();

            foreach ($enrollments as $enrollment) {

                $collectionUser->add([
                   'id' => $enrollment->id,
                   'identification' => $enrollment->employee->user->identification_number,
                   'name' => $enrollment->employee->user->name.' '.$enrollment->employee->user->last_name,
                   'course' => $enrollment->courseProgramming->course->name,
                   'date' => Carbon::parse($enrollment->courseProgramming->begin_date)->formatLocalized('%A').'-'.\Carbon\Carbon::parse($enrollment->courseProgramming->end_date)->formatLocalized('%A').' '. \Carbon\Carbon::parse($enrollment->courseProgramming->begin_date)->formatLocalized('%d %B %Y'),
                   'historical' => false,
                ]);
            }
        }


        foreach ($historyEmployee as $employee) {

                 $date = Utils::FormatDate($employee->expedition_date);
                 $collectionUser->add([
                    'id' => $employee->id,
                    'identification' => $employee->identification,
                    'name' => $employee->fullname,
                    'course' => $employee->course,
                    'date' => Carbon::parse($date)->formatLocalized('%d %B %Y'),
                    'historical' => true,
                ]);
        }



        return view('layouts.attendanceCertificateTable',compact('collectionUser'));
    }


    public function viewAttedanceCertificate($enrollmentId)
    {
        try{
            $collectionUser = collect([]);
            $certificateEnrollment =  EmployeeEnrollment::where('id',$enrollmentId)->with('employee.user',
            'courseProgramming.course',
            'courseProgramming.courseDays',
            'courseProgramming.courseInstructor.instructor.user',
            'certificate','employee.company')->first();

            $collectionUser = collect([
                   'identification' => $certificateEnrollment->employee->user->identification_number,
                   'name' => $certificateEnrollment->employee->user->name.' '.$certificateEnrollment->employee->user->last_name,
                   'course' => $certificateEnrollment->courseProgramming->course->course_code,
                   'duration' => $certificateEnrollment->courseProgramming->duration,
                   'date' => $certificateEnrollment->courseProgramming->end_date,
            ]);

            $pdf =   Self::generateAttendancePdf($collectionUser);
            if($pdf != null)
            {
                $storageCertificatesFolder = 'certificates/'.'asistencia'.$certificateEnrollment->employee->company->company_name.'_'.$certificateEnrollment->employee->company->id;
                Storage::makeDirectory($storageCertificatesFolder);
                $certificateName = trim($certificateEnrollment->employee->user->name).'-'.trim($certificateEnrollment->employee->user->identification_number).'-'.trim($certificateEnrollment->courseProgramming->course->name).'.pdf';
                Storage::put($storageCertificatesFolder.'/'.$certificateName, $pdf->output());
                return $pdf->download($certificateName);
            }
            return false;

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

    private static function generateAttendancePdf(Collection $certificateEnrollment)
    {

            // $collectionUser->add([
            //        'identification' => $certificateEnrollment->employee->user->identification_number,
            //        'name' => $certificateEnrollment->employee->user->name.' '.$enrollment->employee->user->last_name,
            //        'course' => $enrollment->courseProgramming->course->course_code,
            //        'date' => $enrollment->courseProgramming->duration,
            //        'date' => Carbon::parse($enrollment->courseProgramming->end_date)->formatLocalized('%d %B %Y'),
            // ]);


                $endDate = Carbon::parse($certificateEnrollment['date']);
                $day = $endDate->day;
                if ($day == "1") {
                    $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
                    $literalExpeditionDate = 'Se expide esta constancia en la ciudad de Itagüí a '.$day.' día ';
                }else{
                    $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
                    $literalExpeditionDate = 'Se expide esta constancia en la ciudad de Itagüí, a los '.$day.' días ';
                }

                $customPaper = array(0,0,820,580);
               return $pdf = PDF::loadView('certificate.attendanceCertificate',compact('certificateEnrollment','literalExpeditionDate','expeditionLiteralDate'))->setPaper($customPaper);
            }


    //     private static  function generateAttendancePdf($certificateEnrollment)
    // {
    //     // try{
    //         if ($certificateEnrollment->certificate != null) {


    //             foreach ($certificateEnrollment->courseProgramming->courseDays as $value) {
    //                 $courseDay = Carbon::parse($value->date);
    //                 $courseDaysArr[] = $courseDay->day;
    //                 $courseMonthArr[] = $courseDay->isoFormat('MMMM');
    //             }
    //             $expeditionDateString = $certificateEnrollment->courseProgramming->course->name.' '."los dias, ".implode(',',$courseDaysArr).' de '.$courseMonthArr[0].' de '.$courseDay->year;

    //             $endDate = Carbon::parse($certificateEnrollment->courseProgramming->end_date);
    //             $day = $endDate->day;
    //             if ($day == "1") {
    //                 $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
    //                 $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a '.$day.' día '.$expeditionLiteralDate;
    //             }else{
    //                 $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
    //                 $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a los '.$day.' días '.$expeditionLiteralDate;
    //             }

    //             //$customPaper = array(0,0,842,590);
    //            return $pdf = PDF::loadView('certificate.attendanceCertificate',compact('certificateEnrollment','expeditionDateString','literalExpeditionDate'))->setPaper('letter');;
    //         }
    //         else {
    //             return null;
    //         }
    //     // } catch (\Throwable $th) {
    //     //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
    //     //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
    //     //     return back()->withError($string)->withInput();
    //     // } catch (ModelNotFoundException $exception) {
    //     //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
    //     //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
    //     //     return back()->withError($string)->withInput();
    //     // }
    // }

    public function viewAttedanceCertificateHistorical($identification)
    {
        try{
            $historyEmployee = ProofAttendance::where('id',$identification)->first();
            $date = Utils::FormatDate($historyEmployee->expedition_date);
            $collectionUser = collect([
                   'identification' => $historyEmployee->identification,
                   'name' => $historyEmployee->fullname,
                   'course' => $historyEmployee->course,
                   'duration' => $historyEmployee->hours.' Horas',
                   'date' => $date,
            ]);
            $pdf =  Self::generateAttendancePdf($collectionUser);
            if($pdf != null)
            {
                $collectionUser = null;
                $storageCertificatesFolder = 'certificates/'.'asistencia'.$historyEmployee->fullname.'_'.$historyEmployee->company;
                Storage::makeDirectory($storageCertificatesFolder);
                $certificateName = trim($historyEmployee->fullname).'-'.trim($historyEmployee->identification).'-'.trim($historyEmployee->course).'.pdf';
                Storage::put($storageCertificatesFolder.'/'.$certificateName, $pdf->output());
                return $pdf->download($certificateName);
            }
            return false;

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

    public function showtHistorical()
    {
        return view('showHistorical');
    }

    public function getHistorical()
    {

        return Response::json(ProofAttendance::orderBy('expedition_date')->get());
    }

    public function getAttendaceCertificateViewWeb()
    {
        return view('proofCertificate');
    }

    private static function generateNewCertificatePdf($certificateEnrollment)
    {

            if ($certificateEnrollment->certificate != null) {

                if ($certificateEnrollment->certificate->status == 0) {
                    $certificateEnrollment->certificate->expedition_date = Carbon::now();
                    $certificateEnrollment->certificate->status = 1;
                    $certificateEnrollment->certificate->save();
                }
                
                $place = $certificateEnrollment->courseProgramming->place;
               
                foreach ($certificateEnrollment->courseProgramming->courseDays as $value) {
                    $courseDay = Carbon::parse($value->date);
                    $courseDaysArr[] = $courseDay->day.' '.$courseDay->isoFormat('MMMM');
                    $courseMonthArr[] = $courseDay->isoFormat('MMMM');
                    $dates[] =  $courseDay;
                }
                
                $datesByMonth = [];
                foreach ($dates as $date) {
                    $datesByMonth[$date->isoFormat('MMMM')][] = $date;
                }
                
                $expeditionDateString = $place.", ";
                foreach ($datesByMonth as $month => $dates) {
                    $expeditionDateString .= implode(',',array_map(function($date){
                        return $date->day;
                    },$dates)).' de '.$month.', ';
                }

                //$expeditionDateString = $place.", ".implode(',',$courseDaysArr).' de '.$courseDay->year;
                $expeditionDateString.= 'de '. $courseDay->year;
              

                // $expeditionDate = $date->isoFormat('d [de] MMMM [de] Y');
                //dd($certificateEnrollment->courseProgramming->id);
                $endDate = Carbon::parse($certificateEnrollment->courseProgramming->end_date);
                $day = $endDate->day;
                $legalAgent = $certificateEnrollment->employee->company->legal_agent;
                $empresa = $certificateEnrollment->employee->company->company_name;
                $nit = $certificateEnrollment->employee->company->nit;
                $sectorEconomico = $certificateEnrollment->employee->company->sector_economico;
                
                switch ($certificateEnrollment->employee->user->document_type) {
                    case 'CC':
                        $tipoDocumento = 'cédula de Ciudadanía No.';
                        break;
                    case 'CE':
                        $tipoDocumento = 'cédula de Extranjería No.';
                        break;
                    case 'PE':
                        $tipoDocumento = 'permiso especial';
                        break;
                    default:
                        $tipoDocumento = 'Cédula de Ciudadanía No.';
                        break;
                }
               
                
                    if ($day == "1") {
                        $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
                        $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí a solicitud del empleador '.$legalAgent.' de la empresa '.$empresa.' con nit '.$nit.' y el cual pertenece al '.$sectorEconomico.', a '.$day.' día '.$expeditionLiteralDate;
                    }else{
                        $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
                        $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí a solicitud del empleador '.$legalAgent.' de la empresa '.$empresa.' con nit '.$nit.' y el cual pertenece al '.$sectorEconomico.', a los '.$day.' días '.$expeditionLiteralDate;
                    }
                


                //return view('certificate.certificate',compact('certificateEnrollment','expeditionDate','literalExpeditionDate'));
                // $view  = \View::make('certificate.certificate',compact('certificateEnrollment','expeditionDate','literalExpeditionDate'))->render();
                // $pdf = App::make('dompdf.wrapper');
                // $pdf->setOptions(['defaultFont' => 'calibri']);
                // $pdf->loadHTML($view)->setPaper('a4', 'landscape');
                // return $pdf->stream();
                $customPaper = array(0,0,842,590);
               return $pdf = PDF::loadView('certificate.newCertificate',compact('certificateEnrollment','expeditionDateString','literalExpeditionDate','tipoDocumento'))->setPaper($customPaper);
            }
            else {
                return null;
            }
    }


}
