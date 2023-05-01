<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        return view('insertUser');
    }

    /**
     * Insert a new user on DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
       if($request->role == "E"){
        $data = $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'identification_number'=>'required|numeric',
            'role'=>'required|in:A,E,I,M',
            'document_type'=>'required'
        ]);
        $data['email'] = Str::random(40);
        $data['password'] = Hash::make("06022017");
       }
       else{
        $data = $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'identification_number'=>'required|numeric',
            'email'=>'required|email',
            'password'=>'required|min:5',
            'role'=>'required|in:A,E,I,M',
            'document_type'=>'required'
        ]);
       }
        
        User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'identification_number' => $data['identification_number'],
            'document_type' => $data['document_type'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect('home');
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

    public function veryfyEmail(Request $request)
    {
        $user = User::where('email',$request->email)->first();
       if ($user != null) {
           return Response::json(true);
       }
       else {
           return Response::json(false);
       }
    }
}
