<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Exports\CourseProgrammingExport;
use App\Exports\EnrollmentExport;
use App\CourseProgramming;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Carbon\Carbon;

class MinistryExcelController extends Controller
{
    public function index()
    {
        //return redirect()->action('MinistryExcelController@create');
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        $coursesProgrammed = CourseProgramming::where('begin_date','>=',$weekStartDate)
        ->where('begin_date','<=',$weekEndDate)
        ->where('status','=',1)
        ->with('course','employeeEnrollment')
        ->get();

        return view('showMinistryDocument',compact('coursesProgrammed'));
    }

    public function create($id)
    {    
         Excel::store(new CourseProgrammingExport($id), 'MINISTERIO.xlsx');
         $file_path = storage_path('app/'.'MINISTERIO.xlsx');
         return response()->download($file_path);
    }

    public function createEnrollmentDocument()
    {
        try{
            $file_path = storage_path('app/'.'INSCRIPCION MINISTERIO.xlsx');
            
            Excel::store(new EnrollmentExport(), 'INSCRIPCION MINISTERIO.xlsx');
            return response()->download($file_path);

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
