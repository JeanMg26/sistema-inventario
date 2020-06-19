@extends('main')

@section('titulo')
	Permisos
@endsection

@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active"><i class="fad fa-user-shield mr-1"></i>Permisos</li>
</ol>

<div class="row mt-3">

   @can('PERMISO-CREAR')
   <div class="col-12" align="right">
      <button type="button" class="btn btn-labeled btn-success btn-sm mb-3" id="crear_registro">
         <span class="btn-label"><i class="fal fa-file-plus mr-2"></i></span>Nuevo Registro
      </button>
   </div>
   @endcan


   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card">
         <div class="card-body">

            <table id="tabla_permisos" class="table table-sm table-hover table-bordered text-nowrap w-100">
               <thead class="bg-danger font-weight text-white">
                  <tr class="text-center ">
                     <th scope="col">Nº</th>
                     <th scope="col">MÓDULO</th>
                     <th scope="col">ACCIÓN</th>
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

{{-- *********** AGREGAR/EDITAR - MODAL ************** --}}
<div class="modal fade font-modal pr-0" id="modalPermiso">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-danger">
			<div class="modal-header bg-danger">
				<h5 class="modal-title font-modal text-white">Nuevo Permiso</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-permiso">
				@csrf
				<div class="d-flex justify-content-center">
					<div class="col-12 col-sm-10 col-md-10">
						<div class="modal-body col-12 pb-2 pt-4">
							<div class="form-group row">
								{!! Html::decode(Form::label('modulo', 'Módulo: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
								<div class="col-12 col-md-9 px-0">
									{!! Form::text('mod_permiso', null, ['class' => 'form-control form-control-sm' , 'id' => 'mod_permiso', 'autocomplete' => 'off', 'placeholder' => 'USUARIO', 'old' => 'mod_permiso', 'autofocus',]) !!}
									<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="mod_permiso-error"></div>
								</div>
							</div>

							<div class="form-group row">
								{!! Html::decode(Form::label('nombre', 'Acción: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
								<div class="col-12 col-md-9 px-0">
									{!! Form::text('nom_permiso', null, ['class' => 'form-control form-control-sm' , 'id' => 'nom_permiso', 'autocomplete' => 'off', 'placeholder' => 'CREAR', 'old' => 'nom_permiso']) !!}
									{!! Form::hidden('nom_permiso_hidden', null, ['id' => 'nom_permiso_hidden']) !!}
									<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="nom_permiso-error"></div>
								</div>
							</div>

							<div class="form-group row">
								{!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0'])) !!}
								<div class="col-12 col-md-9 px-0">
									{!! Form::select('est_permiso', ['1' => 'HABILITADO', '0' => 'DESHABILITADO'], null, ['class' => 'form-control form-control-sm', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_permiso']) !!}
                           <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="est_permiso-error"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					{!! Form::hidden('action', 'Agregar', ['class' => 'action']) !!}
					{!! Form::hidden('permiso_id', null, ['id' => 'permiso_id']) !!}
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
               <h5 class="modal-title font-modal text-white text-center font-weight-bold">Detalle del Registro</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body col-12">
               <div class="form-group row d-flex justify-content-center">

                  <div class="col-12 col-md-9 row mt-3 mt-md-0">
                     {!! Form::label('mod_permiso', 'MÓDULO:', ['class' => 'col-12 col-sm-6 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-6 ">
                        <p class="mb-2" id="lmod_permiso"></p>
                     </div>

                     {!! Form::label('nom_permiso', 'NOMBRE DE LA ACCIÓN:', ['class' => 'col-12 col-sm-6 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-6 ">
                        <p class="mb-2" id="lnom_permiso"></p>
                     </div>
    
                     {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-sm-6 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-6 ">
                        <p class="mb-2" id="lest_permiso"></p>
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
				<h5 class="modal-title font-modal text-white">Eliminar Permiso</h5>
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

<script src="{{ asset('scripts/script_permisos.js') }}"></script>

@endsection
