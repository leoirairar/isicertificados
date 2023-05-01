<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProofAttendanceImport;
use Carbon\carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use App\ProofAttendance;

class ProofAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Excel::import(new ProofAttendanceImport,storage_path('app/public/SENA.xlsx'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       $proofs =  ProofAttendance::all();
        foreach ($proofs  as  $proof) {

            $firstArray = str_replace("DEL", "", $proof->expedition_date);
            $secondArray = str_replace("DE", "", $firstArray);
            $pieces = explode(" ", $secondArray);
            $pieces = array_diff($pieces, array(''));
            $month = 1;
            $arrayMonths = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
            var_dump($pieces);
            if (($key = array_search($pieces[2], $arrayMonths)) !== false) {

                $month = $key;
            }

            $date = Carbon::create($pieces[4], $month + 1, $pieces[0]);
            echo $proof->id." - ".$date->toDateString()."<br />";;
        }

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
