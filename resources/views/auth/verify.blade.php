@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-weight: bold">{{ __('Verifica tu correo electrónico.') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('un link de verificación ha sido enviado a tu correo electrónico.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, por favor mira en tu correo electrónico el link de verificacion.') }}
                    {{ __('Si no recibiste el correo electrónico') }}, <a href="{{ route('verification.resend') }}">{{ __('haz click aqui para solicitar uno nuevo.') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
