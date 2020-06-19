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
	<li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}"><i class="fad fa-user mr-1"></i>Usuarios</a></li>
	<li class="breadcrumb-item active" aria-current="page"><i class="far fa-edit mr-1"></i>Editar</li>
</ol>

<div class="card card-default">
	<div class="card-body d-flex justify-content-center row my-3">
		{!! Form::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'PUT', 'class' => 'col-12 col-md-11 col-lg-10 font-sm', 'files' => true, 'id' => 'form-usuario']) !!}
		{!! Form::token() !!}

		@include('usuarios.form.eform')

	</div>
	
	<div class="card-footer text-center">
		{!! Form::button('<i class="far fa-sync-alt mr-2"></i>Actualizar', ['class'=>'btn btn-info btn-sm mr-1', 'type'=>'submit', 'name' => 'submit', 'value' => 'Aceptar']) !!}
		<a href="{{ route('usuarios.index') }}">
			{!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button']) !!}
		</a>
		{!! Form::close() !!}
	</div>
</div>

@endsection

@section('script')
<script src="{{ asset('scripts/script_usuariosE.js') }}"></script>
@endsection