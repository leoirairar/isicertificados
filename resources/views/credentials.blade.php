
<div class="form-group row mail-pass">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

    <div class="col-md-6">
        @if ( $update == 'Y')
        <input id="email" type="email"  class="form-control @error('email') is-invalid @enderror email" name="email"  value="{{ (isset($user->email )) ? $user->email : old('email')  }}" required autocomplete="false"> 
        @else
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror email" name="email"  value="{{ (isset($user->email )) ? $user->email : old('email')  }}" required autocomplete="false">
        @endif
        @error('email')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span> @enderror
    </div>
</div>
@if ( $update != 'Y' || $needPass =='Y')
<div class="form-group row mail-pass">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror password" name="password" value="{{ (isset($user->password )) ? $user->password : old('password')  }}" required autocomplete="false"> 
        @error('password')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span> @enderror
    </div>
</div>
@endif

