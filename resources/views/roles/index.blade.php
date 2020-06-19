@extends('main')

@section('titulo')
Roles
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active"><i class="fad fa-user-lock mr-1"></i>Roles</li>
</ol>


<div class="row mt-3">
   @can('ROL-CREAR')
   <div class="col-12" align="right">
      <a href="{{ route('roles.create') }}" type="button" class="btn btn-labeled btn-success btn-sm mb-3">
         <span class="btn-label"><i class="fal fa-file-plus mr-2"></i></span>Nuevo Registro
      </a>
   </div>
   @endcan


   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card">
         <div class="card-body">

            <table id="tabla_roles" class="table table-sm table-hover table-bordered color-table red-table text-nowrap w-100">
               <thead class="">
                  <tr>
                     <td colspan="1"></td>
                     <td colspan="1"><input class="form-control form-control-sm form-control-xs" id="buscar_columna1"></td>
                     <td colspan="2"></td>
                  </tr>

                  <tr class="text-center font-weight">
                     <th scope="col">Nº</th>
                     <th scope="col">DESCRIPCIÓN</th>
                     <th scope="col">ESTADO</th>
                     <th scope="col">ACCIONES</th>
                  </tr>
               </thead>
               <tbody class="text-center"></tbody>
            </table>

         </div>
      </div>
   </div>
   {{-- *********** /TABLE CARD ************** --}}

</div> <!-- end row -->

{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade rol pr-0" id="showModal"  role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white text-center font-weight-bold">DETALLES DEL ROL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body col-12">
            <div class="form-group row d-flex justify-content-center">

               <div class="col-12 col-md-11 row mt-3 mt-md-0">

                  {!! Form::label('nombre', 'Nombre del Rol:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 mb-0">
                     <p class="mb-2" id="lnom_rol"></p>
                  </div>

                  {!! Form::label('estado', 'Estado:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lest_rol"></p>
                  </div>

                  <div class="col-12 mt-2">
                     <div class="card card-border">
                        <div class="card-header bg-gris text-center font-weight-bold">Permisos</div>
                        <div class="card-body row" id="permisos"></div>
                     </div>
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

<script src="{{ asset('scripts/script_roles.js') }}"></script>

@endsection