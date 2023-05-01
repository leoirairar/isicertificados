<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HolidaysController extends Controller
{
    public function loadJason() 
    {
        $json = public_path().'\holidays.json';
        $str = file_get_contents($json);
        return json_decode($str, true);
        
        //dd($jsonDecode->holidays);
    }

    public function store()
    {
        $HolidaysObj = $this->loadJason();
        foreach ($HolidaysObj['holidays']['holidays'] as  $holiday) {
            Holiday::create([
                'holiday_date'=>$holiday['date'],
                'start'=>$holiday['start'],
                'end'=>$holiday['end'],
                'name'=>$holiday['name'],
                'country'=>$holiday['country']
            ]);
        }
    }

    public static function checkHolidaysToDay($day,$iteracion)
    {
       
        $dayString = new Carbon($day);//4 de noviembre 2019       
        $holiday = Holiday::whereDate('holiday_date','=',$dayString->toDateString())->get();//4 de noviembre 2020;
        
        if($iteracion == 2){
           // dd($holiday,$dayString);
        }
        if($holiday->count() != 0){
           
            return true;   
        }else{
            return false;
        }
        
        
    }

    public static function addWeekDayToWeekendDay($scheduleDayFormat,$iteracion,$countHolydays)
    {
        if($scheduleDayFormat->isoFormat('dddd') == 'Saturday' || $scheduleDayFormat->isoFormat('dddd') == 'Sunday')
        {
            if($scheduleDayFormat->isoFormat('dddd') == 'Saturday'){
                $scheduleDayFormat->addDay(2);
                
                if(HolidaysController::checkHolidaysToDay($scheduleDayFormat,$iteracion)){
                    $scheduleDayFormat->addDay();
                }
            }
            
            if($scheduleDayFormat->isoFormat('dddd') == 'Sunday'){
                if($countHolydays >= 2){
                    $scheduleDayFormat->addDay(2); 
                }
            }
            return $scheduleDayFormat;
        }
        return $scheduleDayFormat;
    }

    public static function checWeekendDay($schedulesDaysFormat){
        //dd($schedulesDaysFormat);
        foreach ($schedulesDaysFormat as $scheduleDayFormat) {
           $day =  $scheduleDayFormat->isoFormat('dddd');
           $weekDays = collect(['Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday']);
           return $weekDays->contains($day);
        }       
    }
}
