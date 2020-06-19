@extends('main')

@section('titulo')
Locales
@endsection

@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fad fa-building mr-1"></i>Locales</li>
</ol>

<div class="row mt-3">
   @can('LOCAL-LISTAR')
   <div class="col-12" align="right">
      <button type="button" class="btn btn-labeled btn-success btn-sm mb-3" id="crear_registro">
      <span class="btn-label"><i class="fal fa-file-plus mr-2"></i></span>Nuevo Registro
      </button>
   </div>
   @endcan



   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">
            <table id="tabla_locales" class="table table-sm table-bordered table-hover text-nowrap w-100">
               <thead class="thead-danger">
                  <tr>
                     <td colspan="1" width="5%"></td>
                     <td colspan="1" width="15%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna1"></td>
                     <td colspan="1" width="45%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna2"></td>
                     <td colspan="2" width="25%" class="text-center"><button type="button" class="btn btn-secondary btn-sm" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button></td>
                  </tr>
                  <tr class="text-center font-weight">
                     <th width="5%">Nº</th>
                     <th width="15%">CODLOCAL</th>
                     <th width="55%">DESCRIPCION</th>
                     <th width="10%">ESTADO</th>
                     <th width="15%">ACCIONES</th>
                  </tr>
               </thead>
            <tbody class="text-center"></tbody>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}
</div> <!-- end row -->

{{-- *********** AGREGAR/EDITAR - MODAL ************** --}}
<div class="modal fade pr-0" id="modalLocal">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white">Nuevo Rol</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="form-local">
            @csrf
            <div class="d-flex justify-content-center">
               <div class="col-12  col-md-11">
                  <div class="modal-body col-12 pb-2 pt-4">
                     <div class="form-group row">
                        {!! Html::decode(Form::label('nombre', 'Cód. Local: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::text('cod_local', null, ['class' => 'form-control form-control-sm numerico', 'placeholder' => 'CÓDIGO DE LOCAL', 'id' => 'cod_local', 'autofocus', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="cod_local-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('nombre', 'Descripción: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::text('des_local', null, ['class' => 'form-control form-control-sm alfanumerico' , 'placeholder' => 'DESCRIPCIÓN', 'id' => 'des_local', 'autocomplete' => 'off', 'maxlength' => '40']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="des_local-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::select('est_local', ['' => 'SELECCIONAR...', '1' => 'HABILITADO', '0' => 'DESHABILITADO'], '1', ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'est_local']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="est_local-error"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
               {!! Form::hidden('action', 'Agregar', ['id' => 'action']) !!}
               {!! Form::hidden('local_id', null, ['id' => 'local_id']) !!}
               {!! Form::button('<i class="fas fa-save mr-2"></i>Agregar', ['class'=>'btn btn-danger btn-sm mr-1 action_button', 'type'=>'submit']) !!}
               {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
            </div>
         </form>
      </div>
   </div>
</div>
{{-- *********** /AGREGAR/EDITAR - MODAL ************** --}}

   {{-- *********** MOSTRAR - MODAL ************** --}}
   <div class="modal fade pr-0" id="showModal"  role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
               <h5 class="modal-title font-modal text-white text-center font-weight-bold">DETALLES DEL LOCAL</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body col-12">
               <div class="form-group row d-flex justify-content-center">

                  <div class="col-12 col-md-9 row mt-3 mt-md-0">
                     {!! Form::label('cod_local', 'CÓDIGO DEL LOCAL:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-7 ">
                        <p class="mb-2" id="lcod_local"></p>
                     </div>

                     {!! Form::label('des_local', 'NOMBRE DEL LOCAL:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-7 ">
                        <p class="mb-2" id="ldes_local"></p>
                     </div>
    
                     {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-7 ">
                        <p class="mb-2" id="lest_local"></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{-- *********** /MOSTRAR - MODAL ************** --}}


{{-- ************* ELIMINAR - MODAL **************** --}}
<div class="modal fade font-modal" id="confirmModal" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white">Eliminar Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p class="text-center mb-0">Deseas eliminar este registro?</p>
         </div>
         <div class="modal-footer d-flex justify-content-center">
            {!! Form::button('Si, Eliminar', ['class'=>'btn btn-danger btn-sm mr-1', 'type'=>'button', 'name' => 'ok_button', 'id' => 'ok_button']) !!}
            {!! Form::button('No, Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
         </div>
      </div>
   </div>
</div>
{{-- ************* /DELETE- MODAL **************** --}}
@endsection

@section('script')
<script src="{{ asset('scripts/script_locales.js') }}"></script>
@endsection