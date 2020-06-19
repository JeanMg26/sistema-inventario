@extends('main')

@section('titulo')
   Bienes
@endsection


@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
	</li>
	<li class="breadcrumb-item active" aria-current="page"><i class="fad fa-tv mr-1"></i>Bienes - Muebles</li>
</ol>

<div class="row mt-3">


	{{-- *********** TABLE CARD ************** --}}
	<div class="col-xl-12">
		<div class="card font-table">
			<div class="card-body">
				<table id="tabla_bienes" class="table table-sm table-bordered text-nowrap w-100">
					<thead class="thead-danger">
						<tr>
							<td></td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna1" style="width: 105px"></td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna2"> </td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna3"> </td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna4"> </td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna5"> </td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna6"> </td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna7"> </td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna8"> </td>
							<td><input class="form-control form-control-sm form-control-xs" id="buscar_columna9"> </td>
							<td class="d-none"></td>
							<td class="text-center"><button type="button" class="btn btn-secondary btn-sm" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button></td>
						</tr>

						<tr class="text-center font-weight">
							<th scope="col">Nº</th>
							<th scope="col">CODBIEN</th>
							<th scope="col">DESCRIPCION</th>
							<th scope="col">CODLOCAL</th>
							<th scope="col">CODAREA</th>
							<th scope="col">UBICACION</th>
							<th scope="col">MARCA</th>
							<th scope="col">MODELO</th>
							<th scope="col">COLOR</th>
							<th scope="col">SERIE</th>
							<th class="d-none" scope="col">CODCOMPLETO</th>
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

