<?php

namespace App\Http\Controllers;

use App\Files;
use App\Course;
use App\CourseProgramming;
use App\Employee;
use App\EmployeeEnrollment;
use App\DocumentType;
use App\CompanyAdministrator;
use Response;
use JavaScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;

class FilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getFilesByEmployee($id,$courseId)
    {   
        try{
            $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

            $files =  Files::where('employee_id',$id)->with('documentType')->get();
            $courseFiles = Course::where('id',$courseId)->with('documentsType')->first();
            return  Response::json(array('user_files'=>$files,'courseDocuments'=>$courseFiles));
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

    public function download($id)
    {
        try{
            $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
            $file = Files::where('id',$id)->first();
            $file_path = storage_path('app/'.$file->fileroute);
            return response()->download($file_path);
        } catch (\Throwable $th) {
           $string = "Ha ocurrido un problema.". "El archivo no existe";
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        } catch (ModelNotFoundException $exception) {
           $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
    }

    public function updateFilesState(Request $request)
    {  
        
        // try{ 
            $arrStatus = [];
            $courseDocuments = []; 
            $arrRequest = $request->all();
            //dd($arrRequest);
            foreach ($arrRequest as $value) {
                if (is_array($value)) {
                   // dd($value);
                    foreach ($value as  $val) {
                        array_push($arrStatus,$val['status']);
                         
                        if($val['file_id'] != 'undefined' && $val['file_id'] != null){
                            $userFile = Files::where('id',$val['file_id'])->first();
                            $userFile->status = $val['status'];
                            $userFile->save();
                        }
                        if($val['file_id'] == null){
                            Files::create([
                                'employee_id'=>$request->employee_id,
                                'file_id'=>$val['courseDocument_id'],
                                'status'=>$val['status'],
                            ]);
                        }
                        if($val['status'] == "W" || $val['status'] == "E"){

                            $courseDocument = DocumentType::select('name')->where('id',$val['courseDocument_id'])->first();
                            array_push($courseDocuments,$courseDocument->name);
                        }
                        
                    
                    }
                }
            
            }
            // $Employee = Employee::where('id',$request->employee_id)->with('user','coursesProgrammed.course')->first();
            // $courseProgramming = $Employee->coursesProgrammed->where('id',$request->coursePrograming_id)->first();

            $Employee = EmployeeEnrollment::where('employee_id',$request->employee_id)->where('course_programming_id',$request->coursePrograming_id)->where('id',$request->enrollment_id)
            ->with('courseProgramming','employee')->first();


            $enroll = false;
            foreach ($arrStatus as $status) {
               if($status != 'A'){
                    $enroll = false;
                    $documents = implode(", ",$courseDocuments); 
                    $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',$request->company_id)->get();
                    $notificationData['detail'] = "Se han rechazado o faltan los siguientes documentos: ".$documents."; del empleado ".$Employee->employee->user->name." ".$Employee->employee->user->last_name." del curso ".$Employee->courseProgramming->course->name." programado para el ".$Employee->courseProgramming->begin_date;
                    $notificationData['adminId'] = $companyAdministrator;
                    $notificationData['url'] = "getEditablesFilesByEmployee/".$request->employee_id."/".$request->course_id."/".$request->company_id."/".$request->coursePrograming_id;
                    NotificationController::store($notificationData);

                    foreach ($companyAdministrator as $compAdmin) {

                        $data = new \stdClass();
                        $data->message = $notificationData['detail'];
                        $data->subject = "Rechazo de documentos ";
                        Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
                    }

                    return redirect()->route('EnrolledEmployees');
                    break;
               }
               else {
                  $enroll = true;
               }
            }

            if ($enroll) {

                $Employee->status_employee = 1;
                $Employee->save();
                // $Employee->coursesProgrammed()->updateExistingPivot($request->coursePrograming_id, array(
                //   'status_employee' => 1
                // ));
                
                $Employee->courseProgramming->quantity_enrolled_employees = $Employee->courseProgramming->quantity_enrolled_employees + 1;
                $Employee->courseProgramming->save();

                $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',$Employee->employee->company_id)->get();
                $notificationData['detail'] = "Se ha aprobado la inscripción del empleado".$Employee->employee->user->name." ".$Employee->employee->user->last_name." al curso ".$Employee->courseProgramming->course->name;
                $notificationData['adminId'] = $companyAdministrator;
                $notificationData['url'] = "";
                NotificationController::store($notificationData);

                foreach ($companyAdministrator as $compAdmin) {

                    $data = new \stdClass();
                    $data->message = $notificationData['detail'];
                    $data->subject = "Aprobación de inscripción de empleado a curso";
                    //Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
                }

                return redirect()->route('EnrolledEmployees');
            }
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

    public function getEditablesFilesByEmployee($employeeId,$courseId,$companyId,$courseProgramingId)
    {
        $enrollment = EmployeeEnrollment::where('employee_id',$employeeId)->where('course_programming_id',$courseProgramingId)->first();
            $employee = Employee::where('id',$employeeId)->with('files','user','company')->withTrashed()->first();
            $course = Course::where('id',$courseId)->with('documentsType')->first();
            JavaScript::put(['course' => $course,'employeeFiles'=>$employee->files]);
            return view('showEditableFilesByEmployee',compact('employee','course','companyId','enrollment'));
    }

    public function showEditableFilesByEmployee($employeeId,$courseId,$companyId,$courseProgramingId)
    {
        try{

            
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

    public function downloadZip($name)
    { 
        try{
            $file_path = storage_path('app/certificates/'.$name);
            return response()->download($file_path);
        } catch (\Throwable $th) {
           $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
    }

    public function downloadAttendanceList($name)
    {
        $file_path = storage_path('app/'.$name);
        return response()->download($file_path);
    }

    public function getCourseFilesByEmployeeNotification($id,$courseId,$coursePrograming_id)
    {   
        try{
            //$storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
            $enrollment = EmployeeEnrollment::where('id',$id)->where('course_programming_id',$coursePrograming_id)->first();
            $files =  Files::where('employee_id',$enrollment->employee_id)->with('documentType')->get();
            $courseFiles = Course::where('id',$courseId)->with('documentsType')->first();
            return view('checkEmployeeCourseFiles',compact('files','courseFiles','enrollment'));
            
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

    public function downloadSign($name)
    {
        $file_path = storage_path('app/public/'.$name);
        return response()->download($file_path);
    }

    public function downloadAjax($id)
    {
        try{
            $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
            $file = Files::where('id',$id)->first();
            $file_path = storage_path('app/'.$file->fileroute);
            if (Storage::exists(public_path('img/dummy.jpg'))) {
                //return response()->download($file_path);
                return Response::json(false);
            }else{
                return Response::json(false);
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
}
