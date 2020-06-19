@extends('main')
@section('titulo')
Supervisión
@endsection
@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fad fa-laptop mr-1"></i>Supervisión</li>
</ol>
<div class="row mt-3">
   <div class="col-12" align="right">
      <button type="button" class="btn btn-labeled btn-success btn-sm mb-3" id="crear_registro">
      <span class="btn-label"><i class="fal fa-file-plus mr-2"></i></span>Nuevo Registro
      </button>
   </div>
   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">
            <div class="row d-flex justify-content-center mb-3">
               <div class="col-12 col-sm-8 col-md-6 col-lg-3 text-center" id="btn-year">
                  {!! Form::select('year', ['' => ''] + $year, null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'year']) !!}
               </div>
            </div>
            {{-- ******** FILTRAR POR FECHAS ************ --}}
            <div class="card mb-3 border-uns">
               <div class="card-header text-white font-weight-bold bg-danger collapsed" data-toggle="collapse" data-target="#filtro_fechas">Filtrar por Fechas
                  <a class="float-right" data-toggle="collapse" data-target="#filtro_fechas" class="collapsed">
                     <em class="fa fa-plus"></em>
                  </a>
               </div>
               <div class="collapse show" id="filtro_fechas" style="">
                  <div class="card-body row d-flex justify-content-center">
                     <div class="col-12 col-lg-12 col-xl-11">
                        <div class="row">
                           <div class="col-12 col-sm-6 col-lg-4 pr-sm-0">
                              <div class="row mx-1">
                                 <div class="input-group">
                                    {!! Form::text('fecha_desde', null, ['class' => 'form-control form-control-sm text-center' , 'id' => 'fecha_desde', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DESDE']) !!}
                                    <div class="input-group-append">
                                       <span class="input-group-text"><i class="fal fa-calendar-alt"></i>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6 col-lg-4 mt-1 mt-sm-0">
                              <div class="row mx-1">
                                 <div class="input-group">
                                    {!! Form::text('fecha_hasta', null, ['class' => 'form-control form-control-sm text-center' , 'id' => 'fecha_hasta', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'HASTA']) !!}
                                    <div class="input-group-append">
                                       <span class="input-group-text"><i class="fal fa-calendar-alt"></i>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-lg-4 text-center mt-3 mt-lg-0">
                              {!! Form::button('<i class="far fa-filter mr-2"></i>Filtrar', ['class'=>'btn btn-info btn-sm px-4 mr-2', 'type' => 'button', 'id' => 'filtrar']) !!}
                              {!! Form::button('<i class="far fa-broom mr-2"></i>Reiniciar', ['class'=>'btn btn-secondary btn-sm px-3', 'type' => 'button', 'id' => 'reiniciar']) !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <table id="tabla_supervisiones" class="table table-sm table-bordered table-hover text-nowrap w-100">
               <thead class="thead-danger">
                  <tr>
                     <td colspan="1"></td>
                     <td colspan="1" class="text-center" id="parent"> {!! Form::select('equipoBuscar', ['' => ''] + $equipoBuscar, null, ['class' => 'form-control form-control-sm', 'id' => 'buscar_select1']) !!} </td>
                     <td colspan="5"></td>
                  </tr>
                  <tr class="text-center font-weight">
                     <th scope="col">Nº</th>
                     <th scope="col">EQUIPO</th>
                     <th scope="col">BIENES ENCONTRADOS</th>
                     <th scope="col">BIENES ADICIONALES</th>
                     <th scope="col">FECHA</th>
                     <th class="d-none" scope="col">AÑO</th>
                     <th scope="col">ACCIONES</th>
                  </tr>
               </thead>
            <tbody class="text-center"></tbody>
            <tfoot class="thead-danger">
            <tr class="text-center">
               <th colspan="2" class="font-weight-bold" id="ltotal" class="font-weight-bold">TOTAL</th>
               <th colspan="1" class="font-weight-bold" id="total_bienes_enc"></th>
               <th colspan="1" class="font-weight-bold" id="total_bienes_adic"></th>
               <th colspan="3" id="vacio"></th>
            </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}
{{-- *********** AGREGAR/EDITAR - MODAL ************** --}}
<div class="modal fade font-modal pr-0" id="modalSupervision"  role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white">Nuevo Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="form-supervision">
            @csrf
            <div class="d-flex justify-content-center">
               <div class="col-12 col-sm-12 col-md-11">
                  <div class="modal-body col-12 pb-2 pt-4">
                     <div class="form-group row">
                        {!! Html::decode(Form::label('equipo', 'Equipo: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5 px-lg-0'])) !!}
                        <div class="col-12 col-lg-7 px-lg-0">
                           {!! Form::select('equipo', ['' => 'SELECCIONAR...'] + $equipo, null, ['class' => 'form-control form-control-sm font-normal', 'autofocus', 'id' => 'equipo']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="equipo-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('bienes', 'Bienes Encontrados: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5 px-lg-0'])) !!}
                        <div class="col-12 col-lg-7 px-lg-0">
                           <div class="input-group">
                              {!! Form::text('bienes_enc', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'bienes_enc', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
                              <div class="input-group-append">
                                 <span class="input-group-text"><i class="far fa-map-marker-check"></i>
                                 </span>
                              </div>
                           </div>
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="bienes_enc-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Form::label('bienes', 'Bienes Adicionales: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5 px-lg-0']) !!}
                        <div class="col-12 col-lg-7 px-lg-0">
                           <div class="input-group">
                              {!! Form::text('bienes_adic', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'bienes_adic', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
                              <div class="input-group-append">
                                 <span class="input-group-text"><i class="far fa-map-marker-plus"></i>
                                 </span>
                              </div>
                              <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="bienes_adic-error"></div>
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Html::decode(Form::label('fecha', 'Fecha: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-sm-2 col-md-5 px-lg-0'])) !!}
                        <div class="col-12 col-lg-7 px-lg-0">
                           <div class="input-group">
                              {!! Form::text('fecha', null, ['class' => 'form-control form-control-sm datepicker' , 'id' => 'fecha', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                              <div class="input-group-append">
                                 <span class="input-group-text"><i class="fal fa-calendar-alt"></i>
                                 </span>
                              </div>
                           </div>
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="fecha-error"></div>
                        </div>
                     </div>
                     <div class="form-group row">
                        {!! Form::label('observacion', 'Observaciones: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-12 px-lg-0']) !!}
                        <div class="col-12 col-lg-12 px-lg-0">
                           <div class="input-group">
                              {!! Form::textarea('observacion', null, ['class' => 'form-control form-control-sm' , 'id' => 'observacion', 'autocomplete' => 'off', 'rows' => '3', 'maxlength' => '150', 'style' => 'resize:none']) !!}
                           </div>
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="observacion-error"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
               {!! Form::hidden('action', 'Agregar', ['id' => 'action']) !!}
               {!! Form::hidden('supervision_id', null, ['id' => 'supervision_id']) !!}
               {!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-danger btn-sm mr-1', 'type'=>'submit', 'name' => 'action_button', 'id' => 'action_button' ,'value' => 'Agregar']) !!}
               {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
            </div>
         </form>
      </div>
   </div>
</div>
{{-- *********** /AGREGAR/EDITAR - MODAL ************** --}}
{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade pr-0 supervision" id="showModal"  role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white text-center font-weight-bold">Detalle del Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body col-12">
            <div class="form-group row d-flex justify-content-center">
               <div class="col-12 col-md-10 row mt-3 mt-md-0">
                  {!! Form::label('equipo', 'NOMBRE DEL EQUIPO:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lequipo"></p>
                  </div>
                  {!! Form::label('bienes_enc', 'BIENES ENCONTRADOS:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lbienes_enc"></p>
                  </div>
                  {!! Form::label('bienes_adic', 'BIENES ADICIONALES:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lbienes_adic"></p>
                  </div>
                  {!! Form::label('fecha', 'FECHA:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lfecha"></p>
                  </div>
                  {!! Form::label('observacion', 'OBSERVACIÓN:', ['class' => 'col-12 col-sm-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-sm-7 ">
                     <p class="mb-2" id="lobservacion"></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
{{-- *********** /SHOW - MODAL ************** --}}
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
</div> <!-- end row -->
@endsection
@section('script')
<script src="{{ asset('scripts/script_supervisiones.js') }}"></script>
@endsection