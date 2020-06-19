{{-- ****************** MODAL FOR USERS ************ --}}
<div class="modal fade font-modal pr-0" id="modalPerfilUsuario">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white">Actualizar Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         
         {{-- <form method="post" id="form-perfil_usuario" enctype="multipart/form-data"> --}}
            {!! Form::open(['method' => 'POST', 'id' => 'form-perfil_usuario', 'files' => true]) !!}
            {!! Form::token() !!}
            <div class="row d-flex justify-content-center">
               <div class="col-12 col-md-11">
                  <div class="modal-body row">

                     <div class="col-12 col-md-12 col-lg-4 d-flex justify-content-center align-items-center">
                        <div class="row d-flex justify-content-center">
                           <div class="col-12 col-md-11 col-lg-10">


                              <a onclick="$('#miImagenInputModal').click()" id="mostrar_imagen">
                                 <img class="img-fluid" width="180" id="mi_img_modal" src="{{ url('/img/user.jpg') }}">
                              </a>
                              <div class="text-center font-mini">
                                 {!! Html::decode(Form::label('aviso', 'Máximo 1MB (1024KB)', ['class' => 'mt-2'])) !!}
                              </div>
                              <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none" id="imagen_usuario-error"></div>
                              {{-- ***** BOTON DE SUBIR IMAGEN ***** --}}
                              <div class="text-center mt-2">
                                 {!! Html::decode(Form::label('miImagenInputModal', '<i class="fas fa-cloud-upload-alt"></i> Subir Imagen', ['class' => 'btn btn-success btn-sm py-1', 'style' => 'cursor:pointer'])) !!}
                                 {!! Form::file('imagen_usuario', ['class' => 'custom-file-input subir', 'id' => 'miImagenInputModal', 'style' => 'display:none', 'accept' => 'image/x-png,image/jpeg']) !!}
                              </div>

                           </div>
                        </div>
                     </div>
                     

                     <div class="col-12 col-md-12 col-lg-8">
                        <div class="form-group row mx-0">
                           {!! Html::decode(Form::label('nom_usu', 'Usuario: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                           <div class="col-12 col-md-9 px-0">
                              {!! Form::text('nom_usu', null, ['class' => 'form-control form-control-sm letras' , 'id' => 'nom_usu', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DE USUARIO', 'old' => 'nom_usu', 'autofocus',]) !!}
                              <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="nom_usu-error"></div>
                           </div>
                        </div>
                        <div class="form-group row mx-0">
                           {!! Html::decode(Form::label('rol_usuario', 'Rol: <span class="text-danger font-weight-normal h6 ml-1"></span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                           <div class="col-12 col-md-9 px-0">
                              {!! Form::text('rol_usuario', null, ['class' => 'form-control form-control-sm' , 'id' => 'rol_usuario', 'readonly']) !!}
                              {!! Form::hidden('rol_usu', null, ['id' => 'rol_usu']) !!}
                              <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="rol_usu-error"></div>
                           </div>
                        </div>
                        <div class="form-group row mx-0">
                           {!! Html::decode(Form::label('email_usu', 'Email: <span class="text-danger font-weight-normal h6 ml-1"></span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                           <div class="col-12 col-md-9 px-0">
                              <div class="input-group">
                                 {!! Form::text('email_usu', null, ['class' => 'form-control form-control-sm font-normal', 'placeholder' => 'ejemplo@email.com', 'autocomplete' => 'off', 'readonly']) !!}
                                 <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                 </div>
                              </div>
                              <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="email_usu-error"></div>
                           </div>
                        </div>
                        <div class="form-group row mx-0 d-none">
                           {!! Html::decode(Form::label('est_usu', 'Estado: <span class="text-danger font-weight-normal h6 ml-1"></span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                           <div class="col-12 col-md-9 px-0">
                              {!! Form::text('est_usu', null, ['class' => 'form-control form-control-sm letras' , 'id' => 'est_usu', 'readonly']) !!}
                              <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="est_usu-error"></div>
                           </div>
                        </div>
                        <div class="form-group row mx-0">
                           {!! Html::decode(Form::label('cambiar', 'Cam. Contraseña: <span class="text-danger font-weight-normal h6 ml-1"></span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                           <div class="col-12 col-md-9 px-0">
                              {!! Form::checkbox('chekbox', null, null, ['id' => 'toggle-pass']) !!}
                           </div>
                        </div>
                        <div class="card border-secondary">
                           <div class="card-body">
                              <div class="form-group row">
                                 {!! Html::decode(Form::label('oldpass_usu', 'Contraseña Actual: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-5 px-0'])) !!}
                                 <div class="col-12 col-md-7 px-0">
                                    <div class="input-group">
                                       {!! Form::password('oldpassword_usu', ['class' => 'form-control form-control-sm' , 'placeholder' => 'Contraseña Actual', 'onpaste' => 'return false', 'autocomplete' => 'off', 'readonly', 'id' => 'oldpass_usu']) !!}
                                       <div class="input-group-append">
                                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                                       </div>
                                    </div>
                                    <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="oldpass_usu-error"></div>
                                 </div>
                              </div>

                              <div class="form-group row">
                                 {!! Html::decode(Form::label('pass_usu', 'Contraseña Nueva: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-5 px-0'])) !!}
                                 <div class="col-12 col-md-7 px-0">
                                    <div class="input-group">
                                       {!! Form::password('password_usu', ['class' => 'form-control form-control-sm' , 'placeholder' => 'Contraseña Nueva', 'onpaste' => 'return false', 'autocomplete' => 'off', 'readonly', 'id' => 'pass_usu']) !!}
                                       <div class="input-group-append">
                                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                                       </div>
                                    </div>
                                    <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="pass_usu-error"></div>
                                 </div>
                              </div>

                              <div class="form-group row mb-0">
                                 {!! Html::decode(Form::label('repass_usu', 'Confirmar Contraseña: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-5 px-0'])) !!}
                                 <div class="col-12 col-md-7 px-0">
                                    <div class="input-group">
                                       {!! Form::password('repassword_usu', ['class' => 'form-control form-control-sm' , 'placeholder' => 'Confirmar Contraseña', 'onpaste' => 'return false', 'autocomplete' => 'off', 'readonly', 'id' => 'repass_usu']) !!}
                                       {!! Form::hidden('repass', '0', ['id' => 'repass']) !!}
                                       <div class="input-group-append">
                                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                                       </div>
                                    </div>
                                    <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="repass_usu-error"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer text-center">
               {!! Form::hidden('action', 'ActualizarPerfil', ['class' => 'action']) !!}
               {!! Form::hidden('perfilusuario_id', null, ['id' => 'perfilusuario_id']) !!}
               {!! Form::button('<i class="far fa-sync-alt mr-2"></i>Actualizar', ['class'=>'btn btn-info btn-sm mr-1 action_button', 'type'=>'submit']) !!}
               {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
            </div>
         {{-- </form> --}}
         {!! Form::close() !!}
      </div>
   </div>
</div>