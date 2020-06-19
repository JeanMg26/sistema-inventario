@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-sm-9 col-md-7 col-lg-6 col-xl-4">
         <div class="card border-danger">
            <div class="card-header bg-danger text-white text-center font-weight" style="font-size: 14px">{{ __('Bienvenido') }}</div>
            <div class="card-body">
               <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group row">
                     {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label> --}}
                     <div class="col-12">
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="far fa-at"></i></span>
                           </div>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo electronico" name="email" autocomplete="email" value="{{ old('email') }}" required autofocus>
                           @error('email')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}
                     <div class="col-12">
                        <div class="input-group ">
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                           </div>
                           <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña"  autocomplete="current-password" name="password" required>
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     <div class="col-12">
                        <div class="icheck-danger">
                           <input type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="margin-top: 3px !important;">
                           <label class="form-check-label" for="remember">
                              {{ __('Recordar contraseña') }}
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group row mb-0">
                     <div class="col-md-12">
                        <button type="submit" class="btn btn-danger font-weight col-12">
                        {{ __('Ingresar') }}
                        </button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection