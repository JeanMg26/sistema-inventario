{{-- *************** CARGAR IMAGEN ************** --}}
<div class="row mb-0">
   <div class="col-12 col-md-12 col-lg-3 d-flex justify-content-center align-items-center">
      <div class="row d-flex justify-content-center">
         <div class="col-12 col-md-11 col-lg-10">
            <a onclick="$('#miImagenInput').click()" id="mostrar_imagen">
               @if ($empleado->rutaimagen == "")
               <img class="img-fluid" width="180" id="mi_img" src="{{ url('/img/user.jpg') }}">
               @else
               <img class="img-fluid" width="180" id="mi_img" src="/uploads/{{$empleado->rutaimagen}}">
               @endif
            </a>
            <div class="text-center font-mini">
               {!! Html::decode(Form::label('aviso', 'Máximo 1MB (1024KB)', ['class' => 'font-weight-bold mt-2'])) !!}
               @include('empleados.alertas.imagen_emp-request')
            </div>
            {{-- ***** BOTON DE SUBIR IMAGEN ***** --}}
            <div class="text-center mt-2">
               {!! Html::decode(Form::label('miImagenInput', '<i class="fas fa-cloud-upload-alt"></i> Subir Imagen', ['class' => 'btn btn-info btn-sm py-1'])) !!}
               {!! Form::file('imagen_emp', ['class' => 'custom-file-input subir', 'id' => 'miImagenInput', 'style' => 'display:none', 'accept' => 'image/x-png,image/jpeg']) !!}
            </div>
         </div>
      </div>
   </div>
   <div class="col-12 col-lg-9">
      <div class="row">
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('tipodoc_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('tipodocumento', 'Tipo de Documento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold ledit'])) !!}
            {!! Form::select('tipodoc_emp', ['CARNET DE EXTRANJERIA' => 'CARNET DE EXTRANJERIA', 'DNI' => 'DNI'], isset($empleado) ? $empleado->tipodoc : '', ['class' => 'form-control form-control-sm', 'placeholder'=> 'SELECCIONAR...', 'id' => 'tipodoc_empleado']) !!}
            @include('empleados.alertas.tipodoc_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2">
            {!! Html::decode(Form::label('nrodoc', 'Nro de Documento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            <div class="input-group{{ $errors->has('nrodoc_emp') ? ' has-error' : ''}}">
               {!! Form::text('nrodoc_emp', isset($empleado) ? $empleado->nrodoc : '', ['class' => 'form-control form-control-sm numerico', 'placeholder' => 'Numero de Dni', 'maxlength' => '8', 'autocomplete' => 'off', 'id' => 'nrodoc_emp']) !!}
               <div class="input-group-append">
                  <span class="input-group-text"><i class="fal fa-id-card"></i></span>
               </div>
            </div>
            @include('empleados.alertas.nrodoc_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md- col-lg-4 mt-2">
            {!! Html::decode(Form::label('nacimiento', 'Fec. Nacimiento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            <div class="input-group{{ $errors->has('fec_nac') ? ' has-error' : ''}}">
               {!! Form::text('fec_nac', isset($empleado) ? date('d-m-Y', strtotime($empleado->fec_nac))  : '', ['class' => 'form-control form-control-sm numerico', 'placeholder' => 'DD-MM-YYYY', 'maxlength' => '10', 'autocomplete' => 'off', 'readonly', 'id' => 'fec_nac', 'old' => 'fec_nac']) !!}
               <div class="input-group-append">
                  <span class="input-group-text"><i class="fal fa-calendar-alt"></i></span>
               </div>
            </div>
            @include('empleados.alertas.fec_nac-request')
         </div>


         <div class="col-12 col-sm-6 col-md-6 col-lg-6 mt-2{{ $errors->has('nom_emp') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombres <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::text('nom_emp', isset($empleado) ? $empleado->nombres : '', ['class' => 'form-control form-control-sm letras' , 'placeholder' => 'Nombres', 'autocomplete' => 'off', 'maxlength' => '40',  'id' => 'nom_emp']) !!}
            @include('empleados.alertas.nom_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-6 mt-2{{ $errors->has('ape_emp') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('apellido', 'Apellidos <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::text('ape_emp', isset($empleado) ? $empleado->apellidos : '', ['class' => 'form-control form-control-sm font-normal', 'id' => 'paterno', 'placeholder' => 'Apellidos', 'onkeypress' => 'return soloLetras(event);', 'onpaste' => 'return false', 'autocomplete' => 'off','maxlength' => '40',  'id' => 'ape_emp']) !!}
            @include('empleados.alertas.ape_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-8 mt-2">
            {!! Html::decode(Form::label('email', 'Correo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            <div class="input-group{{ $errors->has('email_usu') ? ' has-error' : ''}}">
               {!! Form::text('email_emp', isset($empleado) ? $empleado->email : '', ['class' => 'form-control form-control-sm', 'placeholder' => 'ejemplo@abc.com', 'autocomplete' => 'off', 'maxlength' => '40', 'id' => 'email_emp']) !!}
               <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-at"></i></span>
               </div>
            </div>
            @include('empleados.alertas.email_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('gen_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('genero', 'Género <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('gen_emp', ['M' => 'MASCULINO', 'F' => 'FEMENINO'], isset($empleado) ? $empleado->genero : '', ['class' => 'form-control form-control-sm deshabilitar', 'placeholder'=> 'SELECCIONAR...', 'id' => 'gen_empleado']) !!}
            @include('empleados.alertas.gen_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-8 mt-2{{ $errors->has('prof_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('profesion', 'Profesión <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('prof_emp', ['' => ''] + $profesion, isset($empleado) ? $empleado->profesiones_id : '', ['class' => 'form-control form-control-sm', 'id' => 'prof_emp']) !!}
            @include('empleados.alertas.prof_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('cargo_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('cargo', 'Cargo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('cargo_emp', ['' => ''] + $rol, $usuarioRol, ['class' => 'form-control form-control-sm', 'id' => 'cargo_emp']) !!}
            @include('empleados.alertas.cargo_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('equipo_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('equipo', 'Equipo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('equipo_emp', ['' => ''] + $equipo, isset($empleado) ? $empleado->equipos_id : '', ['class' => 'form-control form-control-sm', 'id' => 'equipo_emp']) !!}
            @include('empleados.alertas.equipo_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2">
            {!! Html::decode(Form::label('celular', 'Celular', ['class' => 'font-weight-bold mt-1'])) !!}
            <div class="input-group{{ $errors->has('cel_emp') ? ' has-error' : ''}}">
               {!! Form::text('cel_emp', isset($empleado) ? $empleado->celular : '', ['class' => 'form-control form-control-sm numerico', 'placeholder' => '999999999', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'cel_emp']) !!}
               <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-mobile-android-alt"></i></span>
               </div>
            </div>
            @include('empleados.alertas.cel_emp-request')
         </div>
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('est_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('estado', 'Estado <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('est_emp', ['1' => 'ACTIVO', '0' => 'INACTIVO'], isset($empleado) ? $empleado->estado : '', ['class' => 'form-control form-control-sm', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_empleado']) !!}
            @include('empleados.alertas.est_emp-request')
         </div>
      </div>
   </div>
</div>