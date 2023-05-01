<?php

namespace App\Http\Controllers;


use App\Notification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class NotificationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        Carbon::setLocale('es');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // try{

            $readedNotifications = Notification::where('user_id',Auth::user()->id)->where('readed',1)->get();
            $unReadedNotifications = Notification::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->where('readed',0)->get();

            foreach ($unReadedNotifications as $unReadedNotification) {
                $unReadedNotification->readed = 1;
                $unReadedNotification->save();
            }

            return view('showNotificacions',compact('readedNotifications','unReadedNotifications'));
        // } catch (\Throwable $th) {
        //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // } catch (ModelNotFoundException $exception) {
        //     $string = "Ha ocurrido un problema.". " Error: ".$th->getMessage()." ".$th->getLine();
        //     ErrorLogController::store($th->getMessage(),$th->getLine(),__CLASS__,__METHOD__);
        //     return back()->withError($string)->withInput();
        // }
    }

    static function getNotifications()
    {
        try{
            $unReadedNotifications = Notification::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->where('readed',0)->get();
            return Response::json($unReadedNotifications);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function store($data)
    {
        foreach ($data['adminId'] as $d) {
            Notification::create([
                'detail'=>$data['detail'],
                'url'=>$data['url'],
                'readed'=>0,
                'user_id'=>$d->user_id,
            ]);
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

}