{{-- *********** AGREGAR CRUCE - MODAL ************** --}}
<div class="modal fade pr-0" id="modalCruce">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content border-danger">
			<div class="modal-header bg-danger">
				<h5 class="modal-title font-modal text-white font-weight-bold">Cruce de Bienes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-cruce">
				@csrf
				<div class="d-flex justify-content-center">
					<div class="col-12 col-md-12">
						<div class="modal-body col-12 pb-2 pt-4">

							<div class="form-group row">
								<div class="col-12 px-0 px-sm-2 text-center">
									<h6 class="mb-0 font-weight" id="bien"></h6>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-12 col-lg-6 px-0 px-sm-2">
									<div class="card border-secondary">
										<div class="card-header text-center bg-gris font-weight">
											BIENES - BASE DE DATOS
										</div>
										<div class="card-body">
											<div class="form-group row">
												{!! Html::decode(Form::label('codlocal', 'Local: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 col-lg-12 col-xl-2'])) !!}
												<div class="col-12 col-md-9 col-lg-12 col-xl-10 pl-xl-0">
													{!! Form::select('local_db', ['' => 'SELECCIONAR...'] + $local, null, ['class' => 'form-control form-control-sm','onpaste' => 'return false', 'id' => 'local_db']) !!}
													<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="local_db-error"></div>
												</div>
											</div>
											<div class="form-group row">
												{!! Html::decode(Form::label('codarea', 'Área: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 col-lg-12 col-xl-2'])) !!}
												<div class="col-12 col-md-9 col-lg-12 col-xl-10 pl-xl-0">
													{!! Form::select('area_db', [], null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'area_db']) !!}
													<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="area_db-error"></div>
												</div>
											</div>											
											<div class="form-group row mb-0">
												{!! Html::decode(Form::label('codoficina', 'Oficina: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 col-lg-12 col-xl-2'])) !!}
												<div class="col-12 col-md-9 col-lg-12 col-xl-10 pl-xl-0">
													{!! Form::select('oficina_db', [], null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'oficina_db']) !!}
													<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="oficina_db-error"></div>
												</div>
											</div>

										</div>
									</div>
								</div>


								<div class="col-12 col-lg-6 px-0 px-sm-2">
									<div class="card border-secondary">
										<div class="card-header text-center bg-gris font-weight">
											BIENES - LUGAR FÍSICO
										</div>
										<div class="card-body">
											<div class="form-group row">
												{!! Html::decode(Form::label('codlocal', 'Local: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 col-lg-12 col-xl-2'])) !!}
												<div class="col-12 col-md-9 col-lg-12 col-xl-10 pl-xl-0">
													{!! Form::select('local_enc', ['' => 'SELECCIONAR...'] + $local, null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'local_enc']) !!}
													<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="local_enc-error"></div>
												</div>
											</div>
											<div class="form-group row">
												{!! Html::decode(Form::label('codarea', 'Área: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 col-lg-12 col-xl-2'])) !!}
												<div class="col-12 col-md-9 col-lg-12 col-xl-10 pl-xl-0">
													{!! Form::select('area_enc', [], null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'area_enc']) !!}
													<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="area_enc-error"></div>
												</div>
											</div>
											<div class="form-group row mb-0">
												{!! Html::decode(Form::label('codoficina', 'Oficina: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 col-lg-12 col-xl-2'])) !!}
												<div class="col-12 col-md-9 col-lg-12 col-xl-10 pl-xl-0">
													{!! Form::select('oficina_enc', [], null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'oficina_enc']) !!}
													<div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="oficina_enc-error"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
								{!! Form::label('observacion', 'Observaciones: ', ['class' => 'font-weight-bold col-form-label col-12 col-md-3 px-0 px-sm-2']) !!}
								<div class="col-12 col-md-9 px-0 px-sm-2">
									<div class="input-group">
										{!! Form::textarea('observacion', null, ['class' => 'form-control form-control-sm' , 'id' => 'observacion', 'autocomplete' => 'off', 'rows' => '3', 'maxlength' => '150', 'style' => 'resize:none']) !!}
									</div>
								</div>
							</div>
							

						</div>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					{!! Form::hidden('action', 'Agregar', ['id' => 'action']) !!}
					{!! Form::hidden('bien_id', null, ['id' => 'bien_id']) !!}
					{!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-danger btn-sm mr-1', 'type'=>'submit']) !!}
					{!! Form::button('<i class="fas fa-times mr-2"></i>Calcelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
				</div>
			</form>
		</div>
	</div>
</div>
{{-- *********** /AGREGAR CRUCE - MODAL ************** --}}



{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade font-modal" id="showModal">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content border-danger">
			<div class="modal-header bg-danger">
				<h5 class="modal-title font-modal text-white text-center font-weight-bold">Detalles del bien</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body col-12">
				<div class="form-group row d-flex justify-content-center">

					<div class="col-12 col-md-11 row">
						{!! Form::label('codbien', 'COD. BIEN:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 mb-0">
							<p class="mb-2" id="lcodbien"></p>
						</div>
						{!! Form::label('descripcion', 'DESCRIPCIÓN:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="ldescripcion"></p>
						</div>

						{!! Form::label('usuario', 'USUARIO:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="lusuario"></p>
						</div>

						{!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="lestado"></p>
						</div>

						{!! Form::label('dimension', 'DIMENSIÓN:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="ldimension"></p>
						</div>

						{!! Form::label('fecha', 'FEC. REGISTRO:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="lfecha"></p>
						</div>

						{!! Form::label('sitbien', 'SIT. DEL BIEN:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="lsitbien"></p>
						</div>

						{!! Form::label('caracteristicas', 'CARACTERÍSTICAS', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="text-justify mb-2" id="lcaracteristicas"></p>
						</div>

						{!! Form::label('observacion', 'OBS. INTERNA', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="lobservaciones"></p>
						</div>

						<div class="col-12">
							<hr class="my-3">
						</div>

						{!! Form::label('equipo', 'EQUIPO:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="lnom_equipo"></p>
						</div>

						{!! Form::label('estado', 'ESTADO DEL FOLIO:', ['class' => 'col-12 col-md-3 font-weight-bold mb-0']) !!}
						<div class="col-12 col-md-9 ">
							<p class="mb-2" id="lest_folio"></p>
						</div>


					</div>

				</div>
			</div>

		</div>
	</div>
</div>
{{-- *********** /AGREGAR - MODAL ************** --}}


@endsection


@section('script')

<script src="{{ asset('scripts/script_bienes.js') }}"></script>

@endsection