@extends('layouts.app')
@section('content')
<div class="">
   <div class="">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header" style="font-weight: bold">Consultar historico</div>
            @if (session('error'))
               <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body">
                     <div class="row">
                         {{-- <div class="input-group date col-md-4" id="chartdatetimepicker1" data-target-input="nearest">
                            <input type="text"  id="begin_date1" class="form-control datetimepicker-input @error('begin_date1') is-invalid @enderror" data-target="#chartdatetimepicker1" name="begin_date1" value="{{ old('begin_date1') }}" required autocomplete="begin_date1" autofocus/>
                            <div class="input-group-append" data-target="#chartdatetimepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                         </div>
                        <div class="input-group date col-md-4" id="chartdatetimepicker2" data-target-input="nearest">
                            <input type="text" id="end_date2"  class="form-control datetimepicker-input @error('end_date2') is-invalid @enderror" data-target="#chartdatetimepicker2" name="end_date2" value="{{ old('end_date2') }}" required autocomplete="end_date2" autofocus/>
                            <div class="input-group-append" data-target="#chartdatetimepicker2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn btn-primary" id="certificatesUsersBetweenDates">filtrar</div>
                        </div> --}}
                        <div class="col-md-12 mt-5">
                              {{-- <button type="button" id="btncreateEnrollmentDocument" class="btn btn-success mt-3" style="margin-top: 14px;">Generar lista</button> --}}
                              <a href="{{url('createEnrollmentDocument')}}" class="btn btn-success">Generar historico</a>
                       </div>
                     </div>
               <div id="container">
                  <div class="table-responsive mt-5">
                      <table class="table table-striped table-hover" id="enrollmentInformation">
                          <thead> 
                          </thead>
                          <tbody>
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
@section('scripts')
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/app/historyEnrollments.js') }}"></script>
@endsection

