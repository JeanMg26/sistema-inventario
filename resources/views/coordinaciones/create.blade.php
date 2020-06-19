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
	<li class="breadcrumb-item"><a href="{{ route('coordinaciones.index') }}"><i class="fas fa-users-class mr-1"></i>Coordinaciones</a></li>
	<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-plus mr-1"></i>Agregar</li>
</ol>


<div class="card card-default">
	<div class="card-body d-flex justify-content-center row my-3">
		{!! Form::open(['route' => 'coordinaciones.store', 'method' => 'POST' , 'class' => 'col-12 col-xl-11 font-sm', 'id' => 'form-coordinacion']) !!}
		{!! Form::token() !!}

		@include('coordinaciones.form.cform') 

	</div>
	<div class="card-footer text-center">
		{!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-success btn-sm mr-1', 'type'=>'submit', 'name' => 'submit', 'value' => 'Aceptar']) !!}
		<a href="{{ route('coordinaciones.index') }}">
			{!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button']) !!}
		</a>
		{!! Form::close() !!}
	</div>
</div>

@endsection

@section('script')
<script src="{{ asset('scripts/script_coordinacionesC.js') }}"></script>
@endsection