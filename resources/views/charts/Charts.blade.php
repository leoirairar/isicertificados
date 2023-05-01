@extends('layouts.app')

@section('content')
<h1>Usuarios chart</h1>

<div style="width: 50%">
        {!! $chart->container() !!}


</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js" charset="utf-8"></script>
{!! $chart->script() !!}
@endsection
