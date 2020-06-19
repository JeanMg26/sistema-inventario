@extends('main')

@section('titulo')
   Personal
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
	</li>
	<li class="breadcrumb-item"><a href="{{ route('empleados.index') }}"><i class="fad fa-user-tie mr-1"></i>Personal</a></li>
	<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-plus mr-1"></i>Agregar</li>
</ol>


<div class="card card-default">
	<div class="card-body d-flex justify-content-center row my-3">
		{!! Form::open(['route' => 'empleados.store', 'method' => 'POST' , 'class' => 'col-12 col-md-11 col-xl-10 font-sm', 'files' => true, 'id' => 'form-empleado']) !!}
		{!! Form::token() !!}

		@include('empleados.form.cform')
		@include('empleados.form.modal-user')


	</div>
	<div class="card-footer text-center">
		{!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-success btn-sm mr-1', 'id' => 'btn-usumodal']) !!}
		<a href="{{ route('empleados.index') }}">
			{!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button']) !!}
		</a>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('scripts/script_empleadosC.js') }}"></script>
@endsection