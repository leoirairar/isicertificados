<?php

namespace App\Http\Controllers;

use App\User;
use App\AcademicDegree;
use App\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InstructorController extends Controller
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
        $instructors = Instructor::has('user')->with('user','academicDegrees')->get();
        return view('showInstructors',compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $academicDegrees = AcademicDegree::all();
        return view('inserInstructor')->with(['academicDegrees'=>$academicDegrees]);
    
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
            'identification_number'=>'',
            'phone_number'=>'',
            'document_type'=>'',
            'academy_degree'=>'',
            'position'=>'required',
            'licenseNumber'=>'required',
            
        ]);

        //dd($data);
        $user = new User;
        $instructor = new Instructor;

        $user->name =  $data['name'];
        $user->last_name =  $data['last_name'];
        $user->identification_number = 'Sin ingresar';
        $user->document_type =  "CC";
        $user->phone_number =  'Sin ingresar';
        $user->email = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,9).'@correo.com';
        $user->password =  Hash::make(chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)));
        $user->role = 'T';
        $user->save();

        $file = $request->file('fileSignature');

        $name = $file->getClientOriginalName();
        if(!empty($file)){
            // $file->storeAs('/signs', $file->getClientOriginalName(), 'upload');
            $storeFile =  Storage::putfileAs('public', $file,$name,'public');
            $instructor->fileroute = $storeFile;
            $instructor->sign_name = $name;

        }

        $instructor->user_id = $user->id;
        $instructor->position = $data['position'];
        $instructor->license_number = $data['licenseNumber'];

        $instructor->save();
        
        if (isset($data['academy_degree'])) {
            foreach ($data['academy_degree'] as $cademy_degree) {
            
                $instructor->academicDegrees()->attach($cademy_degree);
            }
        }
        
        $instructors = Instructor::has('user')->with('user','academicDegrees')->get();
        return view('showInstructors',compact('instructors'));
        
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
        $instructor = Instructor::has('user')->where('id',$id)->with('user','academicDegrees')->first();
        $academicDegrees = AcademicDegree::all();
        return view('updateInstructor',compact('instructor','academicDegrees'));
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
            'last_name'=>'required',
            'identification_number'=>'',
            'phone_number'=>'',
            'document_type'=>'',
            'academy_degree'=>'',
            'position'=>'required',
            'licenseNumber'=>'required',
        ]);

        $instructor = Instructor::has('user')->where('id',$id)->with('user','academicDegrees')->first();
        //dd($instructor);
        $file = $request->file('fileSignature');

        
        if(!empty($file)){
            $name = $file->getClientOriginalName();
            // $file->storeAs('/signs', $file->getClientOriginalName(), 'upload');
            $storeFile =  Storage::putfileAs('public', $file,$name,'public');
            $instructor->fileroute = $storeFile;
            $instructor->sign_name = $name;

        }

        $instructor->position = $data['position'];
        $instructor->license_number = $data['licenseNumber'];
        $instructor->save();

        $instructor->user->name =  $data['name'];
        $instructor->user->last_name =  $data['last_name'];
        $instructor->user->identification_number =  $data['identification_number'];
        $instructor->user->document_type =  $data['document_type'];
        $instructor->user->phone_number =  $data['phone_number'];
        //$user->email = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'),0,9).'@correo.com';;
        //$user->password =  Hash::make(chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)));
        $instructor->user->role =  'T';
        $instructor->user->save();

        if (isset($data['academy_degree'])) {
            $instructor->academicDegrees()->detach();
            foreach ($data['academy_degree'] as $cademy_degree) {
           
                $instructor->academicDegrees()->attach($cademy_degree);
            }
        }
       
        
        $instructors = Instructor::has('user')->with('user','academicDegrees')->get();
        return view('showInstructors',compact('instructors'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $instructor = Instructor::where('id',$id)->withTrashed()->first();
    
        if($instructor->deleted_at == null){
            if($instructor->delete()){
                $request->session()->flash('message', 'El usuario fue deshabilitado correctamente !');
            }
        }
        else{
            $instructor->restore();
            $request->session()->flash('message', 'El usuario fue habilitado correctamente !');
        }
        $instructors = Instructor::with('user','academicDegrees')->withTrashed()->get();
        return view('showInstructors',compact('instructors'));
    }
}
