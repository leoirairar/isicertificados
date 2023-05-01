<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeEnrollment;
use App\Bill;
use App\Employee;
Use Alert;
use Response;
use DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $payedBills = Bill::where('payment_status',1)->with('employeeEnrollment.employee.user','employeeEnrollment.courseProgramming.course')->get();
            $unpaidBills = Bill::where('payment_status',0)->with('employeeEnrollment.employee.user','employeeEnrollment.courseProgramming.course')->get();

            return view('showBills',compact('payedBills','unpaidBills'));
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

            $employeesEnrollment = EmployeeEnrollment::with(['employee' => function ($q) {
                $q->withTrashed()->with('user');
             }])->doesntHave('bill')->with('courseProgramming.course')->get();
            return view('insertBill',compact('employeesEnrollment'));

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
            'payment'=>'required',
            'billSerial'=>'required',
            'enrollmentId'=>'required',
            'paymentStatus'=>'required',
            'paymentDay'=>'',
        ]);
        try{
            Bill::create([
                'enrollments_id'=>$data['enrollmentId'],
                'payment'=>$data['payment'],
                'bill_serial'=>$data['billSerial'],
                'payment_day'=> isset($data['paymentDay'])?$data['paymentDay']:null,
                'payment_status'=>$data['paymentStatus'],
            ]);

            
            return redirect()->action('BillController@index');
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
            $employeesEnrollment = EmployeeEnrollment::orderby('id')->with('employee.user','courseProgramming.course')->get();
            $bill = Bill::where('id',$id)->with('employeeEnrollment.employee.user','employeeEnrollment.courseProgramming.course')->first();
            return view('updateBill',compact('bill','employeesEnrollment'));
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
            'payment'=>'required',
            'billSerial'=>'required',
            'enrollmentId'=>'',
            'paymentStatus'=>'required',
            'paymentDay'=>'',
        ]);
        try{
            $bill = Bill::where('id',$id)->first();

            $bill->payment = $data['payment'];
            $bill->bill_serial = $data['billSerial'];
            $bill->payment_status = $data['paymentStatus'];
            $bill->payment_day = isset($data['paymentDay'])?$data['paymentDay']:null;
            $bill->save();

            if($request->ajax()){
                return Response::json([true]);
            }else{
                 return redirect()->action('BillController@index');
            }
            
           
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
    public function destroy($id)
    {
        //
    }

    public function billStatusView(){

       return view('showBillEstatus');
    }

    public function getIndebtedEmployees()
    {
        $indebtedEmployees =  DB::table('bills')
        ->join('course_employees_enrollment', 'course_employees_enrollment.id', '=', 'bills.enrollments_id')
        ->join('employees', 'employees.id', '=', 'course_employees_enrollment.employee_id')
        ->join('companies', 'companies.id', '=', 'employees.company_id')
        ->join('users', 'users.id', '=', 'employees.user_id')
        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
        ->join('courses','courses.id', '=' ,'course_programming.course_id')
        ->select(
                'users.name as name',
                'users.last_name as last_name',
                'companies.company_name as company_name',
                'courses.name as course_name',
                'course_programming.begin_date as begin_date',
                'bills.bill_serial',
                'bills.payment',
                'bills.payment_status',
                'bills.id'
                )
        ->where('bills.payment_status', '=', 0)->get();

        
        
        return Response::json($indebtedEmployees);
    }

    public function getDebtFreeEmployees()
    {
        $debtFreeEmployees =  DB::table('bills')
        ->join('course_employees_enrollment', 'course_employees_enrollment.id', '=', 'bills.enrollments_id')
        ->join('employees', 'employees.id', '=', 'course_employees_enrollment.employee_id')
        ->join('companies', 'companies.id', '=', 'employees.company_id')
        ->join('users', 'users.id', '=', 'employees.user_id')
        ->join('course_programming', 'course_programming.id', '=', 'course_employees_enrollment.course_programming_id')
        ->join('courses','courses.id', '=' ,'course_programming.course_id')
        ->select(
                'users.name as name',
                'users.last_name as last_name',
                'companies.company_name as company_name',
                'courses.name as course_name',
                'course_programming.begin_date as begin_date',
                'bills.bill_serial',
                'bills.payment',
                'bills.payment_status',
                'bills.id'
                )
        ->where('bills.payment_status', '=', 1)->get();

        return Response::json($debtFreeEmployees);
    }
}
