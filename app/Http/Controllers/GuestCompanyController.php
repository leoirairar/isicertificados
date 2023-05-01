<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Company;
use App\CompanyAdministrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsMail;

class GuestCompanyController extends Controller
{
    //

    public function insertCompanyGuest(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
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
            'status'=>'',
            'legal_agent'=>'required',
            'arl'=>'required',
            'sector_economico'=>'required',

            'name'=>'required',
            'last_name'=>'required',
            'identification_number'=>'required|numeric',
            'email'=>'required|email',
            'phone_number'=>'required',
            'password'=>'required|min:5',
            'document_type'=>'required',
            'position'=>'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{

            try {

          
            $company =  Company::create([
                'nit' => $request->nit,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email'=> $request->emailCompany,
                'accounting_contact_name'=> $request->accounting_contact_name,
                'accounting_contact_email'=> $request->accounting_contact_email,
                'accounting_contact_phone'=> $request->accounting_contact_phone,
                // 'humanresources_contact_name'=> $request->humanresources_contact_name,
                // 'humanresources_contact_email'=> $request->humanresources_contact_email,
                // 'humanresources_contact_phone'=> $request->humanresources_contact_phone,
                'website' => $request->website,
                'creation_date' => $request->creation_date,
                'country_id' => $request->country_id,
                'town_id' => $request->town_id,
                'status' => 0,
                'legal_agent' => $request->legal_agent,
                'arl' => $request->arl,  
                'sector_economico' => $request->sector_economico,
            ]);

            $user = new User;

            $user->name =  $request->name;
            $user->last_name =  $request->last_name;
            $user->email =  $request->email;
            $user->identification_number =  $request->identification_number;
            $user->document_type =  $request->document_type;
            $user->phone_number =  $request->phone_number;
            $user->password =  Hash::make($request->password);
            $user->role =  'A';
            $user->save();

            $userAdministrator = new CompanyAdministrator;
            $userAdministrator->user_id = $user->id;
            $userAdministrator->company_id = $company->id;
            $userAdministrator->position = $request->position;
            $userAdministrator->save();


            $datas = new \stdClass();
            $datas->message = 'Bienvenido a la plataforma de certificados ISI';
            $datas->url = $_SERVER['SERVER_NAME'];
            $datas->user = $user->email;
            $datas->subject = "Creacion de usuario administrador";
            $datas->password = $request->password;
            Mail::to($user->email)->send(new NotificationsMail($datas));
            

            //$request->session()->flash('message', 'La empresa fue resgistrada correctamente');
            session()->flash('message', 'Se ha registrado la empresa correctamente, ahora puede iniciar sesión con el correo y la contraseña del administrador de la empresa');
            return redirect()->route('login');
      

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

        //return $data;
    }
}
