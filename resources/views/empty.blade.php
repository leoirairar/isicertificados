@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">empty</div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
{{-- <script src="{{ asset('js/app/#.js') }}"></script> --}}
@endsection

{{\Carbon\Carbon::parse($unReadedNotifications[$i]->created_at)->isoFormat('MMMM DD YYYY, h:mm a')}}

<div class="table-responsive mt-5">
    <table class="table table-striped table-hover">
        <thead>
            <th></th>
        </thead>
        <tbody>
            @foreach ($ as $)
                <tr>
                    <td>{{}}</td>                    
                </tr>
            @endforeach 
        </tbody>
    </table>
</div>

<div class="table-responsive mt-5">
    <table class="table table-striped table-hover" id="enrollmentInformation">
        <thead> 
        </thead>
        <tbody>
        </tbody>
    </table>
</div>