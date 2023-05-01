<?php

namespace App\Http\Controllers;

use App\CourseProgramming;
use App\CourseDays;
use App\Course;
use App\EmployeeEnrollment;
use App\Exports\AttendanceExport;
use App\EmployeeClassAttendance;
use App\CompanyAdministrator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;
use DB;

class CourseProgrammingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        setlocale(LC_ALL,'es_ES.UTF-8');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $coursesProgramming = CourseProgramming::with('courseDays','course')->get();
            //return  Response::json($coursesProgramming);
            return view('showProgrammedCourses',compact('coursesProgramming'));
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

    public function getProgrammedCourses()
    {
        try{
            $coursesProgramming = CourseProgramming::with('courseDays','course')->get();
            return  Response::json($coursesProgramming);
            //return view('showProgrammedCourses',compact('coursesProgramming'));
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
        try{
            $courses = Course::orderBy('name')->get();
            return view("insertCourseProgramming",compact('courses'));
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
    // function date_sort($a, $b) {
    //     return strtotime($a) - strtotime($b);
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = $request->validate([
            'course'=>'required',
            'duration'=>'required',
            'begin_hour'=>'required',
            'end_hour'=>'',
            'place'=>'required',
            'scheduled_days'=>'required',
            'sequence'=>'required',
        ]);

         try{
        
        $currentYear = Carbon::now();
        $nextYear = Carbon::now()->addYear();
            
        $scheduled_days = explode(',', $data['scheduled_days']);
        //dd(collect($scheduled_days));
        $scheduled_days = collect($scheduled_days)->sort(function ($temp) {
            return Carbon::parse(strtotime($temp))->getTimestamp(); 
        });
        
        $last = count($scheduled_days);
       
        $beginDate = Carbon::createFromFormat('d/m/Y',  $scheduled_days[0]);
        $beginEndDate = Carbon::createFromFormat('d/m/Y',  $scheduled_days[$last-1]);
        
       
       $arr[] = null;
       //$diasprogramados[][] = null;
       if ($data['sequence'] == 1) {
        for ($i=0; $i < 52 ; $i++) { 
            if ($i == 0) {
                $courseProgramingData['begin_date'] = $beginDate->toDateString();
                
                $courseProgramingData['end_date'] = $beginEndDate->toDateString();
            }else{
                $courseProgramingData['begin_date'] = $beginDate->addWeek()->toDateString();
                $courseProgramingData['end_date'] = $beginEndDate->addWeek()->toDateString();
            }

            $courseProgramming = new CourseProgramming;
            $courseProgramming->course_id = $data['course'];
            $courseProgramming->begin_date = $courseProgramingData['begin_date'];
            $courseProgramming->end_date = $courseProgramingData['end_date'];
            $courseProgramming->duration = $data['duration'];
            $courseProgramming->begin_hour = $data['begin_hour'];
            // $courseProgramming->end_hour = $data['end_hour'];
            $courseProgramming->place = $data['place'];
            $courseProgramming->save();
            $addDay = false;
            $firstDay = true;
            $countHolydays = 0;
            
            $iteracion = 0;
            $firstHoliday = false;
            
            for ($j=0; $j < $scheduled_days->count(); $j++) { 
                
                $schedulesDaysFormat[$j] = Carbon::createFromFormat('d/m/Y', $scheduled_days[$j]);
                $schedulesDaysFormat[$j]->addWeek($i);
                //dd($scheduled_days[$j],$schedulesDaysFormat[$i]);
            }
            $isWeekCourse = HolidaysController::checWeekendDay($schedulesDaysFormat);
            
            
            

            foreach ($schedulesDaysFormat as $scheduleDayFormat) {

                $holyDay = HolidaysController::checkHolidaysToDay($scheduleDayFormat,$iteracion);
                
                if ($holyDay) {
                    $courseProgramming = CourseProgramming::where('id',$courseProgramming->id)->first();
                    $courseProgramming->delete();
                    break;
                }

                $first = Carbon::create($currentYear->year, 12, 22);
                $second = Carbon::create($nextYear->year, 1, 11);

                $isBetween =  $scheduleDayFormat->between($first, $second);

                if($isBetween){
                    $courseProgramming = CourseProgramming::where('id',$courseProgramming->id)->first();
                    $courseProgramming->delete();
                    break;
                }else {
                    $courseDays = new CourseDays;
                    $courseDays->course_programming_id = $courseProgramming->id;
                    $courseDays->date =  $scheduleDayFormat->toDateString();
                    $courseDays->save();
                }

                
  
                //$diasprogramados[$i][$iteracion] = $scheduleDayFormat->toDateString();
                
                // if($isWeekCourse){ 
                    
                    
                //     //Chek if the is a holiday
                //     $holyDay = HolidaysController::checkHolidaysToDay($scheduleDayFormat,$iteracion);

                    
                //     //if holiDay is true enter in the condition.
                //     if ($holyDay) {

                //         //if it's only one day and it's holiday the course is canceled.
                //        if(count($schedulesDaysFormat) == 1){
                //             $courseProgramming = CourseProgramming::where('id',$courseProgramming->id)->first();
                //             $courseProgramming->delete();
                //             break;
                //        }

                       
                //        //add one more day to the request date inserted.
                //        $scheduleDayFormat->addDay();

                //        /*Check if the new date is a holiday too. if it is add one more day, 
                //        also check if the new date is a weekend day and add one more day to make it a week day.
                //        This condition applies for holy week.*/
                //        if(HolidaysController::checkHolidaysToDay($scheduleDayFormat,$iteracion)){
                //            $scheduleDayFormat->addDay();
                //            $scheduleDayFormat = HolidaysController::addWeekDayToWeekendDay($scheduleDayFormat,$iteracion,$countHolydays);

                //         }

                //         //if the previous condition is not fulfilled, check if the new date is a weekend day, and add a new date to week day.
                //         if($scheduleDayFormat->isoFormat('dddd') == 'Saturday')
                //         {
                //             $scheduleDayFormat = HolidaysController::addWeekDayToWeekendDay($scheduleDayFormat,$iteracion,$countHolydays); 
                //         }

                //         //this contidion check if it's not the first programmed day and if it's the firts holiday of the programmed days.
                //        if($countHolydays == 0 && $firstDay == false){
                //            $firstHoliday = true;
                //        }
                //        $countHolydays++;
                //     }                    
                    
                //     if($firstHoliday == false){ 

                //         if ($addDay && $firstDay == false) {

                //             $scheduleDayFormat->addDay();

                //             $scheduleDayFormat = HolidaysController::addWeekDayToWeekendDay($scheduleDayFormat,$iteracion,$countHolydays);

                //         }
                //     }

                //     if($holyDay){
                //         $addDay = true;
                //         $firstHoliday = false;
                //     }
                    
                // }
                // else{
                    
                //     $holyDay = HolidaysController::checkHolidaysToDay($scheduleDayFormat,$iteracion);

                //     if ($holyDay) {
                        
                //             $scheduleDayFormat->addWeek();

                //             if(HolidaysController::checkHolidaysToDay($scheduleDayFormat,$iteracion)){
                //                 $scheduleDayFormat->addWeek();
                //                 $scheduleDayFormat->addDay(-1);
                //             }
                //     }
                   
                // }   
                
                 
                // $courseDays = new CourseDays;
                // $courseDays->course_programming_id = $courseProgramming->id;
                // $courseDays->date =  $scheduleDayFormat->toDateString();
                // $courseDays->save();

                // $iteracion++;
                // $firstDay = false;
                
            }
            $schedulesDaysFormat = null;
            
        }
       } else {

        DB::transaction(function () use ($data, $scheduled_days,$last) {

           $beginDate = Carbon::createFromFormat('d/m/Y',  $scheduled_days[0]);
           $beginEndDate = Carbon::createFromFormat('d/m/Y',  $scheduled_days[$last-1]);

           $courseProgramingData['begin_date'] = $beginDate->toDateString();
           $courseProgramingData['end_date'] = $beginEndDate->toDateString();

           $courseProgramming = new CourseProgramming;
           $courseProgramming->course_id = $data['course'];
           $courseProgramming->begin_date = $courseProgramingData['begin_date'];
           $courseProgramming->end_date = $courseProgramingData['end_date'];
           $courseProgramming->duration = $data['duration'];
           $courseProgramming->begin_hour = $data['begin_hour'];
        //    $courseProgramming->end_hour = $data['end_hour'];
           $courseProgramming->place = $data['place'];
           $courseProgramming->save();

           for ($j=0; $j < $scheduled_days->count(); $j++) { 
                
            $schedulesDaysFormat[$j] = Carbon::createFromFormat('d/m/Y', $scheduled_days[$j]);
            }

            //$isWeekCourse = HolidaysController::checWeekendDay($schedulesDaysFormat);

            foreach ($schedulesDaysFormat as $scheduleDayFormat) {

                $courseDays = new CourseDays;
                $courseDays->course_programming_id = $courseProgramming->id;
                $courseDays->date =  $scheduleDayFormat->toDateString();
                $courseDays->save();
            }

        });
       }
       
        

        $coursesProgramming = CourseProgramming::with('courseDays','course')->get();
        return view('showProgrammedCourses',compact('coursesProgramming'));

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
        try{
            
            $courses = Course::orderBy('name')->get();
            $courseProgrammed = CourseProgramming::where('id',$id)->with('courseDays')->first();
            for ($i=0; $i < $courseProgrammed->courseDays->count(); $i++) {
                $date = Carbon::parse($courseProgrammed->courseDays[$i]->date)->format('d/m/Y') ;
                $courseProgrammed->courseDays[$i]->date = $date;
            }

            return view('updateCourseProgramming',compact('courseProgrammed','courses'));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'course'=>'required',
            'duration'=>'required',
            'begin_hour'=>'',
            'end_hour'=>'',
            'place'=>'required',
            'scheduled_days'=>'required',
        ]);
        
        try{

            $scheduled_days = explode(',', $data['scheduled_days']);
            $last = count($scheduled_days);
            $beginDate = Carbon::createFromFormat('d/m/Y',  $scheduled_days[0]);
            $beginEndDate = Carbon::createFromFormat('d/m/Y',  $scheduled_days[$last-1]);

            $courseProgramming = CourseProgramming::where('id',$id)->first();
            
            $courseProgramming->course_id = $data['course'];
            $courseProgramming->begin_date = $beginDate->toDateString();
            $courseProgramming->end_date = $beginEndDate->toDateString();
            $courseProgramming->duration = $data['duration'];
            $courseProgramming->begin_hour = $data['begin_hour'];
            // $courseProgramming->end_hour = $data['end_hour'];
            $courseProgramming->place = $data['place'];
            $courseProgramming->save();

            

            

            

            CourseDays::where('course_programming_id',$id)->delete();

            foreach ($scheduled_days as $scheduled_day) {
                $courseDays = new CourseDays;
                $courseDays->course_programming_id = $id;
                $courseDays->date = Carbon::createFromFormat('d/m/Y', $scheduled_day);
                $courseDays->save();
            
            }
            
            return redirect()->action('CourseProgrammingController@index');

            // $coursesProgramming = CourseProgramming::with('courseDays','course')->get();
            // return view('showProgrammedCourses',compact('coursesProgramming'));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try {
       
            $programmedCourse = CourseProgramming::where('id',$id)->withTrashed()->first();
            
            if($programmedCourse->deleted_at == null){
                if($programmedCourse->delete()){
                    $request->session()->flash('message', 'El curso programado fue deshabilitado correctametne !');
                }
            }
            return redirect()->action('CourseProgrammingController@index');
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

    public function getEmployeesByCourseProgramming($id)
    {
        try{
            $courseProgrammed  = CourseProgramming::where('id',$id)->with('courseDays','employees.user')->first();
            return view('showEnrolledEmployeesByCourse',compact('courseProgrammed'));
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

    public function getAttendanceEmployees($courseDayId)
    {
        try{
            $courseDay = CourseDays::where('id',$courseDayId)->with('employeeEnrollment')->first();
            return  Response::json( $courseDay);
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
    
    public function getViewCourseFinalization()
    {
        try{

            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d');

            $coursesProgrammed = CourseProgramming::where('begin_date','>=',$weekStartDate)->where('begin_date','<=',$weekEndDate)->with('course')->get();
            
            return view('getCourseFinalization',compact('coursesProgrammed'));
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

    public function getViewCourseFinalizationByDates(Request $request)
    {
        try{

            //dd($request->dateOne);
            // $weekStartDate = Carbon::createFromFormat('d/m/Y', $request->dateOne);
            // $weekEndDate = Carbon::createFromFormat('d/m/Y', $request->dateTwo);
           
            $coursesProgrammed = CourseProgramming::where('begin_date','>=',$request->dateOne)->where('begin_date','<=',$request->dateTwo)->with('course')->get();
           //dd($coursesProgrammed);
            return view('getCourseFinalization',compact('coursesProgrammed'));
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

    static function checkCourseProgrammedStatus($id)
    {
        try{
            $couseProgrammed = CourseProgramming::where('id',$id)->with('courseDays')->first();
            
            if($couseProgrammed->status == 0){
            
                $complete = true;
            
                foreach ($couseProgrammed->courseDays as $courseDays) {
                    
                    if($courseDays->status == 0){
                       $complete = false;
                    }
                }
            
                if ($complete) {
                    $couseProgrammed->status = 1;
                    $couseProgrammed->save();  
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

    public function getFinishedCoursesBydates(Request $request)
    {
        try{

            $coursesProgrammed = CourseProgramming::where('begin_date','>=',$request->dateOne)->where('begin_date','<=',$request->dateTwo)
            ->where('status',1)->with('course')->get();
            return view('showMinistryDocument',compact('coursesProgrammed'));  
        
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

    public function getAttendanceView()
    {
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        $coursesProgrammed = $this->getCoursePrograming(0,$weekStartDate,$weekEndDate);

        return view('showAttendanceView',compact('coursesProgrammed'));
    }

    public function getAttendanceProgrammedCoursesByDates(Request $request)
    {
        // $now = Carbon::now();
        // $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        // $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        $coursesProgrammed = $this->getCoursePrograming(0,$request->dateOne,$request->dateTwo);

        return view('showAttendanceView',compact('coursesProgrammed'));
    }

    public function getAttendanceListByCourse($id)
    {
        $courseEnrollment = CourseProgramming::where('id',$id)
            ->with(['employeeEnrollment'=> function($query){
                $query->where('status_employee',1);
                $query->with('employee.user','employee.company');
            }])->with(
                'course',
                'courseDays'
            )->first();
        return view('layouts.attendance',compact('courseEnrollment'));
    }


    public function getCoursePrograming($status = null,$beginDate = null, $endDate = null)
    {
        if ($status !== null && $beginDate === null && $endDate === null) {
            return CourseProgramming::where('status',$status)->with('course','courseDays')->get();
        }
        elseif ($status !== null && $beginDate !== null && $endDate === null) {
            return CourseProgramming::where('begin_date','>=',$beginDate)->where('status',$status)->with('course','courseDays')->get();
        }
        elseif ($status !== null && $beginDate !== null && $endDate !== null) {
           return CourseProgramming::where('begin_date','>=',$beginDate)->where('begin_date','<=',$endDate)->where('status',$status)->with('course','courseDays')->get();
        }
        elseif ($beginDate !== null && $endDate !== null &&  $status === null) {
            return $coursesProgrammed = CourseProgramming::where('begin_date','>=',$beginDate)->where('begin_date','<=',$endDate)->with('course','courseDays')->get();
        }
        else {
            return CourseProgramming::orderBy('begin_date')->with('course','courseDays')->get();
        }
    }

    public function exportCourseProgamingAttendance($id)
    {
        $employees  = EmployeeEnrollment::where('course_programming_id',$id)->with('employee','courseProgramming')->get();
        $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',$employees[0]->employee->company_id)->get();

        $notificationData['detail'] = "Se ha generado la lista de asistencia al siguiente curso".$employees[0]->courseProgramming->course->name." programado para la fecha".$employees[0]->courseProgramming->begin_date;
        $notificationData['adminId'] = $companyAdministrator;
        $notificationData['url'] = "attendanceModal/".$employees[0]->courseProgramming->id;
        NotificationController::store($notificationData);

        foreach ($companyAdministrator as $compAdmin) {

            $data = new \stdClass();
            $data->message = $notificationData['detail'];
            $data->subject = "Generación de lista de asistencia.";
            Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
        }
        
        $unchecked = false;
        foreach ($employees as $employee) {
           if($employee->cancel === null)
           {
               $unchecked = true;
                break;
           }
        }
        if(!$unchecked){
            $result = 'INSCRIPCION DEL PERSONAL.xlsx';
            $excel =  Excel::store(new AttendanceExport($id), $result);
        }else{
            $result = 'unchecked';
        }
        
        return  Response::json($result);
    }

    public function saveAttendanceCourse(Request $request)
    {
        // $allAproved = true;
        // $enrollmentEmployeesStatus = EmployeeEnrollment::where('course_programming_id',$request->courseProgrammingId)->get();

        // foreach ($enrollmentEmployeesStatus as $enrollmentEmployeeStatus) {
        //     if($enrollmentEmployeeStatus->status_employee == 0){
        //          $allAproved = false;
        //     }
        // }

        // if ($allAproved) {
        //$courseProgrammed = CourseProgramming::where('id',$request->courseProgrammingId)->with('courseDays')->first();
        $hasChildren = CourseProgramming::where('programmed_course_parent_id',$request->courseProgrammingId)->get();
        $maxGroup = max(array_column($request->employee, 'group'));


        if(count($hasChildren)>0){
            foreach ($request->employee as $employee) {
                $checked = false;
                $courseProgrammingId = "";
                foreach ($hasChildren as $child) {
                    if ($employee['group'] == $child->group) {
                        $checked = true;
                        $courseProgrammingId = $child->id;
                    }
                }
                    if($checked && $employee['group'] != 0){
                        
                        $enrollment = EmployeeEnrollment::where('id', $employee['enrollmentId'])->first();
                        $enrollment->cancel = ($employee['attendance'] == 0) ? 1 : 0;
                        $enrollment->course_programming_id = $courseProgrammingId;
                        $enrollment->save();
                        $checked = false;
                    }
                    else{

                        if($employee['group'] != 0 && $checked == false){

                            $courseProgrammed = CourseProgramming::where('id',$child->programmed_course_parent_id)->with('courseDays')->first();
                            $newCourseProgramming = new CourseProgramming;
                            $newCourseProgramming->course_id = $courseProgrammed->course_id;
                            $newCourseProgramming->begin_date = $courseProgrammed->begin_date;
                            $newCourseProgramming->end_date = $courseProgrammed->end_date;
                            $newCourseProgramming->duration = $courseProgrammed->duration;
                            $newCourseProgramming->begin_hour = $courseProgrammed->begin_hour;
                            $newCourseProgramming->place = $courseProgrammed->place;
                            $newCourseProgramming->group = $employee['group'];
                            $newCourseProgramming->gropu_cheked = 1;
                            $newCourseProgramming->programmed_course_parent_id = $courseProgrammed->id;
                            $newCourseProgramming->save();

                            foreach ($courseProgrammed->courseDays as $courseDay) {

                                $duplicatedCourseDay =  new CourseDays;
                                $duplicatedCourseDay->course_programming_id = $newCourseProgramming->id;
                                $duplicatedCourseDay->date = $courseDay->date;
                                $duplicatedCourseDay->status = $courseDay->status;
                                $duplicatedCourseDay->save();
                            }

                            $enrollment = EmployeeEnrollment::where('id', $employee['enrollmentId'])->first();
                            $enrollment->cancel = ($employee['attendance'] == 0) ? 1 : 0;
                            $enrollment->course_programming_id = $newCourseProgramming->id;
                            $enrollment->save();
                        }
                        else{
                             $request->session()->flash('warning', 'Este curso se encuentra divivido por grupos y algunos empleados aun no se le han asignado grupos');
                        }

                    }
            }
        }else{
            $courseProgrammed = CourseProgramming::where('id',$request->courseProgrammingId)->with('courseDays')->first();

             if ($courseProgrammed->gropu_cheked == 1) {
                foreach ($request->employee as $employee) {
                    $enrollment = EmployeeEnrollment::where('id', $employee['enrollmentId'])->first();
                    $enrollment->cancel = ($employee['attendance'] == 0) ? 1 : 0;
                    //$enrollment->save();
                }
            } else {
            

                if ($maxGroup == "0") {

                     $courseProgrammed->gropu_cheked = 1;
                     $courseProgrammed->save();

                    foreach ($request->employee as $employee) {
                        $enrollment = EmployeeEnrollment::where('id', $employee['enrollmentId'])->first();
                        $enrollment->cancel = ($employee['attendance'] == 0) ? 1 : 0;
                        $enrollment->save();
                    }
                } else {

                    for ($i = 1; $i <= $maxGroup; $i++) {

                        $newCourseProgramming = new CourseProgramming;

                        $newCourseProgramming->course_id = $courseProgrammed->course_id;
                        $newCourseProgramming->begin_date = $courseProgrammed->begin_date;
                        $newCourseProgramming->end_date = $courseProgrammed->end_date;
                        $newCourseProgramming->duration = $courseProgrammed->duration;
                        $newCourseProgramming->begin_hour = $courseProgrammed->begin_hour;
                        $newCourseProgramming->place = $courseProgrammed->place;
                        $newCourseProgramming->group = $i;
                        $newCourseProgramming->gropu_cheked = 1;
                        $newCourseProgramming->programmed_course_parent_id = $request->courseProgrammingId;
                        $newCourseProgramming->save();

                        foreach ($courseProgrammed->courseDays as $courseDay) {

                            $duplicatedCourseDay =  new CourseDays;
                            $duplicatedCourseDay->course_programming_id = $newCourseProgramming->id;
                            $duplicatedCourseDay->date = $courseDay->date;
                            $duplicatedCourseDay->status = $courseDay->status;
                            $duplicatedCourseDay->save();
                        }



                        foreach ($request->employee as $employee) {
                            if ($employee['group'] == $i) {

                                $enrollment = EmployeeEnrollment::where('id', $employee['enrollmentId'])->first();
                                $enrollment->cancel = ($employee['attendance'] == 0) ? 1 : 0;
                                $enrollment->course_programming_id = $newCourseProgramming->id;
                                $enrollment->save();
                            }
                        }
                    }
                }
            }
        }
            $request->session()->flash('message', 'La lista de asistencia fue guardada correctamente.!');
        // }else{
        //     $request->session()->flash('error2', 'Aún faltan usuarios por ser aprobados en la pre inscripcion.!');
        // }





        return redirect()->action('CourseProgrammingController@getAttendanceView');
        
    }

    public function getCourseProgrammingById($id)
    {
        $employees  = EmployeeEnrollment::where('course_programming_id',$id)->with('employee.user','courseProgramming.course')->get();
        return Response::json($employees);
    }
    
    public function getEnrollmentHistoryView()
    {
       
        return view('showEnrollmentHistory');
    }

    public function getCourseProgrammingJson(Request $request)
    {

       

            $coursesProgramming = CourseProgramming::where('quantity_enrolled_employees','<',31)->where('status','=',0)->where('programmed_course_parent_id','=',NULL)->has('course')->with('course.documentsType')->get();
            $c = collect([]);

            foreach ($coursesProgramming as $value) {
                
                $endDate = Carbon::parse($value->end_date)->addDays(1);
                
                 $c->add([
                     'title'=>$value->course->name,
                     'start' => $value->begin_date,
                     'end' => $endDate,
                     'id'=>$value->id,
                     'textColor'=> 'white',
                     'backgroundColor'=> 'orange',
                     'borderColor'=> 'orange',
                     'description'=> $value->course->name.' ('.Carbon::parse($value->begin_date)->formatLocalized('%A').'-'.Carbon::parse($value->end_date)->formatLocalized('%A').') '.Carbon::parse($value->begin_date)->formatLocalized('%d %B %Y'),
                     'courseId'=>$value->course->id,
                     ]);
               
            
            
        }
        return Response::json($c);
   
        
    }

    public function checkEmployeeCourseInscription($employee_id,$courseprogramming_id)
    {
        $employeeEnrollment = EmployeeEnrollment::where('employee_id',$employee_id)->where('course_programming_id',$courseprogramming_id)->first();
        return Response::json(($employeeEnrollment == null )?true:false);
    }

    public function checkCourseProgramming(Request $request)
    {
        $repeated = false;
        $beginDate = Carbon::createFromFormat('d/m/Y',$request->beginDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',$request->endDate)->format('Y-m-d');

        $beginDateLiteralRequest = Carbon::parse($beginDate)->isoFormat('dddd');
        $endDateLiteralRequest = Carbon::parse($endDate)->isoFormat('dddd');
        
        $coursesProgrammed = CourseProgramming::where('course_id',$request->courseId)->where('begin_date','>=',$beginDate)->get();

        $arr = [];
        foreach ($coursesProgrammed as $courseProgrammed) {
            
            $beginDateLiteralCourse = Carbon::parse($courseProgrammed->begin_date)->isoFormat('dddd');
            $endDateLiteralCourse = Carbon::parse($courseProgrammed->end_date)->isoFormat('dddd');

            if($beginDateLiteralRequest == $beginDateLiteralCourse && $endDateLiteralRequest == $endDateLiteralCourse)
            {
                $repeated = true;
                break;
            }
        }
        return Response::json($repeated);
    }


}
