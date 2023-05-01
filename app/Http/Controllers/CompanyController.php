<?php

namespace App\Http\Controllers;



use App\User;
use App\State;
use App\Country;
use App\Company;
use App\CompanyAdministrator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;
use Response;


class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['getInsertCompanyView','insertCompanyGuest']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            return view('showCompanies');

        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }


    }

    public function getCompaniesData(){

        $user = Auth::user()->load('companyAdministrator');
            if ($user->role == "A") {
                $companies = collect();
                $companiesAdministrator = CompanyAdministrator::where('user_id',$user->id)->with('company')->get();
                foreach ($companiesAdministrator as $companyAdministrator) {
                    $companies->push($companyAdministrator->company);
                }

                return  Response::json([$companies,$user]);
            }
            else {
                if ($user->role == "S" || $user->role == "M") {
                    $companies = Company::orderBy('company_name')->withTrashed()->get();
                    return  Response::json([$companies,$user]);
                }
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
            $countries = Country::where('id',44)->orderBy('name')->get();
            $states = State::where('country_id',44)->orderBy('name')->get();

        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
        return view('insertCompany')->with(['states'=>$states,'countries'=>$countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


            //dd($request);
            $data = $request->validate([
                'nit'=>'required',
                'company_name'=>'required',
                'address'=>'required',
                'phone_number'=>'required',
                'website'=>'',
                'creation_date'=>'',
                'emailCompany'=>'required|email',
                'accounting_contact_name'=>'required',
                'accounting_contact_email'=>'required',
                'accounting_contact_phone'=>'required',
                'humanresources_contact_name'=>'',
                'humanresources_contact_email'=>'',
                'humanresources_contact_phone'=>'',
                'country_id'=>'required|numeric',
                'town_id'=>'required|numeric',
                'status'=>'required',
                'legal_agent'=>'required',
                'arl'=>'required',
                'sector_economico'=>'required',
            ]);

            try {
                $company =  Company::create([
                    'nit' => $data['nit'],
                    'company_name' => $data['company_name'],
                    'address' => $data['address'],
                    'phone_number' => $data['phone_number'],
                    'email'=> $data['emailCompany'],
                    'accounting_contact_name'=> $data['accounting_contact_name'],
                    'accounting_contact_email'=> $data['accounting_contact_email'],
                    'accounting_contact_phone'=> $data['accounting_contact_phone'],
                    // 'humanresources_contact_name'=> $data['humanresources_contact_name'],
                    // 'humanresources_contact_email'=> $data['humanresources_contact_email'],
                    // 'humanresources_contact_phone'=> $data['humanresources_contact_phone'],
                    'website' => $data['website'],
                    'creation_date' => $data['creation_date'],
                    'country_id' => $data['country_id'],
                    'town_id' => $data['town_id'],
                    'status' => $data['status'],
                    'legal_agent' => $data['legal_agent'],
                    'arl' => $data['arl'],  
                    'sector_economico' => $data['sector_economico'],
                ]);
                if($data['status'] == 0)
                {
                    $company->delete();
                }

                $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',0)->get();
                $notificationData['detail'] = "Se han modificado los datos de la empresa ".$data['company_name'];
                $notificationData['adminId'] = $companyAdministrator;
                $notificationData['url'] = "";
                NotificationController::store($notificationData);

                foreach ($companyAdministrator as $compAdmin) {

                    $data = new \stdClass();
                    $data->message = $notificationData['detail'];
                    $data->subject = "Modificación de la empresa ".$company->company_name;
                    //Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
                }

                $companies = Company::orderBy('company_name')->withTrashed()->get();
                return view('showCompanies',compact('companies'));

            } catch (\Throwable $th) {
                $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage();
                return back()->withError($string)->withInput();
            }catch (ModelNotFoundException $exception) {
                $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage();
                return back()->withError($string)->withInput();
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $companies
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $countries = Country::where('id',44)->orderBy('name')->get();
            $states = State::where('country_id',44)->orderBy('name')->get();
            $company = Company::where('id',$id)->first();
            return view('updateCompany',compact('company','countries','states'));
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'nit'=>'required',
            'company_name'=>'required',
            'address'=>'required',
            'phone_number'=>'required',
            'website'=>'',
            'creation_date'=>'',
            'emailCompany'=>'required|email',
            'accounting_contact_name'=>'required',
            'accounting_contact_email'=>'required',
            'accounting_contact_phone'=>'required',
            'humanresources_contact_name'=>'',
            'humanresources_contact_email'=>'',
            'humanresources_contact_phone'=>'',
            'country_id'=>'required|numeric',
            'town_id'=>'required|numeric',
            'status'=>'required',
            'legal_agent'=>'',
            'arl'=>'required',
            'sector_economico'=>'required',
        ]);
        try {
            //code...

            $company = Company::find($id);

            $company->nit = $data['nit'];
            $company->company_name = $data['company_name'];
            $company->address = $data['address'];
            $company->phone_number = $data['phone_number'];
            $company->website = $data['website'];
            $company->email = $data['emailCompany'];
            $company->accounting_contact_name = $data['accounting_contact_name'];
            $company->accounting_contact_email = $data['accounting_contact_email'];
            $company->accounting_contact_phone = $data['accounting_contact_phone'];
            // $company->humanresources_contact_name = $data['humanresources_contact_name'];
            // $company->humanresources_contact_email = $data['humanresources_contact_email'];
            // $company->humanresources_contact_phone = $data['humanresources_contact_phone'];
            $company->creation_date = $data['creation_date'];
            $company->country_id = $data['country_id'];
            $company->town_id = $data['town_id'];
            $company->status = $data['status'];
            $company->legal_agent = $data['legal_agent'];
            $company->arl = $data['arl'];
            $company->sector_economico = $data['sector_economico'];
            $company->save();

            if($data['status'] == 0)
            {
                $company->delete();
            }

            $companyAdministrator = CompanyAdministrator::select('user_id')->where('company_id',0)->get();
            $notificationData['detail'] = "Se han modificado los datos de la empresa ".$data['company_name'];
            $notificationData['adminId'] = $companyAdministrator;
            $notificationData['url'] = "";
            NotificationController::store($notificationData);

            foreach ($companyAdministrator as $compAdmin) {

                $data = new \stdClass();
                $data->message = $notificationData['detail'];
                $data->subject = "Modificación de la empresa ".$company->company_name;
                //Mail::to($compAdmin->user->email)->send(new NotificationsMail($data));
            }

            $companies = Company::orderBy('company_name')->withTrashed()->get();
            return view('showCompanies',compact('companies'));
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try {

            $company = Company::where('id',$id)->withTrashed()->first();

            if($company->deleted_at == null){
                if($company->delete()){
                    $request->session()->flash('message', 'La empresa fue deshabilitada correctamente !');
                }
            }
            else{
                $company->restore();
                $request->session()->flash('message', 'La empresa fue habilitada correctamente !');
            }
            $companies = Company::orderBy('company_name')->withTrashed()->get();
            return view('showCompanies',compact('companies'));

        }catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }
    }


    public function getCompanyDetail($id)
    {
        try {
            $company = Company::where('id',$id)->with('employees.user')->withTrashed()->first();
            return view('showCompanyDetail',compact('company'));
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }

    }

    public function getCompanyConditions($id)
    {
        try {

            //$company = Company::where('id',$id)->with('employees')->withTrashed()->first();
            return view('chekConditions',compact('id'));
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }


    }

    public function updateCompanyTermsAndConditions(Request $request)
    {
        $data = $request->validate([
            'termsConditions'=>'required',
            'habeasData'=>'required',
            'companyAdmin'=>'required',
        ]);

        try {

            $companiesAdministrator = CompanyAdministrator::where('user_id',$data['companyAdmin'])->with('company')->get();
            foreach ($companiesAdministrator as $companyAdministrator) {
                $companyAdministrator->company->terms_conditions = $data['termsConditions'];
                $companyAdministrator->company->habeas_data = $data['habeasData'];
                $companyAdministrator->company->save();
            }

            return redirect('/');
        } catch (\Throwable $th) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }catch (ModelNotFoundException $exception) {
            $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
            ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
            return back()->withError($string)->withInput();
        }

    }

    public function getInsertCompanyView()
    {
        $countries = Country::where('id',44)->orderBy('name')->get();
        $states = State::where('country_id',44)->orderBy('name')->get();
        return view('insertCompanyGuest',compact('countries','states'));
    }

    public function insertCompanyGuest(Request $request)
    {
        return 'hola';
        $data = $request->validate([
            'nit'=>'required',
            'company_name'=>'required',
            'address'=>'required',
            'phone_number'=>'required',
            'website'=>'',
            'creation_date'=>'',
            'accounting_contact_name'=>'required',
            'accounting_contact_email'=>'required',
            'accounting_contact_phone'=>'required',
            'humanresources_contact_name'=>'',
            'humanresources_contact_email'=>'',
            'humanresources_contact_phone'=>'',
            'country_id'=>'required|numeric',
            'town_id'=>'required|numeric',
            'status'=>'required',
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
        dd($data);
    }



}
