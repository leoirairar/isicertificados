<?php

namespace App\Http\Controllers;

use App\Company;
use App\CourseProgramming;
use App\Employee;
use App\Files;
use App\CompanyAdministrator;
use App\EmployeeEnrollment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;


class CourseAssignment extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            if (Auth::user()->role == 'A') {
                $companies = collect();
                $companiesAdministrator = CompanyAdministrator::where('user_id',Auth::user()->id)->with('company')->get();
                foreach ($companiesAdministrator as $companyAdministrator) {
                    $companies->push($companyAdministrator->company);
                }

            }
            else{
                $companies = Company::orderBy('id')->get();
            }

            $coursesProgramming = CourseProgramming::where('quantity_enrolled_employees','<',31)->where('status','=',0)->has('course')->with('course.documentsType')->get();


            return view('enrollEmployeeCourse',compact('companies','coursesProgramming'));
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try{

            $employeEnrolled = new EmployeeEnrollment();
            $employeEnrolled->employee_id = $request->employee;
            $employeEnrolled->course_programming_id = $request->courseProgrammedId;
            $employeEnrolled->status_employee = false;
            $employeEnrolled->save();
            $employeEnrolled->with('employee');

            // $employeEnrolled->coursesProgrammed()->attach($request->employee, [
            //           'course_programming_id' => $request->course,
            //           'status_employee' => false
            // ]);

            $files = $request->file('docFiles');
            $fileId = $request->fileid;

            if(!empty($files)){
              for ($i=0; $i <count($files) ; $i++) {

                   $storeFile =  Storage::putfile('photos', $files[$i],'private');
                   Files::create([
                       'fileroute'=>$storeFile,
                       'file_id'=>$fileId[$i],
                       'name'=>Str::before(basename($storeFile),'.'),
                       'employee_id'=>$request->employee,
                   ]);

                }
            }

            $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',0)->get();
            $courseProgramming = CourseProgramming::where('id',$request->courseProgrammedId)->with('course')->first();
            $employee = Employee::where('id',$request->employee)->with('user')->first();

            $notificationData['detail'] = "Se a agregado al empleado ".$employee->user->name." ".$employee->user->last_name." para el curso ".$courseProgramming->course->name." programado para la fecha ".$courseProgramming->begin_date;
            $notificationData['adminId'] = $companyAdministrator;
            $notificationData['url'] = "getCourseFilesByEmployeeNotification/".$request->employee."/".$courseProgramming->course->id."/".$request->course;
            NotificationController::store($notificationData);

            foreach ($companyAdministrator as $compAdmin) {

                $data = new \stdClass();
                $data->message = $notificationData['detail'];
                $data->subject = "Asignación de empleado a un curso.";
                Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
            }


            $company = Company::where('id',$employee->company_id)->with('employees')->withTrashed()->first();
            return redirect()->route('getCompanyInformation',[$company]);

        // } catch (\Throwable $th) {
        //    $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // } catch (ModelNotFoundException $exception) {
        //    $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // }

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
    public function update(Request $request)
    {
        try{

            $files = $request->file('docFiles');
            $fileId = $request->fileid;

            if(!empty($files)){
                for ($i=0; $i < count($files) ; $i++) {

                     $storeFile =  Storage::putfile('photos', $files[$i],'private');
                     $file = Files::where('id',$fileId[$i])->first();
                     $file->fileroute = $storeFile;
                     $file->name = Str::before(basename($storeFile),'.');
                     $file->save();
                  }
              }
                $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',0)->get();
                $employee = Employee::where('id',$request->employee_id)->with('user')->first();
                $courseProgramming = CourseProgramming::where('id',$request->coursePrograming_id)->with('course')->first();

                $notificationData['detail'] = "Se han modificados documentos del empleado ".$employee->user->name." ".$employee->user->last_name."para el curso ".$courseProgramming->course->name."programado para la fecha ".$courseProgramming->begin_date;
                $notificationData['adminId'] = $companyAdministrator;
                $notificationData['url'] = "getCourseFilesByEmployeeNotification/".$request->employee_id."/".$request->course_id."/".$request->coursePrograming_id;
                NotificationController::store($notificationData);

                foreach ($companyAdministrator as $compAdmin) {

                    $data = new \stdClass();
                    $data->message = $notificationData['detail'];
                    $data->subject = "Modificación de documentos a un empleado.";
                    Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
                }

              return redirect()->route('preEnrolledEmployeesView');

        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        } catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
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
}
