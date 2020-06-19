<div class="form-group row d-flex justify-content-end">
	<div class="col-12 text-center text-lg-right">
		{!! Form::button('<i class="fas fa-lock-open-alt mr-2"></i>ABIERTO', ['class'=>'btn btn-success px-5', 'type' => 'button', 'id' => 'boton_estado', 'value' => 'ABIERTO', 'name' => 'boton_estado']) !!}
		{!! Form::hidden('btn_estado', '0', ['id' => 'recibir_estado']) !!}
	</div>
</div>

<div class="form-group row mb-0">
	<div class="col-12 col-md-6 col-lg-6 mt-2 px-md-2{{ $errors->has('nom_equipo') ? ' has-error-select2' : ''}}">
		{!! Html::decode(Form::label('equipo', 'Nombre de Equipo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
		{!! Form::select('nom_equipo', ['' => 'SELECCIONAR...'] + $equipo, null, ['class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'autofocus', 'id' => 'nom_equipo']) !!}
		@include('coordinaciones.alertas.nom_equipo-request')
		
		{{-- ************* NOMBRE DE LOS EMPLEADOS ************* --}}
		{!! Form::text('nom_empleado', null, ['class' => 'form-control form-control-sm mt-3 d-none', 'id' => 'empleado1', 'readonly']) !!}
		{!! Form::text('nom_empleado', null, ['class' => 'form-control form-control-sm mt-3 d-none', 'id' => 'empleado2', 'readonly']) !!}
	</div>

	<div class="col-12 col-md-6 col-lg-6 mt-2 d-flex justify-content-center">
		<img class="img-fluid d-none mr-3" width="120" id="imagen_emp1">
		<img class="img-fluid d-none" width="120" id="imagen_emp2">
	</div>

	<div class="col-12">
		<hr class="mt-4">
	</div>


	{{-- *********************** UBICACIONES *********************** --}}
	<div class="col-12 col-md-6 col-lg-6 mt-2 px-md-2">
		<div class="card mb-3 border-gris">
			<div class="card-header font-weight-bold bg-gris" data-toggle="collapse" data-target="#ubicaciones">Ubicación
				<a class="float-right" data-toggle="collapse" data-target="#ubicaciones" class="collapsed">
					<em class="fa fa-plus"></em>
				</a>
			</div>
			<div class="collapse show" id="ubicaciones" style="">
				<div class="card-body row">
					<div class="col-12">
						<div class="form-group row">
							{!! Form::label('local', 'Local: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-3 col-xl-2']) !!}
							<div class="col-12 col-lg-9 col-xl-10 pl-lg-0{{ $errors->has('local') ? ' has-error-select2' : ''}}">
								{!! Form::select('local', ['' => 'SELECCIONAR...'] + $local , null, ['class' => 'form-control form-control-sm', 'id' => 'local']) !!}
								@include('coordinaciones.alertas.local-request')								
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('area', 'Área: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-3 col-xl-2']) !!}
							<div class="col-12 col-lg-9 col-xl-10 pl-lg-0{{ $errors->has('area') ? ' has-error-select2' : ''}}">
								{!! Form::select('area', [] , null, ['class' => 'form-control form-control-sm', 'id' => 'area']) !!}
								@include('coordinaciones.alertas.area-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('oficina', 'Oficina: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-3 col-xl-2']) !!}
							<div class="col-12 col-lg-9 col-xl-10 pl-lg-0{{ $errors->has('oficina') ? ' has-error-select2' : ''}}">
								{!! Form::select('oficina', [] , null, ['class' => 'form-control form-control-sm', 'id' => 'oficina']) !!}
								@include('coordinaciones.alertas.oficina-request')
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- *********************** ENTREGA DE FOLIOS *********************** --}}
	<div class="col-12 col-md-6 col-lg-6 mt-2 px-md-2">
		<div class="card mb-3 border-success">
			<div class="card-header text-white font-weight-bold bg-success" data-toggle="collapse" data-target="#entrega">Entrega de Folios
				<a class="float-right" data-toggle="collapse" data-target="#entrega" class="collapsed">
					<em class="fa fa-plus"></em>
				</a>
			</div>
			<div class="collapse show" id="entrega" style="">
				<div class="card-body row">
					<div class="col-12">
						<div class="form-group row">
							{!! Form::label('hoja_ent', 'Hojas de Trabajo: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('hoja_ent') ? ' has-error' : ''}}">
									{!! Form::text('hoja_ent', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'hoja_ent', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="fal fa-file"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.hoja_ent-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('sticker', 'Stickers: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('sticker_ent') ? ' has-error' : ''}}">
									{!! Form::text('sticker_ent', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'sticker_ent', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="fal fa-sticky-note"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.sticker_ent-request')		
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('fecha', 'Fecha: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('fec_ent') ? ' has-error' : ''}}">
									{!! Form::text('fec_ent', null, ['class' => 'form-control form-control-sm datepicker' , 'id' => 'fec_ent', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="fal fa-calendar-alt"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.fec_ent-request')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- ******************* LINEA SEPARADORA ******************* --}}
	<div class="col-12">
		<hr class="mt-4">
	</div>
	{{-- *********************** RETORNO DE FOLIOS *********************** --}}
	<div class="col-12 col-md-6 col-lg-6 mt-2 px-md-2">
		<div class="card mb-3 border-danger">
			<div class="card-header text-white font-weight-bold bg-danger" data-toggle="collapse" data-target="#retorno">Retorno de Folios
				<a class="float-right collapsed" data-toggle="collapse" data-target="#retorno" class="collapsed">
					<em class="fa fa-plus"></em>
				</a>
			</div>
			<div class="collapse" id="retorno" style="">
				<div class="card-body row">
					<div class="col-12">
						<div class="form-group row">
							{!! Form::label('hojas', 'Hojas de Trabajo: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('hoja_ret') ? ' has-error' : ''}}">
									{!! Form::text('hoja_ret', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'hoja_ret', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="fal fa-file"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.hoja_ret-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('sticker', 'Stickers: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('sticker_ret') ? ' has-error' : ''}}">
									{!! Form::text('sticker_ret', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'sticker_ret', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="fal fa-sticky-note"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.sticker_ret-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('hojas', 'Hojas de Adicionales: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('adic_ret') ? ' has-error' : ''}}">
									{!! Form::text('adic_ret', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'adic_ret', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="fad fa-file"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.adic_ret-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('fecha', 'Fecha: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('fec_ret') ? ' has-error' : ''}}">
									{!! Form::text('fec_ret', null, ['class' => 'form-control form-control-sm datepicker' , 'id' => 'fec_ret', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="fal fa-calendar-alt"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.fec_ret-request')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- *********************** CONTROL FINAL *********************** --}}
	<div class="col-12 col-md-6 col-lg-6 mt-2 px-md-2">
		<div class="card mb-3 border-info">
			<div class="card-header font-weight-bold text-white bg-info" data-toggle="collapse" data-target="#final">Control Final
				<a class="float-right collapsed" data-toggle="collapse" data-target="#final" class="collapsed">
					<em class="fa fa-plus"></em>
				</a>
			</div>
			<div class="collapse" id="final" style="">
				<div class="card-body row">
					<div class="col-12">
						<div class="form-group row">
							{!! Form::label('bienes', 'Bienes Ubicados: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('bienes_ubi') ? ' has-error' : ''}}">
									{!! Form::text('bienes_ubi', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'bienes_ubi', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="far fa-map-marker-check"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.bienes_ubi-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('bienes', 'Bienes No Ubicados: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('bienes_noubi') ? ' has-error' : ''}}">
									{!! Form::text('bienes_noubi', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'bienes_noubi', 'autocomplete' => 'off','maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="far fa-map-marker-times"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.bienes_noubi-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('bienes', 'Bienes Adicionales: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group{{ $errors->has('bienes_adic') ? ' has-error' : ''}}">
									{!! Form::text('bienes_adic', null, ['class' => 'form-control form-control-sm numerico' , 'id' => 'bienes_adic', 'autocomplete' => 'off', 'maxlength' => '3']) !!}
									<div class="input-group-append">
										<span class="input-group-text"><i class="far fa-map-marker-plus"></i>
										</span>
									</div>
								</div>
								@include('coordinaciones.alertas.bienes_adic-request')
							</div>
						</div>
						<div class="form-group row">
							{!! Form::label('observacion', 'Observaciones: ', ['class' => 'font-weight-bold col-form-label col-12 col-lg-5']) !!}
							<div class="col-12 col-lg-7 pl-lg-0">
								<div class="input-group">
									{!! Form::textarea('observacion', null, ['class' => 'form-control form-control-sm alfanumerico' , 'id' => 'observacion', 'autocomplete' => 'off', 'rows' => '3', 'style' => 'resize:none']) !!}
								</div>
								@include('coordinaciones.alertas.observacion-request')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>