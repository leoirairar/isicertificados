<?php

namespace App\Http\Controllers;

use App\User;
use App\State;
use App\Country;
use App\Company;
use App\CompanyAdministrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Alert;

class AdministratorController extends Controller
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
            $administrator = CompanyAdministrator::with('user','company')->withTrashed()->get();
            //dd($administrator);
        } catch (\Throwable $th) {
           $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        } catch (ModelNotFoundException $exception) {
           $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        
        return view('showAdministrator',compact('administrator'));
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
            return view('insertAdminIsi')->with(['companies'=>$company]);
       
        } catch (\Throwable $th) {
           $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        catch (ModelNotFoundException $exception) {
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
            'document_type'=>'required',
            'position'=>'required',
        ]);
        try {
            $registeredUser = User::where('email',trim($data['email']))->first();
            
            if ($registeredUser == null) {
                $user = new User;
                $user->name =  $data['name'];
                $user->last_name =  $data['last_name'];
                $user->email =  trim($data['email']);
                $user->identification_number =  $data['identification_number'];
                $user->document_type =  $data['document_type'];
                $user->phone_number =  $data['phone_number'];
                $user->password =  Hash::make($data['password']);
                $user->role =  'M';
                $user->save();

            }
            $userAdministrator = new CompanyAdministrator;
            $userAdministrator->user_id = (isset($user->id))? $user->id : $registeredUser->id;
            $userAdministrator->company_id = 0;
            $userAdministrator->position = $data['position'];
            $userAdministrator->save();

            $administrator = CompanyAdministrator::with('user','company')->withTrashed()->get();
            
        
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        return view('showAdministrator',compact('administrator'));
            
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
            $admin = CompanyAdministrator::where('id',$id)->with('user','company')->withTrashed()->first();
            $companies = Company::orderBy('company_name')->get();
            return view('updateAdministrator',compact('admin','countries','states','companies'));

        } catch (\Throwable $th) {
           $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage();;
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
            'password'=>'required|min:5',
            'company'=>'required',
            'document_type'=>'required',
            'position'=>'required',
        ]);

        try {

            $companyAdmin = CompanyAdministrator::where('id',$id)->with('user')->first();

            $companyAdmin->user->name =  $data['name'];
            $companyAdmin->user->last_name =  $data['last_name'];
            $companyAdmin->user->email =  $data['email'];
            $companyAdmin->user->identification_number =  $data['identification_number'];
            $companyAdmin->user->document_type =  $data['document_type'];
            $companyAdmin->user->phone_number =  $data['phone_number'];
            $companyAdmin->user->password =  Hash::make($data['password']);
            $companyAdmin->user->role =  'M';
            $companyAdmin->user->save();
            $companyAdmin->company_id = 0;
            $companyAdmin->position = $data['position'];
            $companyAdmin->save();
            
            $administrator = CompanyAdministrator::with('user','company')->withTrashed()->get();
            return view('showAdministrator',compact('administrator'));
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        catch (ModelNotFoundException $exception) {
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

            $admin = CompanyAdministrator::where('id',$id)->withTrashed()->first();
            
            if($admin->deleted_at == null){
                if($admin->delete()){
                    $request->session()->flash('message', 'El usuario fue deshabilitado correctametne !');
                }
            }
            else{
                $admin->restore();
                $request->session()->flash('message', 'El usuario fue habilitado correctametne !');
            }

            $administrator = CompanyAdministrator::with('user','company')->withTrashed()->get();
            return view('showAdministrator',compact('administrator'));
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
    }
}
