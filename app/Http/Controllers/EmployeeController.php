<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Company;
use App\AcademicDegree;
use App\EmployeeEnrollment;
use App\Attendance;
use App\CourseDays;
use App\CourseProgramming;
use App\Instructor;
use App\CompanyAdministrator;
use App\DocumentType;
use App\Files;
use App\EmployeeClassAttendance;
use App\Bill;
use App\CourseCertificate;
use App\DocumentTypeCourse;
use Illuminate\Http\Request;
use Auth;
use DB;
use Response;
use Carbon\carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;

class EmployeeController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es');
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('showEmployees');
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

    public function getEmployeesTableData(Request $request)
    {
        $query = Employee::query();
    
        if (Auth::user()->role == 'A') {
            $companiesAdministrator = Auth::user()->CompanyAdministrator;
            $query->where(function ($query) use ($companiesAdministrator) {
                foreach ($companiesAdministrator as $companyAdministrator) {
                    $query->orWhere('company_id', $companyAdministrator->company_id);
                }
            });
        }
    
        $query->with('user', 'company', 'academicDegree')->withTrashed()->has('user');
    
        $employees = $query->latest()->simplePaginate($request->input('length', 20));
    
        return Response::json($employees);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {


            if (Auth::user()->role == 'A') {

                $company = collect();
                $companiesAdministrator = CompanyAdministrator::where('user_id',Auth::user()->id)->with('company')->get();
                foreach ($companiesAdministrator as $companyAdministrator) {
                    $company->push($companyAdministrator->company);
                }

                //$company = Company::where('id',Auth::user()->CompanyAdministrator->company_id)->get();
            }
            else {
                $company = Company::orderby('company_name')->get();
            }
            $files = DocumentType::orderBy('id')->get();
            $documentsByCourse = DocumentTypeCourse::whereHas('documentType', function($query){
                $query->where('deleted_at',null);
            })->orderBy('id')->get();
            //$coursesProgramming = CourseProgramming::where('quantity_enrolled_employees','<',31)->where('status','=',0)->has('course')->with('course')->get();
            $academicDegrees = AcademicDegree::all();
            return view('insertEmployee')->with(['companies'=>$company,
                                                 'academicDegrees'=>$academicDegrees,
                                                 'documentsByCourse'=>$documentsByCourse,
                                                 'files'=>$files]);

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'identification_number'=>'required',
            'phone_number'=>'required',
            'company'=>'required',
            'document_type'=>'required',
            'position'=>'required',
            'birthdate'=>'required',
            'emergency_contact_name'=>'required',
            'emergency_phone_number'=>'required',
            'academy_degree'=>'required',
            'literacy_level'=>'required',
            'hemo_classification'=>'required',
            'allergies'=>'required',
            'recent_medication_use'=>'required',
            'recent_Injuries'=>'required',
            'current_diseases'=>'required',
            'sector_economico'=>'required',
        ]);

        try {

            $files = $request->file('docFiles');

            $employee = User::where('identification_number',$data['identification_number'])->where('role','E')->first();
            //code...
            if ($employee == null) {
                # code...

            $company = explode("-",$data['company']);

            $notificationData = [];
            $user = new User;
            $employee = new Employee;

            $user->name =  $data['name'];
            $user->last_name =  $data['last_name'];
            $user->email =  substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,9).'@correo.com';
            $user->identification_number =  $data['identification_number'];
            $user->document_type =  $data['document_type'];
            $user->phone_number =  $data['phone_number'];
            $user->password =  Hash::make(chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)));
            $user->role =  'E';
            $user->literacy_level = $data['literacy_level'];
            $user->hemo_classification = $data['hemo_classification'];
            $user->allergies = $data['allergies'];
            $user->recent_medication_use = $data['recent_medication_use'];
            $user->recent_Injuries = $data['recent_Injuries'];
            $user->current_diseases = $data['current_diseases'];
            $user->save();
            //dd($user);
            $employee->user_id = $user->id;
            $employee->company_id = $company[0];
            $employee->birthdate = $data['birthdate'];
            $employee->academy_degree_id  = $data['academy_degree'];
            $employee->emergency_contact_name  = $data['emergency_contact_name'];
            $employee->emergency_phone_number = $data['emergency_phone_number'];
            $employee->position = $data['position'];
            $employee->sector_economico = $data['sector_economico'];
            //dd($employee);
            $employee->save();




            if (isset($request->course)) {
                $course = explode("-",$request->course);
                EmployeeEnrollment::create([
                   'employee_id'=>$employee->id,
                   'course_programming_id'=>$course[0],
                   'status_employee'=>0,
                ]);
            }


            $fileId = $request->fileid;

            if(!empty($files)){
              for ($i=0; $i <count($fileId) ; $i++) {
                  if (isset($files[$i])) {
                    $storeFile =  Storage::putfile('photos', $files[$i],'private');
                        Files::create([
                            'fileroute'=>$storeFile,
                            'file_id'=>$fileId[$i],
                            'name'=>Str::before(basename($storeFile),'.'),
                            'employee_id'=>$employee->id,
                        ]);
                        $storeFile = null;
                    }
                }
            }

            $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',0)->with('user')->get();
            if(empty($files) && !isset($request->course)){
                $notificationData['detail'] = "Se ha ingresado el empleado ".$data['name']." ".$data['last_name']." para la empresa ".$company[1];
                $notificationData['adminId'] = $companyAdministrator;
                $notificationData['url'] = "";
                NotificationController::store($notificationData);
            }
            else if(!empty($files) && isset($request->course)){
                $notificationData['detail'] = "Se ha ingresado el empleado ".$data['name']." ".$data['last_name']." para la empresa ".$company[1]." y se registro al curso ".$course[1]." para la fecha ".Carbon::parse($course[2])->isoFormat('MMMM D YYYY')." con algunos documentos";
                $notificationData['adminId'] = $companyAdministrator;
                $notificationData['url'] = "getCourseFilesByEmployeeNotification/".$employee->id."/".$course[2]."/".$course[0];
                NotificationController::store($notificationData);
            }
            else if(isset($request->course) && empty($files)){
                $notificationData['detail'] = "Se ha ingresado el empleado ".$data['name']." ".$data['last_name']." para la empresa ".$company[1]." y se registro al curso ".$course[1]." para la fecha ".Carbon::parse($course[2])->isoFormat('MMMM D YYYY');
                $notificationData['adminId'] = $companyAdministrator;
                $notificationData['url'] = "getCourseFilesByEmployeeNotification/".$employee->id."/".$course[2]."/".$course[0];
                NotificationController::store($notificationData);
            }
            else if(!isset($request->course) && !empty($files)){
                $notificationData['detail'] = "Se ha ingresado el empleado ".$data['name']." ".$data['last_name']." para la empresa ".$company[1]." y se subieron algunos documentos";
                $notificationData['adminId'] = $companyAdministrator;
                $notificationData['url'] = "";
                NotificationController::store($notificationData);
            }



           foreach ($companyAdministrator as $compAdmin) {

                $data = new \stdClass();
                $data->message = $notificationData['detail'];
                $data->subject = "Registro de empleado nuevo para la empresa ".$company[1];
                Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
           }


            return redirect()->action('EmployeeController@index');
        }
        else{
            return redirect()->action('EmployeeController@index');
        }

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
     * @param  \App\Employess  $employess
     * @return \Illuminate\Http\Response
     */
    public function show(Employess $employess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employess  $employess
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $files = DocumentType::orderBy('id')->get();
            $academicDegrees = AcademicDegree::all();
            $companies = Company::orderBy('company_name')->get();
            $employee = Employee::where('id',$id)->with('user','company','academicDegree','files')->withTrashed()->first();
            $documentsByCourse = DocumentTypeCourse::orderBy('id')->get();
            return view('updateEmployee',compact('employee','companies','academicDegrees','documentsByCourse','files'));

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employess  $employess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'identification_number'=>'required|numeric',
            'phone_number'=>'',
            'company'=>'required',
            'document_type'=>'',
            'position'=>'',
            'birthdate'=>'',
            'emergency_contact_name'=>'',
            'emergency_phone_number'=>'',
            'academy_degree'=>'',
            'literacy_level'=>'',
            'hemo_classification'=>'',
            'allergies'=>'',
            'recent_medication_use'=>'',
            'recent_Injuries'=>'',
            'current_diseases'=>'',
            'sector_economico'=>'',
        ]);

        try {

            // if (!isset($request->course)) {
            //     return back()->with('course_validation','not_course');
            // }

            $files = $request->file('docFiles');

            // if(empty($files)){
            //     return back()->with('course_validation','not_file');
            // }


            $employee = Employee::where('id',$id)->with('user')->first();

            $employee->user->name =  $data['name'];
            $employee->user->last_name =  $data['last_name'];
            $employee->user->email =  substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,9).'@correo.com';;
            $employee->user->identification_number =  $data['identification_number'];
            $employee->user->document_type =  $data['document_type'];
            $employee->user->phone_number =  $data['phone_number'];
            $employee->user->role =  'E';
            $employee->user->literacy_level = $data['literacy_level'];
            $employee->user->hemo_classification = $data['hemo_classification'];
            $employee->user->allergies = $data['allergies'];
            $employee->user->recent_medication_use = $data['recent_medication_use'];
            $employee->user->recent_Injuries = $data['recent_Injuries'];
            $employee->user->current_diseases = $data['current_diseases'];
            $employee->user->save();

            $employee->company_id = $data['company'];
            $employee->birthdate = $data['birthdate'];
            $employee->academy_degree_id  = $data['academy_degree'];
            $employee->emergency_contact_name  = $data['emergency_contact_name'];
            $employee->emergency_phone_number = $data['emergency_phone_number'];
            $employee->position = $data['position'];
            $employee->sector_economico = $data['sector_economico'];
            $employee->save();

            if (isset($request->course)) {
                $course = explode("-",$request->course);
                EmployeeEnrollment::create([
                   'employee_id'=>$employee->id,
                   'course_programming_id'=>$course[0],
                   'status_employee'=>0,
                ]);
            }

            $fileId = $request->fileid;

            if(!empty($files)){
              for ($i=0; $i <count($fileId) ; $i++) {
                  if (isset($files[$i])) {
                    $employeeFile = Files::where('file_id',$fileId[$i])->where('employee_id',$id)->first();
                    if($employeeFile != null){
                        $storeFile =  Storage::putfile('photos', $files[$i],'private');
                        $employeeFile->fileroute = $storeFile;
                        $employeeFile->name = Str::before(basename($storeFile),'.');
                        $employeeFile->save();
                        $storeFile = null;
                    }
                  }
                }
            }

            return redirect()->action('EmployeeController@index');

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Employess  $employess
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try {

            $employee = Employee::where('id',$id)->withTrashed()->first();

            if($employee->deleted_at == null){
                if($employee->delete()){
                    $request->session()->flash('message', 'El usuario fue deshabilitado correctametne !');
                }
            }
            else{
                $employee->restore();
                $request->session()->flash('message', 'El usuario fue habilitado correctametne !');
            }
            return redirect()->action('EmployeeController@index');
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

    public function enrolledEmployees()
    {
        try {

            $companies = Company::orderby('company_name')->get();
            return view('showPreEnrolledEmployees',compact('companies'));

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


    public function getPreEnrolledEmployees()
    {
        try {


            $preEnrolledEmployees = DB::table('employees')
                                        ->join('companies', 'companies.id', '=', 'employees.company_id')
                                        ->join('users', 'users.id', '=', 'employees.user_id')
                                        ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                        ->join('courses','courses.id', '=' ,'course_programming.course_id')
                                        ->select('employees.id as employee_id',
                                                 'users.name as employee_name',
                                                 'course_employees_enrollment.status_employee',
                                                 'course_employees_enrollment.id as enrollment_id',
                                                 'employees.company_id',
                                                 'companies.company_name as company_name',
                                                 'courses.name as course_name',
                                                 'courses.id as course_id',
                                                 'courses.course_code as course_code',
                                                 'course_programming.id as coursePrograming_id',
                                                 'course_programming.begin_date as begin_date'
                                        )
                                        ->where('course_employees_enrollment.status_employee', '=', 0)
                                        ->get();

            return  Response::json($preEnrolledEmployees);

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

    public function getPreEnrolledEmployeesByCompany($comanyId = null ,$employeeId = null)
    {
        try{



            $preEnrolledEmployees = DB::table('employees')
                                    ->join('companies', 'companies.id', '=', 'employees.company_id')
                                    ->join('users', 'users.id', '=', 'employees.user_id')
                                    ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                    ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                    ->join('courses','courses.id', '=' ,'course_programming.course_id')
                                    ->select('employees.id as employee_id',
                                             DB::raw('CONCAT(users.name, " ", users.last_name) AS employee_name'),
                                             'course_employees_enrollment.status_employee',
                                             'course_employees_enrollment.id as enrollment_id',
                                             'employees.company_id',
                                             'companies.company_name as company_name',
                                             'courses.name as course_name',
                                             'courses.id as course_id',
                                             'courses.course_code as course_code',
                                             'course_programming.id as coursePrograming_id',
                                             'course_programming.begin_date as begin_date'
                                             )
                                    ->where('course_employees_enrollment.status_employee', '=', 0)
                                    ->whereNull('employees.deleted_at');


                                    if($employeeId !== "null"){
                                        $preEnrolledEmployees = $preEnrolledEmployees->where(function($result) use($employeeId){

                                            $companiesAdmin = CompanyAdministrator::where('user_id',$employeeId)->get();
                                            foreach ($companiesAdmin as $companyAdmin) {
                                                $result->orWhere('employees.company_id', $companyAdmin->company_id);

                                            }})->orderBy('coursePrograming_id', 'ASC')->get();
                                    }
                                    else if($comanyId == "null"){
                                        $preEnrolledEmployees =  $preEnrolledEmployees->orderBy('coursePrograming_id', 'ASC')->get();
                                    }
                                    else{
                                        $preEnrolledEmployees =  $preEnrolledEmployees->where('employees.company_id', $comanyId)->orderBy('coursePrograming_id', 'ASC')->get();

                                    }





            return  Response::json($preEnrolledEmployees);
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

    public function getEnrolledEmployeesByCompany($companyId,$employeeId)
    {

        try{
            $preEnrolledEmployees = DB::table('employees')
                                    ->join('companies', 'companies.id', '=', 'employees.company_id')
                                    ->join('users', 'users.id', '=', 'employees.user_id')
                                    ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                    ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                    ->join('courses','courses.id', '=' ,'course_programming.course_id')
                                    ->select('employees.id as employee_id',
                                             'users.name as employee_name',
                                             'course_employees_enrollment.status_employee',
                                             'course_employees_enrollment.id as enrollment_id',
                                             'employees.company_id',
                                             'companies.company_name as company_name',
                                             'courses.name as course_name',
                                             'courses.id as course_id',
                                             'courses.course_code as course_code',
                                             'course_programming.id as coursePrograming_id',
                                             'course_programming.begin_date as begin_date'
                                             )
                                    ->where('course_employees_enrollment.status_employee', '=', 1);

                                    if($employeeId !== "null"){
                                        $preEnrolledEmployees = $preEnrolledEmployees->where(function($result) use($employeeId){

                                            $companiesAdmin = CompanyAdministrator::where('user_id',$employeeId)->get();
                                            foreach ($companiesAdmin as $companyAdmin) {
                                                $result->orWhere('employees.company_id', $companyAdmin->company_id);

                                            }})->get();
                                    }
                                    else{
                                        $preEnrolledEmployees =  $preEnrolledEmployees->where('employees.company_id', $companyId)->get();

                                    }
         return  Response::json($preEnrolledEmployees);

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

    public function checkEmployeeCourses($id)
    {
        try{
             return Response::json(Employee::where('id',$id)->with('employeeEnrollment','files')->first());
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

    public function insertEmployeesCourseAttendance(Request $request)
    {
        try{

            foreach($request->attendance as $attendanceEmployee)
            {
                if(isset($attendanceEmployee['check'])){
                    $attendance = EmployeeEnrollment::where('id',$attendanceEmployee['enroll'])->with('attendanceDay')->first();
                    $attendance->attendanceDay()->attach($attendanceEmployee['enroll'],['course_day_id'=>$request->courseDay]);

                    $course_day = CourseDays::where('id',$request->courseDay)->first();
                    $course_day->status = 1;
                    $course_day->save();

                    CourseProgrammingController::checkCourseProgrammedStatus($course_day->course_programming_id);

                    return redirect()->action('CourseProgrammingController@getEmployeesByCourseProgramming',['id' => $attendance->course_programming_id]);
                }
            }
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

    public function getEmployeesByFinishedCoruse($id)
    {
        try{

         /*$finishedEmployees = DB::table('employees')
                                    ->join('companies', 'companies.id', '=', 'employees.company_id')
                                    ->join('users', 'users.id', '=', 'employees.user_id')
                                    ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                    ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                    ->leftJoin('bills','bills.enrollments_id', '=' ,'course_employees_enrollment.id')
                                    ->join('courses','courses.id', '=' ,'course_programming.course_id')
                                    ->leftJoin('course_certificates','course_certificates.enrollments_id','=','course_employees_enrollment.id')
                                    ->select('employees.id as employee_id',
                                             'users.name as employee_name',
                                             'users.last_name as employee_last_name',
                                             'employees.company_id',
                                             'companies.company_name as company_name',
                                             'courses.name as course_name',
                                             'courses.id as course_id',
                                             'course_programming.id as coursePrograming_id',
                                             'course_programming.status as coursePrograming_status',
                                             'bills.bill_serial as bill_serial',
                                             'bills.payment_day as payment_day',
                                             'bills.payment_status as payment_status',
                                             'course_employees_enrollment.id as enrollmentId',
                                             'course_employees_enrollment.reschedule as reschedule',
                                             'course_certificates.id as certificate_id',
                                             'course_certificates.grade as certificate_grade',
                                             'course_certificates.statement as certificate_statement'
                                             )
                                    ->where('course_employees_enrollment.status_employee', '=', 1)
                                    ->where('course_programming.status', '=', 1)
                                    ->where('course_programming.id', '=', $id)
                                    ->get();*/

            $instructors = Instructor::orderBy('id')->has('user')->get();
            $finishedEmployees = EmployeeEnrollment::where('course_programming_id',$id)
                                ->where('status_employee',1)
                                ->where('reschedule',0)
                                ->with('employee.user','employee.company','courseProgramming.courseDays','bill','certificate','courseProgramming.courseInstructor','attendanceDay')
                                ->get();
                     //dd($finishedEmployees);
            return view('layouts.finishedEmployees',compact('finishedEmployees','instructors'));
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

    public function reprogramEmployee($id,$courseProgramingId)
    {
        try{
            $employEnrollment = EmployeeEnrollment::where('id',$id)->first();
            $employEnrollment->reschedule = 1;
            $saved = $employEnrollment->save();
            return redirect()->action('EmployeeController@getEmployeesByFinishedCoruse', ['id' => $courseProgramingId]);
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

    public function getEmployeesByCompanyId($companyId)
    {

        return Response::json(Employee::where('company_id',$companyId)->with('user')->get());
    }

    public function preEnrolledEmployeesView()
    {
        $companAdministrator = null;
        if (Auth::user()->role == 'A') {
            $companAdministrator = CompanyAdministrator::where('user_id',Auth::user()->id)->with('company')->first();
        }

        $companies = Company::where('id','<>',0)->get();

        return view('showPreEnrolledEmployeesByCompany',compact('companAdministrator','companies'));
    }

    /*acafadfkljdslfkjsklfjdslkfjklsdjflkdsjflksdjflkdjsflkjdslkfdslkfjdlskfjlkdsf */
    public function enrolledEmployessView()
    {
        $companAdministrator = null;
        if (Auth::user()->role == 'A') {
            $employeeId =  Auth::user()->id;
            $companAdministrator = CompanyAdministrator::where(function($result) use($employeeId){

                $companiesAdmin = CompanyAdministrator::where('user_id',$employeeId)->get();
                foreach ($companiesAdmin as $companyAdmin) {
                    $result->orWhere('company_id', $companyAdmin->company_id);

                }})->get();;
        }

        $companies = Company::where('id','<>',0)->get();

        return view('showEnrolledEmployeesByCompany',compact('companAdministrator','companies'));
    }

    public function getEnrolledEmployees()
    {

        try{
            $preEnrolledEmployees = DB::table('employees')
                                    ->join('companies', 'companies.id', '=', 'employees.company_id')
                                    ->join('users', 'users.id', '=', 'employees.user_id')
                                    ->join('course_employees_enrollment', 'employees.id', '=', 'course_employees_enrollment.employee_id')
                                    ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
                                    ->join('courses','courses.id', '=' ,'course_programming.course_id')
                                    ->select('employees.id as employee_id',
                                             'users.name as employee_name',
                                             'course_employees_enrollment.status_employee',
                                             'course_employees_enrollment.id as enrollment_id',
                                             'employees.company_id',
                                             'companies.company_name as company_name',
                                             'courses.name as course_name',
                                             'courses.id as course_id',
                                             'courses.course_code as course_code',
                                             'course_programming.id as coursePrograming_id',
                                             'course_programming.begin_date as begin_date'
                                             )
                                    ->where('course_employees_enrollment.status_employee', '=', 1)
                                    ->get();

         return  Response::json($preEnrolledEmployees);

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

    public function getMinistryEmployeesByFinishedCoruse($id)
    {
        try{


            $finishedEmployees = DB::table('employees')
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
                                         'courses.name as course_name',
                                         'course_programming.end_date',
                                         DB::raw('CONCAT(userInstructor.name, " ", userInstructor.last_name) AS instructor_name'),
                                         'companies.company_name as company_name',
                                         'course_programming.id as course_programming_id'

                                )
                                ->where('course_instructor.supervisor','=',0)
                                ->where('course_programming.id','=',$id)
                                ->get();
                     //dd($finishedEmployees[0]->certificate->id);
            return view('layouts.ministryEmployees',compact('finishedEmployees'));
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

    public function getRescheduleEmployees()
    {
        try{

            $rescheduleEmployees = EmployeeEnrollment::where('reschedule',1)
            ->where('reprogrammed',0)
            ->with('courseProgramming.course','employee.user')->get();
            $avaibleCourses = collect();
            $addedCourse = collect();
            foreach ($rescheduleEmployees as $rescheduleEmployee) {

                if(!$addedCourse->search($rescheduleEmployee->courseProgramming->course_id)){
                    $avaibleCourses->add(CourseProgramming::where('course_id',$rescheduleEmployee->courseProgramming->course_id)
                    ->where('begin_date','>=',$rescheduleEmployee->courseProgramming->begin_date)
                    ->with('course')->orderBy('begin_date', 'asc')->get());
                    $addedCourse->add($rescheduleEmployee->courseProgramming->course_id);
                }
            }
            //dd($avaibleCourses);
            return view('reprogramedEmployee',compact('rescheduleEmployees','avaibleCourses'));
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

    public function rescheduleEmployee($employeeId,$oldCourseProgrammingId,$newCourseProgramingId)
    {
        $oldEnrollmentProgramming = EmployeeEnrollment::where('course_programming_id',$oldCourseProgrammingId)
        ->where('employee_id',$employeeId)
        ->with('courseProgramming','employeeClassAttendance','bill','certificate')
        ->first();

         $newEnrollment = new EmployeeEnrollment();
         $newEnrollment->employee_id = $employeeId;
         $newEnrollment->course_programming_id = $newCourseProgramingId ;
         $newEnrollment->status_employee = 1;
         $saveEnrollment  = $newEnrollment->save();

        $oldClassAttendances = $oldEnrollmentProgramming->employeeClassAttendance->sortBy('course_day_id');
        $newClassAttendances = CourseProgramming::where('id',$newCourseProgramingId)->with('courseDays')->first();

        for ($i=0; $i < $oldClassAttendances->count(); $i++) {


            $newCourseDays =  EmployeeClassAttendance::create([
                    'enrollment_id'=>$newEnrollment->id,
                    'course_day_id'=>$newClassAttendances->courseDays[$i]->id,

                 ]);

        }

        if ($oldEnrollmentProgramming->certificate != null) {
            CourseCertificate::create([
                'grade'=>$oldEnrollmentProgramming->certificate->grade,
                'statement'=>$oldEnrollmentProgramming->certificate->statement,
                'enrollments_id'=>$newEnrollment->id,

            ]);
        }


        if ($oldEnrollmentProgramming->bill != null) {
            Bill::create([
                'enrollments_id'=>$newEnrollment->id,
                'payment'=>$oldEnrollmentProgramming->bill->payment,
                'bill_serial'=>$oldEnrollmentProgramming->bill->bill_serial,
                'payment_status'=>$oldEnrollmentProgramming->bill->payment_status,
            ]);
        }


        $oldEnrollmentProgramming->reprogrammed = 1;
        $oldEnrollmentProgramming->save();

        return Response::json([$saveEnrollment]);
    }

    public function showUserByIdentification()
    {
        return view('showUserByIdentification');
    }

    public function getEmployeeInformationByIdentification($identification)
    {
        $user = User::where('identification_number',$identification)
        ->whereNotIn('role', ['S','A','M','I'])
        ->with('employee.company')
        ->first();

        return view('layouts.employeeInformation',compact('user'));
    }

    public function getEnrollmentEmployeeInformation($employeeId)
    {
        $employeeEnrollmet = EmployeeEnrollment::where('employee_id',$employeeId)->with('courseProgramming.course','certificate','employee.user')->get();
        return Response::json($employeeEnrollmet);
    }

    public function getAllFinishedEmployeesCertificates()
    {
        $finishedEmployees = DB::table('employees')
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
                                         'courses.name as course_name',
                                         'course_programming.begin_date',
                                         DB::raw('CONCAT(userInstructor.name, " ", userInstructor.last_name) AS instructor_name'),
                                         'companies.company_name as company_name',
                                         'course_programming.id as course_programming_id',
                                         'course_employees_enrollment.id as id_enrollment'

                                )
                                ->where('course_instructor.supervisor','=',0)
                                ->where('course_certificates.statement' ,'=',1)
                                ->where('course_employees_enrollment.cancel' ,'=',0)
                                ->where('course_employees_enrollment.reschedule' ,'=',0)
                                ->where('course_programming.status' ,'=',1)
                                ->get();

        return Response::json($finishedEmployees);
    }


    public function getAllFinishedEmployeesCertificatesByDate($date1,$date2)
    {
        $finishedEmployees = DB::table('employees')
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
                                         'courses.name as course_name',
                                         'course_programming.begin_date',
                                         DB::raw('CONCAT(userInstructor.name, " ", userInstructor.last_name) AS instructor_name'),
                                         'companies.company_name as company_name',
                                         'course_programming.id as course_programming_id'

                                )
                                ->where('course_instructor.supervisor','=',0)
                                ->where('course_certificates.statement' ,'=',1)
                                ->where('course_programming.begin_date','>=',$date1)
                                ->where('course_programming.begin_date','<=',$date2)
                                ->where('course_programming.status' ,'=',1)
                                ->get();

        return Response::json($finishedEmployees);
    }

    public function getRescheduleEmployeesById($id)
    {
        $rescheduleEmployees = EmployeeEnrollment::where('reschedule',1)
            ->where('reprogrammed',0)
            ->where('employee_id',$id)
            ->with('courseProgramming.course','employee.user')->get();

            $avaibleCourses = collect();
            $addedCourse = collect();

            foreach ($rescheduleEmployees as $rescheduleEmployee) {

                if(!$addedCourse->search($rescheduleEmployee->courseProgramming->course_id)){
                    $avaibleCourses->add(CourseProgramming::where('course_id',$rescheduleEmployee->courseProgramming->course_id)
                    ->where('begin_date','>',$rescheduleEmployee->courseProgramming->begin_date)
                    ->with('course')->get());
                    $addedCourse->add($rescheduleEmployee->courseProgramming->course_id);
                }
            }
            //dd($avaibleCourses);
            return Response::json([$rescheduleEmployees,$avaibleCourses]);
    }

    public function unsuscribeEmployee($enrollmentId)
    {
        $unsuscribe = EmployeeEnrollment::find($enrollmentId)->forceDelete();
        return response()->json($unsuscribe);
    }

    public function checkEmployeeIdentification($indentification)
    {
        $validateIdentification = (User::where('identification_number',$indentification)->where('role','E')->first()) ? true : false ;
        return Response::json($validateIdentification);
    }

    public function getEmployeeCertificates()
    {
        return view('showEmployeeCertificateByIdentification');
    }

    public function getEnrollmentEmployeeInformationByIdentification($identification)
    {

        $finishedEmployees = DB::table('employees')
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
                                         'courses.name as course_name',
                                         'course_programming.begin_date',
                                         DB::raw('CONCAT(userInstructor.name, " ", userInstructor.last_name) AS instructor_name'),
                                         'companies.company_name as company_name',
                                         'course_programming.id as course_programming_id',
                                         'course_employees_enrollment.id as id_enrollment'

                                )
                                ->where('course_instructor.supervisor','=',0)
                                ->where('course_certificates.statement' ,'=',1)
                                ->where('course_employees_enrollment.cancel' ,'=',0)
                                ->where('course_employees_enrollment.reschedule' ,'=',0)
                                ->where('course_programming.status' ,'=',1)
                                ->where('users.identification_number' ,'=',$identification)
                                ->get();
        //$employeeEnrollmet = EmployeeEnrollment::where('employee_id',$employeeId)->with('courseProgramming.course','certificate','employee.user')->get();
        return Response::json($finishedEmployees);
    }
}
