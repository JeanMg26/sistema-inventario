@extends('main')
@section('titulo')
Usuarios
@endsection
@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fad fa-user mr-1"></i>Usuarios</li>
</ol>
<div class="row mt-3">
   @can('USUARIO-CREAR')
   <div class="col-12" align="right">
      <a href="{{ route('usuarios.create') }}" class="btn btn-labeled btn-success btn-sm mb-3">
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
            <table id="tabla_usuarios" class="table table-sm table-hover table-bordered text-nowrap w-100">
               <thead class="thead-danger">
                  <tr>
                     <td colspan="2"></td>
                     <td><input colspan="1" class="form-control form-control-sm form-control-xs filter" id="buscar_columna2" ></td>
                     <td><input colspan="1" class="form-control form-control-sm form-control-xs filter" id="buscar_columna3" ></td>
                     @can('USUARIO-CREAR')
                     <td class="text-center" id="parent"> {!! Form::select('rol', ['' => ''] + $rol, null, ['class' => 'form-control form-control-sm font-normal js-example-basic-single-index', 'id' => 'buscar_select1']) !!} </td>
                     <td colspan="3" class="text-center"><button type="button" class="btn btn-secondary btn-sm" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button></td>
                     @endcan
                     
                  </tr>
                  <tr class="text-center font-weight">
                     <th width="5%%">Nº</th>
                     <th width="10%">IMAGEN</th>                   
                     <th width="20%">NOMBRE DE USUARIO</th>
                     <th width="20%%">EMAIL</th>
                     <th width="15%">ROL</th>
                     {{-- @can('USUARIO-EDITAR')   --}}
                     <th width="10%">ESTADO</th>
                     {{-- @endcan --}}
                     <th class="d-none" width="15%">AÑO</th>
                     <th width="20%">ACCIONES</th>
                  </tr>
               </thead>
               <tbody class="text-center"></tbody>
            </table>
         </div>
      </div>
   </div>
   {{-- *********** /TABLE CARD ************** --}}

   {{-- *********** MOSTRAR - MODAL ************** --}}
   <div class="modal fade pr-0" id="showModal"  role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
               <h5 class="modal-title font-modal text-white text-center font-weight-bold">Detalle del Registro</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body col-12">
               <div class="form-group row d-flex justify-content-center">
                  <div class="col-12 col-md-3 d-flex justify-content-center align-items-center">
                     <img class="img-fluid" width="150" id="limagen_emp">
                  </div>
                  <div class="col-12 col-md-9 row mt-3 mt-md-0">
                     {!! Form::label('nom_emp', 'NOMBRE DEL PERSONAL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-md-7 ">
                        <p class="mb-2" id="lnom_emp"></p>
                     </div>
                     {!! Form::label('equipo_emp', 'EQUIPO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-md-7 ">
                        <p class="mb-2" id="lequipo_emp"></p>
                     </div>
                     {!! Form::label('prof_emp', 'PROFESIÓN:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-md-7 ">
                        <p class="mb-2" id="lprof_emp"></p>
                     </div>
                     <div class="col-12">
                        <hr class="mt-1">
                     </div>
                     {!! Form::label('nom_usu', 'NOMBRE DE USUARIO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-md-7 ">
                        <p class="mb-2" id="lnom_usu"></p>
                     </div>
                     {!! Form::label('email_usu', 'EMAIL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-md-7 ">
                        <p class="mb-2" id="lemail_usu"></p>
                     </div>
                     {!! Form::label('rol_usu', 'ROL DEL USUARIO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-md-7 ">
                        <p class="mb-2" id="lrol_usu"></p>
                     </div>
                     {!! Form::label('descripcion', 'ESTADO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-md-7 ">
                        <p class="mb-2" id="lest_usu"></p>
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

   {{-- ************* RESETEAR PASSWORD **************** --}}
   <div class="modal fade" id="resetModal" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
               <h5 class="modal-title font-modal text-white">Restablecer Contraseña</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <p class="text-center mb-0">Deseas restablecer la contraseña?</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
               {!! Form::button('Si, Restablecer', ['class'=>'btn btn-danger btn-sm mr-1', 'type'=>'button', 'name' => 'reset_button', 'id' => 'reset_button']) !!}
               {!! Form::button('No, Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
            </div>
         </div>
      </div>
   </div>
   {{-- ************* /DELETE- MODAL **************** --}}








</div> <!-- end row -->
@endsection



@section('script')
<script src="{{ asset('scripts/script_usuarios.js') }}"></script>

@endsection