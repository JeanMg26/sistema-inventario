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
	<li class="breadcrumb-item active" aria-current="page"><i class="fad fa-user-tie mr-1"></i>Personal</li>
</ol>

<div class="row mt-3">
   
   @can('PERSONAL-CREAR')
   <div class="col-12" align="right">
      <a href="{{ route('empleados.create') }}" class="btn btn-labeled btn-success btn-sm mb-3">
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

      <table id="tabla_empleados" class="table table-sm table-bordered table-hover text-nowrap w-100">
       <thead class="thead-danger">
         <tr>
           <td width="15%" colspan="2"></td>
           <td class="d-none" colspan="2"></td>
           <td width="20%"><input class="form-control form-control-sm form-control-xs filter" id="buscar_columna4" ></td>	
           <td width="12.5%"><input class="form-control form-control-sm form-control-xs filter" id="buscar_columna5"> </td>
           <td width="12.5%"><input class="form-control form-control-sm form-control-xs filter" id="buscar_columna6"> </td>
           <td width="8%"><input class="form-control form-control-sm form-control-xs filter" id="buscar_columna7"> </td>
           <td width="15%"><input class="form-control form-control-sm form-control-xs filter" id="buscar_columna8"> </td>
           <td width="17%" colspan="6" width="15%" class="text-center"><button type="button" class="btn btn-secondary btn-sm" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button></td>
        </tr>

        <tr class="text-center font-weight">
           <th width="5%">Nº</th>
           <th width="10%">IMAGEN</th>
           <th class="d-none">TIPO DE DOC.</th>
           <th class="d-none">NÚMERO DE DOC.</th>
           <th width="20%">NOMBRES Y APELLIDOS</th>
           <th width="12.5%">CARGO</th>
           <th width="12.5%">EQUIPO</th>
           <th width="8%">CELULAR</th>
           <th width="15%">CORREO</th>
           <th class="d-none">PROFESIÓN</th>
           <th class="d-none">GENERO</th>
           <th class="d-none">ESTADO</th>
           <th class="d-none">FECHA</th>
           <th width="7%">ESTADO</th>
           <th width="10%">ACCIONES</th>
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
       <h5 class="modal-title font-modal text-white text-center font-weight-bold">DETALLES DEL PERSONAL</h5>
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
        {!! Form::label('descripcion', 'TIPO DE DOCUMENTO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
        <div class="col-12 col-md-7 ">
          <p class="mb-2" id="ltipodoc_emp"></p>
       </div>

       {!! Form::label('nrodoc', 'NÚMERO DE DOCUMENTO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lnrodoc_emp"></p>
       </div>

       {!! Form::label('completos', 'NOMBRES Y APELLIDOS:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 mb-0">
          <p class="mb-2" id="lcomp_emp"></p>
       </div>

       {!! Form::label('cargo', 'CARGO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lcargo_emp"></p>
       </div>

       {!! Form::label('equipo', 'EQUIPO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lequipo_emp"></p>
       </div>

       {!! Form::label('profesion', 'PROFESIÓN:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lprof_emp"></p>
       </div>


       {!! Form::label('email', 'EMAIL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lemail_emp"></p>
       </div>

       {!! Form::label('genero', 'GENERO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lgen_emp"></p>
       </div>

       {!! Form::label('fec_nac', 'FEC. NACIMIENTO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lfec_nac"></p>
       </div>


       {!! Form::label('celular', 'NRO. CELULAR:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lcelu_emp"></p>
       </div>

       {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lest_emp"></p>
       </div>

       <div class="col-12">
          <hr class="mt-1">
       </div>

       {!! Form::label('nom_usu', 'NOMBRE DE USUARIO INICIAL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lnom_usu"></p>
       </div>

       {!! Form::label('pass_usu', 'CONTRASEÑA INICIAL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
       <div class="col-12 col-md-7 ">
          <p class="mb-2" id="lpass_usu"></p>
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

<script src="{{ asset('scripts/script_empleados.js') }}"></script>

@endsection