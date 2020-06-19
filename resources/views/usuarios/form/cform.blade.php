<div class="row mb-0">
   <div class="col-12 col-lg-3 d-flex justify-content-center align-items-center">
      <div class="row d-flex justify-content-center">
         <div class="col-12 col-md-11 col-lg-10">
            <a onclick="$('#miImagenInput').click()" id="mostrar_imagen">
               <img class="img-fluid" width="180" id="mi_img" src="{{ url('/img/user.jpg') }}">
            </a>
            <div class="text-center font-mini">
               {!! Html::decode(Form::label('aviso', 'Máximo 1MB (1024KB)', ['class' => 'mt-2'])) !!}
               @include('usuarios.alertas.imagen_usu-request')
            </div>
            {{-- ***** BOTON DE SUBIR IMAGEN ***** --}}
            <div class="text-center mt-2">
               {!! Html::decode(Form::label('miImagenInput', '<i class="fas fa-cloud-upload-alt"></i> Subir Imagen', ['class' => 'btn btn-success btn-sm py-1', 'style' => 'cursor:pointer'])) !!}
               {!! Form::file('imagen_usu', ['class' => 'custom-file-input subir', 'id' => 'miImagenInput', 'style' => 'display:none', 'accept' => 'image/x-png,image/jpeg']) !!}
            </div>
         </div>
      </div>
   </div>


   <div class="col-12 col-lg-9">
      <div class="row">
         <div class="col-12 col-sm-6 col-lg-6 mt-2 px-sm-2{{ $errors->has('nom_usu') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombre de Usuario <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('nom_usu', null, ['class' => 'form-control form-control-sm alfanumerico' , 'placeholder' => 'Nombre de Usuario', 'autocomplete' => 'off', 'autofocus', 'id' => 'nom_usuario']) !!}
            @include('usuarios.alertas.nom_usu-request')
         </div>
         <div class="col-12 col-sm-6 col-lg-6 mt-2 px-sm-2{{ $errors->has('rol_usu') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('rol', 'Rol de Usuario <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::select('rol_usu', ['' => 'SELECCIONAR...'] + $rol, null, ['class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'id' => 'rol']) !!}
            @include('usuarios.alertas.rol_usu-request')
         </div>
         <div class="col-12 col-sm-8 col-lg-8 mt-2 px-sm-2">
            {!! Html::decode(Form::label('email', 'Email <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            <div class="input-group{{ $errors->has('email_usu') ? ' has-error' : ''}}">
               {!! Form::text('email_usu', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'ejemplo@email.com', 'autocomplete' => 'off', 'id' => 'email_usuario']) !!}
               <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-at"></i></span>
               </div>
            </div>
            @include('usuarios.alertas.email_usu-request')
         </div>
         <div class="col-12 col-sm-4 col-lg-4 mt-2 px-sm-2{{ $errors->has('est_usu') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('estado', 'Estado <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('est_usu', ['1' => 'ACTIVO', '0' => 'INACTIVO'], '1', ['class' => 'form-control form-control-sm', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_usuario']) !!}
            @include('usuarios.alertas.est_usu-request')
         </div>

         {{-- ***************** CAMPOS PARA CREAR USUARIO ******************** --}}
         <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-4 px-sm-2">
            <div class="card border-secondary">
               <div class="card-body">
                  <div class="form-group row">
                     <div class="col-12 col-sm-6 col-lg-6">
                        {!! Html::decode(Form::label('contraseña', 'Contraseña <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                        <div class="input-group{{ $errors->has('pass_usu') ? ' has-error' : ''}}">
                           {!! Form::password('pass_usu', ['class' => 'form-control form-control-sm' , 'placeholder' => 'Contraseña', 'onpaste' => 'return false', 'autocomplete' => 'off', 'id' => 'password_usu']) !!}
                           <div class="input-group-append">
                              <span class="input-group-text"><i class="fas fa-key"></i></span>
                           </div>
                        </div>
                        @include('usuarios.alertas.pass_usu-request')
                     </div>
                     <div class="col-12 col-sm-6 col-lg-6 mt-2 mt-lg-0">
                        {!! Html::decode(Form::label('recontraseña', 'Confirmar Contraseña <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                        <div class="input-group{{ $errors->has('repass_usu') ? ' has-error' : ''}}">
                           {!! Form::password('repass_usu', ['class' => 'form-control form-control-sm' , 'placeholder' => 'CONFIRMAR CONTRASEÑA', 'onpaste' => 'return false', 'autocomplete' => 'off', 'id' => 'repassword_usu']) !!}
                           <div class="input-group-append">
                              <span class="input-group-text"><i class="fas fa-key"></i>
                              </span>
                           </div>
                        </div>
                        @include('usuarios.alertas.repass_usu-request')
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>