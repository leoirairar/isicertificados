<?php

namespace App\Http\Middleware;


use Closure;
use App\CompanyAdministrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class CheckCompanyConditions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        //dd(Auth::user());
        if (Auth::user()->role == 'A') {
           
            $companiesAdmin = CompanyAdministrator::where('user_id',Auth::user()->id)->with('Company')->get();
            foreach ($companiesAdmin as $companyAdmin) {
                if($companyAdmin->Company->terms_conditions == 0 && $companyAdmin->Company->habeas_data == 0){
                    $companiesId[] = $companyAdmin->Company->id;
                    
                }
            }
            if(isset($companiesId)){
                if(count($companiesId)>0)
                return redirect()->route('getCompanyConditions',Auth::user()->id); 
            }
            
        }
        
        

        return $next($request);
    }
}
