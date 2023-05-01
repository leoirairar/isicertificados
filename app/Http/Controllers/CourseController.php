<?php

namespace App\Http\Controllers;

use App\Course;
use App\DocumentType;
use App\DocumentTypeCourse;
use App\CourseProgramming;
use App\Consecutive;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CourseController extends Controller
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

            $courses = Course::orderBy('name')->withTrashed()->get();
            return view('showCourses',compact('courses'));

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
            $documentsType = DocumentType::orderBy('name')->get();
            return view('insertCourse',compact('documentsType'));
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
            'courseCode'=>'required',
            'prefix'=>'required',
            'documents'=>'required',
            'consecutive'=>'required|numeric',
            'type'=>'required|numeric',
        ]);
        try{
           $course =  Course::create([
                'name'=>$data['name'],
                'course_code'=>$data['courseCode'],
                'prefix'=>$data['prefix'],
                'description'=>"",
                'revalidable'=>0,
                'status'=>1,
                'type'=>$data['type'],
            ]);

            foreach ($data['documents'] as $documents) {

                $course->documentsType()->attach($documents);
            }

            Consecutive::create([
                'id'=>$data['consecutive'],
                'course_id'=>$course->id
            ]);

            $courses = Course::orderBy('name')->withTrashed()->get();
            return view('showCourses',compact('courses'));
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

            $course = Course::where('id',$id)->with('documentsType','consecutive')->first();
            $documentsType = DocumentType::orderBy('name')->get();
            return view('updateCourse',compact('course','documentsType'));

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
            'name'=>'required',
            'courseCode'=>'required',
            'prefix'=>'required',
            'documents'=>'required',
            'status'=>'required',
            'consecutive'=>'required|numeric',
            'type'=>'required|numeric',
        ]);
        try{
            $course = Course::find($id);

            $course->name = $data['name'];
            $course->course_code = $data['courseCode'];
            $course->description = "";
            $course->prefix = $data['prefix'];
            $course->revalidable = 0;
            $course->status = $data['status'];
            $course->type = $data['type'];
            $course->save();


            $course->documentsType()->sync($data['documents']);

            if($course->consecutive == null){
                Consecutive::create([
                    'id'=>$data['consecutive'],
                    'course_id'=>$id
                ]);
            }
            else{
                $course->consecutive->id = $data['consecutive'];
                $course->consecutive->save();
            }



            $courses = Course::orderBy('name')->withTrashed()->get();
            return view('showCourses',compact('courses'));
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
        try{

            $course = Course::where('id',$id)->withTrashed()->first();
            $programmedCourses = CourseProgramming::where('course_id',$id)->withTrashed()->get();
            if($course->deleted_at == null){
                if($course->delete()){



                    foreach ($programmedCourses as $programmedCourse) {
                        if($programmedCourse->deleted_at == null){
                            $programmedCourse->delete();
                        }
                    }

                    $request->session()->flash('message', 'El curso fue deshabilitado correctametne !');
                }
            }
            else{
                $course->restore();
                foreach ($programmedCourses as $programmedCourse) {

                        $programmedCourse->restore();

                }
                $request->session()->flash('message', 'El curso fue habilitado correctametne !');
            }
            $courses = Course::orderBy('name')->withTrashed()->get();
            return view('showCourses',compact('courses'));

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
