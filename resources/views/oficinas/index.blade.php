@extends('main')

@section('titulo')
   Oficinas
@endsection

@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-phone-office mr-1"></i>Oficinas</li>
</ol>

<div class="row mt-3">

   @can('OFICINA-CREAR')
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
            <table id="tabla_oficinas" class="table table-sm table-bordered table-hover text-nowrap w-100">
               <thead class="thead-danger">
                  <tr>
                     <td colspan="1" width="5%"></td>
                     <td class="d-none" colspan="1"></td>
                     <td width="25%" class="text-center" id="parent"> {!! Form::select('localD', ['' => ''] + $localD, null, ['class' => 'form-control form-control-sm', 'id' => 'buscar_select2']) !!} </td>
                     <td colspan="1" width="5%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna3"></td>
                     <td colspan="1" width="20%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna4"></td>
                     <td colspan="1" width="5%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna5"></td>
                     <td colspan="1" width="25%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna6"></td>
                     <td colspan="2" width="15%" class="text-center"><button type="button" class="btn btn-secondary btn-sm" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button></td>
                  </tr>
                  <tr class="text-center font-weight">
                     <th width="5%">Nº</th>
                     <th class="d-none">CODLOCAL</th>
                     <th width="25%">LOCAL</th>
                     <th width="5%">CODAREA</th>
                     <th width="20%">AREA</th>
                     <th width="5%">CODOFICINA</th>
                     <th width="25%">OFICINA</th>
                     <th width="5%">ESTADO</th>
                     <th width="10%">ACCIONES</th>
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
<div class="modal fade pr-0" id="modalOficina">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white">Nueva Área</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="form-oficina">
            @csrf
            <div class="d-flex justify-content-center">
               <div class="col-12 col-sm-10 col-md-10">
                  <div class="modal-body col-12 pb-2 pt-4">
                     <div class="form-group row">
                        {!! Html::decode(Form::label('local', 'Local: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::select('local', ['' => 'SELECCIONAR...'] + $local, null, ['class' => 'form-control form-control-sm font-normal', 'autofocus', 'id' => 'local']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="local-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('area', 'Área: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::select('area', [], null, ['class' => 'form-control form-control-sm font-normal', 'id' => 'area']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="area-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('codoficina', 'Cód. Oficina: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::text('cod_oficina', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'CÓDIGO DE LA OFICINA', 'id' => 'cod_oficina', 'autocomplete' => 'off', 'maxlength' => '15']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="cod_oficina-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('descripcion', 'Descripción: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::text('des_oficina', null, ['class' => 'form-control form-control-sm' , 'placeholder' => 'DESCRIPCIÓN', 'id' => 'des_oficina', 'autocomplete' => 'off', 'maxlength' => '40']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="des_oficina-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
                        <div class="col-12 col-md-9 px-0">
                           {!! Form::select('est_oficina', ['' => 'SELECCIONAR...', '1' => 'HABILITADO', '0' => 'DESHABILITADO'], '1', ['class' => 'form-control form-control-sm', 'id' => 'est_oficina']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="est_oficina-error"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
               {!! Form::hidden('action', 'Agregar', ['id' => 'action']) !!}
               {!! Form::hidden('oficina_id', null, ['id' => 'oficina_id']) !!}
               {!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-danger btn-sm mr-1 action_button', 'type' => 'submit']) !!}
               {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
            </div>
         </form>
      </div>
   </div>
</div>
{{-- *********** /AGREGAR/EDITAR - MODAL ************** --}}

{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade pr-0 oficina" id="showModal"  role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white text-center font-weight-bold">DETALLES DE LA OFICINA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body col-12">
            <div class="form-group row d-flex justify-content-center">

               <div class="col-12 col-md-10 row mt-3 mt-md-0">
                  {!! Form::label('cod_local', 'CÓDIGO DEL LOCAL:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lcod_local"></p>
                  </div>

                  {!! Form::label('des_local', 'NOMBRE DEL LOCAL:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="ldes_local"></p>
                  </div>

                  {!! Form::label('cod_area', 'CÓDIGO DEL ÁREA:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lcod_area"></p>
                  </div>

                  {!! Form::label('des_area', 'NOMBRE DEL ÁREA:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="ldes_area"></p>
                  </div>

                  {!! Form::label('cod_oficina', 'CÓDIGO DE LA OFICINA:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lcod_oficina"></p>
                  </div>

                  {!! Form::label('des_oficina', 'NOMBRE DE LA OFICINA:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="ldes_oficina"></p>
                  </div>

                  {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lest_oficina"></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
{{-- *********** /AGREGAR - MODAL ************** --}}


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
<script src="{{ asset('scripts/script_oficinas.js') }}"></script>
@endsection