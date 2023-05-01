<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Alert;
use App\CourseProgramming;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;
use App\CompanyAdministrator;
use App\EmployeeEnrollment;
use Carbon\Carbon;
use \DOMDocument;
use Illuminate\Support\Facades\Storage;
use Arr;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkConditions');
    }

    public function index()
    {

        $fileName = $this->getName();
        return view('home', compact('fileName'));
    }

    public function show()
    {

        return view('insertBanner');
    }

    public function store(Request $request)
    {
        $file = $request->file('banner');


        if (!empty($file)) {

            $filExtention = $file->extension();
            // $file->storeAs('/signs', $file->getClientOriginalName(), 'upload');
            $directory = public_path('banner');
            $this->deleteFiles($directory);
            $path = 'banner/banner'. '.' . $filExtention;
            Storage::disk('public_load')->put($path , file_get_contents($file));
        }

        $fileName = $this->getName();
        return view('home', compact('fileName'));
    }

    function deleteFiles($dir)
    {
        // loop through the files one by one
        foreach (glob($dir . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function getName()
    {
        $fileName = null;
        $directory = public_path('banner');
        $files  = scandir($directory);
        foreach ($files as  $file) {
            $pos = strpos($file, 'banner');
            if ($pos !== false) {
                $fileName = $file;
            }
        }

        return $fileName;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index3()
    {
        $certificateEnrollment =  EmployeeEnrollment::where('id', 76)->with(
            'employee.user',
            'courseProgramming.course',
            'courseProgramming.courseInstructor.instructor.user',
            'certificate',
            'employee.company'
        )->first();

        foreach ($certificateEnrollment->courseProgramming->courseDays as $value) {
            $courseDay = Carbon::parse($value->date);
            $courseDaysArr[] = $courseDay->day;
            $courseMonthArr[] = $courseDay->isoFormat('MMMM');
        }
        $expeditionDateString = "Itagüí, " . implode(',', $courseDaysArr) . ' de ' . $courseMonthArr[0] . ' de ' . $courseDay->year;
        //dd($expeditionDateString);

        // $expeditionDate = $date->isoFormat('d [de] MMMM [de] Y');
        //dd($certificateEnrollment->courseProgramming->id);
        $endDate = Carbon::parse($certificateEnrollment->courseProgramming->end_date);
        $day = $endDate->day;
        if ($day == "1") {
            $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
            $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a ' . $day . ' día ' . $expeditionLiteralDate;
        } else {
            $expeditionLiteralDate = $endDate->isoFormat('[del mes de] MMMM [de] Y');
            $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a los ' . $day . ' días ' . $expeditionLiteralDate;
        }
        return view('certificate.certificate', compact('certificateEnrollment', 'expeditionDateString', 'literalExpeditionDate'));


        // $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',0)->with('user')->get();
        // dd( $companyAdministrator);

        // $data = new \stdClass();
        // $data->message = "este es solo un correo de pruebas para los correos";
        // Mail::to('andi.os90@gmail.com')->send(new NotificationsMail($data));
        // return view('home');
    }
    public function index2()
    {
        $courseEnrollment = CourseProgramming::where('id', 676)
            ->with(['employeeEnrollment' => function ($query) {
                $query->where('cancel', 1);
                $query->with('employee.user', 'employee.company', 'employee.academicDegree');
            }])
            ->with(
                'course',
                'courseDays'
            )->first();
        return view('layouts.attendanceExcel', [
            'courseEnrollment' => $courseEnrollment
        ]);
        dd($courseEnrollment);
    }


    private static  function generatePdf(EmployeeEnrollment $certificateEnrollment)
    {

        if ($certificateEnrollment->certificate != null) {

            if ($certificateEnrollment->certificate->status == 0) {
                $certificateEnrollment->certificate->expedition_date = Carbon::now();
                $certificateEnrollment->certificate->status = 1;
                $certificateEnrollment->certificate->save();
            }

            $date = Carbon::parse($certificateEnrollment->certificate->expedition_date);
            $expeditionDate = $date->isoFormat('d [de] MMMM [de] Y');
            $day = $date->isoFormat('d');
            if ($day == "1") {
                $expeditionLiteralDate = $date->isoFormat('[del mes de] MMMM [de] Y');
                $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a ' . $day . ' día ' . $expeditionLiteralDate;
            } else {
                $expeditionLiteralDate = $date->isoFormat('[del mes de] MMMM [de] Y');
                $literalExpeditionDate = 'Se expide este certificado en la ciudad de Itagüí, a los ' . $day . ' días ' . $expeditionLiteralDate;
            }
            return view('certificate.certificate', compact('certificateEnrollment', 'expeditionDate', 'literalExpeditionDate'));
            // $view  = \View::make('certificate.certificate',compact('certificateEnrollment','expeditionDate','literalExpeditionDate'))->render();
            // $pdf = App::make('dompdf.wrapper');
            // $pdf->setOptions(['defaultFont' => 'calibri']);
            // $pdf->loadHTML($view)->setPaper('a4', 'landscape');
            // return $pdf->stream();
            //$customPaper = array(0,0,842,590);
            return view('certificate.certificate', compact('certificateEnrollment', 'expeditionDate', 'literalExpeditionDate'));
            //return $pdf = PDF::loadView('certificate.certificate',compact('certificateEnrollment','expeditionDate','literalExpeditionDate'))->setPaper($customPaper);
        } else {
            return 'null';
        }
    }

    public function auth()
    {
        dd(Auth::user()->load('companyAdministrator')->companyAdministrator[0]->company_id);
    }
}
