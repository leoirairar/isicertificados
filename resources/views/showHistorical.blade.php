@extends('layouts.app')
 @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold">Historico de constancias. </div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success fade show">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table table-striped table-hover" id="historicalTable">
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
@endsection @section('scripts')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/app/historical.js') }}"></script>
<script src="{{ asset('js/app/general.js') }}"></script>
@endsection