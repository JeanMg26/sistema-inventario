@extends('main')
@section('titulo')
Cruces
@endsection
@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="far fa-crosshairs mr-1"></i>Cruces</li>
</ol>
<div class="row mt-3">
   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">
            <div class="row d-flex justify-content-center mb-3">
               <div class="col-12 col-sm-8 col-md-6 col-lg-3 text-center" id="btn-year">
                  {!! Form::select('year', ['' => ''] + $year, null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'year']) !!}
               </div>
            </div>
            <table id="tabla_cruces" class="table table-sm table-bordered text-nowrap w-100">
               <thead class="thead-danger">
                  <tr class="text-center font-weight">
                     <th colspan="4"></th>
                     <th colspan="3" style="font-size: 13px !important; padding: 10px 10px !important;">BIENES - BASE DE DATOS</th>
                     <th colspan="3" style="font-size: 13px !important; padding: 10px 10px !important;">BIENES - LUGAR FÍSICO</th>
                     <th colspan="2"></th>
                  </tr>
                  <tr>
                     <td colspan="1"></td>
                     <td class="text-center" id="parent"> {!! Form::select('equipo', ['' => 'SELECCIONAR...'] + $equipo, null, ['class' => 'form-control form-control-sm', 'id' => 'buscar_select1']) !!} </td>
                     <td><input colspan="1" class="form-control form-control-sm form-control-xs filter" id="buscar_columna2" ></td>
                     <td><input colspan="1" class="form-control form-control-sm form-control-xs filter" id="buscar_columna3" ></td>
                     <td colspan="9"></td>
                  </tr>
                  <tr class="text-center font-weight">
                     <th scope="col">Nº</th>
                     <th scope="col">EQUIPO</th>
                     <th scope="col">CODBIEN</th>
                     <th scope="col">NOMBRE DEL BIEN</th>
                     <th scope="col">CODLOCAL</th>
                     <th scope="col">CODAREA</th>
                     <th scope="col">CODOFICINA</th>
                     <th scope="col">CODLOCAL</th>
                     <th scope="col">CODAREA</th>
                     <th scope="col">CODOFICINA</th>
                     <th class="d-none" scope="col">AÑO</th>
                     <th scope="col">ACCIONES</th>
                  </tr>
               </thead>
               <tbody class="text-center">
               </tbody>
            </table>
         </div>
      </div>
   </div>
   {{-- *********** MOSTRAR - MODAL ************** --}}
   <div class="modal fade font-modal pr-0" id="showModal"  role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
               <h5 class="modal-title font-modal text-white text-center font-weight-bold">Detalles del Cruce</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body col-12">
               <div class="form-group row d-flex justify-content-center">
                  <div class="col-12 row">
                     {!! Form::label('nom_emp', 'NOMBRE DEL EQUIPO:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0 px-0 px-sm-2']) !!}
                     <div class="col-12 col-md-8 px-0 px-sm-2">
                        <p class="mb-2" id="lnom_equipo"></p>
                     </div>
                     @role('ADMINISTRADOR')
                     {!! Form::label('usuario', 'USUARIO:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0 px-0 px-sm-2']) !!}
                     <div class="col-12 col-md-8 px-0 px-sm-2">
                        <p class="mb-2 text-justify" id="lusuario"></p>
                     </div>
                     @endrole
                     {!! Form::label('cobien', 'CÓDIGO DEL BIEN:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0 px-0 px-sm-2']) !!}
                     <div class="col-12 col-md-8 px-0 px-sm-2">
                        <p class="mb-2" id="lcodbien"></p>
                     </div>
                     {!! Form::label('bien', 'NOMBRE DEL BIEN:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0 px-0 px-sm-2']) !!}
                     <div class="col-12 col-md-8 px-0 px-sm-2">
                        <p class="mb-2" id="lnom_bien"></p>
                     </div>
                     <div class="card border-secondary mx-sm-2">
                        <div class="card-header text-center bg-gris">
                           BIENES - BASE DE DATOS
                        </div>
                        <div class="card-body">
                           <div class="row">
                              {!! Form::label('local', 'LOCAL:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                              <div class="col-12 col-md-8 px-sm-2">
                                 <p class="mb-2" id="llocal_db"></p>
                              </div>
                              {!! Form::label('area', 'AREA:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                              <div class="col-12 col-md-8 px-sm-2">
                                 <p class="mb-2" id="larea_db"></p>
                              </div>
                              {!! Form::label('oficina', 'OFICINA:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                              <div class="col-12 col-md-8 px-sm-2">
                                 <p class="mb-2" id="loficina_db"></p>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     <div class="card border-secondary mx-sm-2">
                        <div class="card-header text-center bg-gris">
                           BIENES - LUGAR FÍSICO
                        </div>
                        <div class="card-body">
                           <div class="row">
                              {!! Form::label('local', 'LOCAL:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                              <div class="col-12 col-md-8 px-sm-2">
                                 <p class="mb-2" id="llocal_enc"></p>
                              </div>
                              {!! Form::label('area', 'AREA:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                              <div class="col-12 col-md-8 px-sm-2">
                                 <p class="mb-2" id="larea_enc"></p>
                              </div>
                              {!! Form::label('oficina', 'OFICINA:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0']) !!}
                              <div class="col-12 col-md-8 px-sm-2">
                                 <p class="mb-2" id="loficina_enc"></p>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0 px-0 px-sm-2']) !!}
                     <div class="col-12 col-md-8 px-0 px-sm-2">
                        <p class="mb-2" id="lestado"></p>
                     </div>
                     {!! Form::label('observacion', 'OBSERVACIÓN:', ['class' => 'col-12 col-md-4 font-weight-bold mb-0 px-0 px-sm-2']) !!}
                     <div class="col-12 col-md-8 px-0 px-sm-2">
                        <p class="mb-2 text-justify" id="lobservacion"></p>
                     </div>
                     
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{-- *********** /AGREGAR - MODAL ************** --}}
   {{-- ************* CRUZAR - MODAL **************** --}}
   <div class="modal fade font-modal" id="cruceModal" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
               <h5 class="modal-title font-modal text-white">Cruzar Bien</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <p class="text-center mb-0">Deseas cruzar este bien</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
               {!! Form::button('Si, Cruzar', ['class'=>'btn btn-danger btn-sm mr-1', 'type'=>'button', 'name' => 'cruce_button', 'id' => 'cruce_button']) !!}
               {!! Form::button('No, Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
            </div>
         </div>
      </div>
   </div>
   {{-- ************* /DELETE- MODAL **************** --}}
</div>
@endsection
@section('script')
<script src="{{ asset('scripts/script_cruces.js') }}"></script>
@endsection