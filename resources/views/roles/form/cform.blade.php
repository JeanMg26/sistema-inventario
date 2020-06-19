<div class="row">

   <div class="col-12 col-md-6">
      <div class="form-group row{{ $errors->has('nom_rol') ? ' has-error' : ''}}">
         {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-sm-2'])) !!}
         <div class="col-12 col-md-9">
            {!! Form::text('nom_rol', null, ['class' => "form-control form-control-sm alfanumerico" , 'id' => 'nom_rol', 'autofocus', 'autocomplete' => 'off', 'old'=> 'nom_rol']) !!}
            @include('roles.alertas.nom_rol-request')
            
         </div>
      </div>
   </div>

   <div class="col-12 col-md-6">
      <div class="form-group row">
         {!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-sm-2'])) !!}
         <div class="col-12 col-md-9{{ $errors->has('est_rol') ? ' has-error-select2' : ''}}">
            {!! Form::select('est_rol', ['1' => 'HABILITADO', '0' => 'DESHABILITADO'], '1', ['class' => 'form-control form-control-sm', 'placeholder' => 'SELECCIONAR...', 'id' => 'est_rol']) !!}
            @include('roles.alertas.est_rol-request')
         </div>
      </div>
   </div>

   <div class="col-12">
      <hr>
   </div>

   <div class="col-12">
      <div class="form-group row">
         <div class="col-12 mt-2">
            <div class="card card-border mb-0 {{ $errors->has('permisos') ? 'has-error-card' : ''}}">
               <div class="card-header bg-gris font-weight-bold">Permisos
               </div>
               <div class="card-body row">
                  @foreach($permiso as $value)
                  <div class="col-3">
                     <label class="{{ str_contains($value->nombre, 'ELIMINAR') ? 'text-danger' : '' }} mt-1">
                        {{ Form::checkbox('permisos[]', $value->id, false, ['class' => 'toggle-one', 'data-size'=> 'xs', 'data-onstyle' => 'success', 'data-offstyle' => 'danger']) }} {{ $value->module }} - {{ $value->nombre }}
                     </label>
                  </div>
                  @endforeach
               </div>
            </div>
            @include('roles.alertas.permiso-request')
            <div id="error-permiso-query"></div>
         </div>
      </div>
   </div>
</div>