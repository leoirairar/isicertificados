<?php

namespace App\Http\Controllers;


use App\User;
use App\State;
use App\Country;
use App\Company;
use App\CompanyAdministrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;




class CompanyAdministratorController extends Controller
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
        try {
            
            $comAdmin = User::where('role','A')->has('companyAdministrator.company')->withTrashed()->get();
            //dd($comAdmin);
            return view('showComapanyadmin',compact('comAdmin'));

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
        try {

            $company = Company::orderby('company_name')->get();
            return view('insertCompanyAdmin')->with(['companies'=>$company]);

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
                'identification_number'=>'required|numeric',
                'email'=>'required|email',
                'phone_number'=>'required',
                'password'=>'required|min:5',
                'company'=>'required',
                'document_type'=>'required',
                'position'=>'required',
            ]);
        try {
               //code...
           
            $user = new User;
            
           
            $user->name =  $data['name'];
            $user->last_name =  $data['last_name'];
            $user->email =  $data['email'];
            $user->identification_number =  $data['identification_number'];
            $user->document_type =  $data['document_type'];
            $user->phone_number =  $data['phone_number'];
            $user->password =  Hash::make($data['password']);
            $user->role =  'A';
            $user->save();

    
            foreach ($data['company'] as $companyId) {
                $userAdministrator = new CompanyAdministrator;
                $userAdministrator->user_id = $user->id;
                $userAdministrator->company_id = $companyId;
                $userAdministrator->position = $data['position'];
                $userAdministrator->save();
            }

            $datas = new \stdClass();
            $datas->message = 'Bienvenido a la plataforma de certificados ISI';
            $datas->url = $_SERVER['SERVER_NAME'];
            $datas->user = $user->email;
            $datas->subject = "Creacion de usuario administrador";
            $datas->password = $data['password'];
            Mail::to($user->email)->send(new NotificationsMail($datas));
            
            
            

            return redirect()->action('CompanyAdministratorController@index');
            $comAdmin = CompanyAdministrator::with('user','company')->withTrashed()->get();
            return view('showComapanyadmin',compact('comAdmin'));

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
        try {
            
            $countries = Country::where('id',44)->orderBy('name')->get();
            $states = State::where('country_id',44)->orderBy('name')->get();
            $comAdmin = User::where('id',$id)->with('companyAdministrator.company')->withTrashed()->first();
            $companies = Company::orderBy('company_name')->get();
            //dd($comAdmin);
            return view('updateCompanyAdmin',compact('comAdmin','countries','states','companies'));

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
            'last_name'=>'required',
            'identification_number'=>'required|numeric',
            'email'=>'required|email',
            'phone_number'=>'required',
            'company'=>'required',
            'document_type'=>'required',
            'position'=>'required',
            'email'=>'required',
            'password'=>''
        ]);
        
        
        try {

            $user = User::where('id',$id)->with('companyAdministrator')->first();

            $user->name =  $data['name'];
            $user->last_name =  $data['last_name'];
            $user->email =  $data['email'];
            $user->identification_number =  $data['identification_number'];
            $user->document_type =  $data['document_type'];
            $user->phone_number =  $data['phone_number'];
            $user->role =  'A';
            $user->password = Hash::make($data['password']);
            $user->save();
            
            $user->companyAdministrator()->forceDelete();

            foreach ($data['company'] as $company) {
                $userAdministrator = new CompanyAdministrator;
                $userAdministrator->user_id = $user->id;
                $userAdministrator->company_id = $company;
                $userAdministrator->position = $data['position'];
                $userAdministrator->save();
            }
            
            
            return redirect()->action('CompanyAdministratorController@index');
            
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
            
            $companyAdmin = CompanyAdministrator::where('user_id',$id)->withTrashed()->first();
            
            if($companyAdmin->deleted_at == null){
                if($companyAdmin->delete()){
                    $request->session()->flash('message', 'El usuario fue deshabilitado correctametne !');
                }
            }
            else{
                $companyAdmin->restore();
                $request->session()->flash('message', 'El usuario fue habilitado correctametne !');
            }

            $comAdmin = CompanyAdministrator::with('user','company')->get();
            return view('showComapanyadmin',compact('comAdmin'));

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
