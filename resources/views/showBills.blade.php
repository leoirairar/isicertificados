@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Dashboard</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    <nav>
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Facturas no pagadas</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Facturas pagadas</a>
                      </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <table class="table table-striped table-hover">
                                        <thead>
                                            <th>Consecutivo</th>
                                            <th>valor curso</th>
                                            <th>Empleado</th>
                                            <th>Estado</th>
                                            <th colspan="2">&nbsp;</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($unpaidBills as $unpaidBill)
                                            <tr>
                                                <td>{{$unpaidBill->bill_serial}}</td>
                                                <td>{{$unpaidBill->payment}}</td>
                                                <td>{{$unpaidBill->employee->user->name}}</td>
                                                <td>{{($unpaidBill->payment_status == 0)?'Sin pagar':''}}</td>
                                                <td width="10px">
                                                    <a href="{{url('editEmployeeBill/'.$unpaidBill->id)}}" class="btn btn-success">editar</a>
                                                </td>
                                            </tr>
                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table class="table table-striped table-hover">
                                        <thead>
                                            <th>Consecutivo</th>
                                            <th>valor curso</th>
                                            <th>Empleado</th>
                                            <th>curso</th>
                                            <th>Estado</th>
                                            <th colspan="2">&nbsp;</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($payedBills as $payedBill)
                                            <tr>
                                                <td>{{$payedBill->bill_serial}}</td>
                                                <td>{{$payedBill->payment}}</td>
                                                <td>{{$payedBill->employeeEnrollment->employee->user->name}}</td>
                                                <td>{{$payedBill->employeeEnrollment->courseProgramming->course->name}}</td>
                                                <td>{{($payedBill->payment_status == 1)?'Pagada':''}}</td>
                                                <td width="10px">
                                                    <a href="{{url('editEmployeeBill/'.$payedBill->id)}}" class="btn btn-success">editar</a>
                                                </td>
                                            </tr>
                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
