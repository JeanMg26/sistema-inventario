@extends('main')

@section('titulo')
Coordinaciones
@endsection

@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-users-class mr-1"></i>Coordinaciones</li>
</ol>
<div class="row mt-3">

   @can('COORDINACION-LISTAR')
   <div class="col-12" align="right">
      <a href="{{ route('coordinaciones.create') }}" class="btn btn-labeled btn-success btn-sm mb-3">
         <span class="btn-label"><i class="fal fa-file-plus mr-2"></i></span>Nuevo Registro
      </a>
   </div>
   @endcan
   
   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">
            <div class="row d-flex justify-content-center mb-3">
               <div class="col-12 col-sm-8 col-md-6 col-lg-3 text-center" id="btn-year">
                  {!! Form::select('year', ['' => ''] + $year, null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'year']) !!}
               </div>
            </div>
            <table id="tabla_coordinaciones" class="table table-sm table-bordered text-nowrap w-100">
               <thead class="thead-danger">
                  <tr>
                     <td colspan="1"></td>
                     <td class="text-center" id="parent"> {!! Form::select('equipo', ['' => 'SELECCIONAR...'] + $equipo, null, ['class' => 'form-control form-control-sm', 'id' => 'buscar_select1']) !!} </td>
                     <td><input colspan="1" class="form-control form-control-sm form-control-xs filter" id="buscar_columna2" ></td>
                     <td><input colspan="1" class="form-control form-control-sm form-control-xs filter" id="buscar_columna3" ></td>
                     <td><input colspan="1" class="form-control form-control-sm form-control-xs filter" id="buscar_columna4" ></td>
                     <td class="d-none" colspan="7"></td>
                     <th colspan="3" class="text-center text-white font-weight-bold bg-uns"><span>BIENES TOTALES</span></th>
                     <td width="17%" colspan="4" width="15%" class="text-center"><button type="button" class="btn btn-secondary btn-sm" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button></td>
                  </tr>
                  <tr class="text-center font-weight">
                     <th scope="col">Nº</th>
                     <th scope="col">EQUIPO</th>
                     <th scope="col">CODLOCAL</th>
                     <th scope="col">CODAREA</th>
                     <th scope="col">CODOFICINA</th>
                     <th class="d-none">HOJA ENT</th>
                     <th class="d-none">STICKER ENT</th>
                     <th class="d-none">FECHA ENT</th>
                     <th class="d-none">HOJA RET</th>
                     <th class="d-none">STICKER RET</th>
                     <th class="d-none">ADIC RET</th>
                     <th class="d-none">FECHA RET</th>
                     <th scope="col">UBICADOS</th>
                     <th scope="col">NO UBICACOS</th>
                     <th scope="col">ADICIONALES</th>
                     <th class="d-none" scope="col">AÑO</th>
                     <th scope="col">ESTADO</th>
                     <th class="d-none">OBSERVACIÓN</th>
                     <th scope="col">ACCIONES</th>
                  </tr>
               </thead>
            <tbody class="text-center"></tbody>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}

{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade font-modal pr-0" id="showModal"  role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white text-center font-weight-bold">DETALLES DEL BIEN</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body col-12">
            <div class="form-group row d-flex justify-content-center">
               <div class="col-12 row">
                  {!! Form::label('nom_emp', 'NOMBRE DEL EQUIPO:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-8 ">
                     <p class="mb-2" id="lnom_equipo"></p>
                  </div>
                  {!! Form::label('nombre', 'NOMBRE:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0', 'id' => 'lnom1']) !!}
                  <div class="col-12 col-md-8" id="div-nom1">
                     <p class="mb-2" id="lnom_empleado1"></p>
                  </div>
                  {!! Form::label('nombre', 'NOMBRE:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0', 'id' => 'lnom2']) !!}
                  <div class="col-12 col-md-8" id="div-nom2">
                     <p class="mb-2" id="lnom_empleado2"></p>
                  </div>
                  {!! Form::label('local', 'LOCAL:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-8">
                     <p class="mb-2" id="llocal"></p>
                  </div>
                  {!! Form::label('area', 'AREA:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-8">
                     <p class="mb-2" id="larea"></p>
                  </div>
                  {!! Form::label('oficina', 'OFICINA:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-8">
                     <p class="mb-2" id="loficina"></p>
                  </div>
                  {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-8">
                     <p class="mb-2" id="lestado"></p>
                  </div>
                  <div class="col-12">
                     <hr class="mt-1">
                  </div>
                  <div class="table-responsive">
                     <table class="table table-bordered table-sm">
                        <thead class="text-center">
                           <tr class="bg-danger text-white">
                              <th class="font-weight-bold" colspan="2">Entrega</th>
                              <th class="font-weight-bold" colspan="3">Retorno</th>
                              <th class="font-weight-bold" colspan="3">Total de Bienes</th>
                           </tr>
                           <tr>
                              <th colspan="2"><p class="m-0" id="lfec_ent"></p></th>
                              <th colspan="3"><p class="m-0" id="lfec_ret"></p></th>
                              <th colspan="3"></th>
                           </tr>
                           <tr class="bg-cabecera-light text-white">
                              <th>Hojas</th>
                              <th>Stickers</th>
                              <th>Hojas</th>
                              <th>Stickers</th>
                              <th>Adicionales</th>
                              <th>Ubicados</th>
                              <th>No Ubicados</th>
                              <th>Adicionales</th>
                           </tr>
                        </thead>
                        <tbody class="text-center">
                           <tr>
                              <td><p class="m-0" id="lhoja_ent"></p></td>
                              <td><p class="m-0" id="lsticker_ent"></p></td>
                              <td><p class="m-0" id="lhoja_ret"></p></td>
                              <td><p class="m-0" id="lsticker_ret"></p></td>
                              <td><p class="m-0" id="ladic_ret"></p></td>
                              <td><p class="m-0" id="lbienes_ubi"></p></td>
                              <td><p class="m-0" id="lbienes_noubi"></p></td>
                              <td><p class="m-0" id="lbienes_adic"></p></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  {!! Form::label('observacion', 'OBSERVACIÓN:', ['class' => 'col-12 col-md-4 font-weight-bold mt-3 mt-md-0 mb-0']) !!}
                  <div class="col-12 col-md-8">
                     <p class="mb-2 text-justify" id="lobservacion"></p>
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
</div> <!-- end row -->
@endsection


@section('script')
<script src="{{ asset('scripts/script_coordinaciones.js') }}"></script>
@endsection