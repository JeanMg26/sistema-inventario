@extends('main')

@section('titulo')
   Ubicaciones
@endsection

@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-location-circle mr-1"></i>Ubicaciones</li>
</ol>

<div class="row mt-3">

   
   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">
            <table id="tabla_ubicaciones" class="table table-sm table-bordered table-hover text-nowrap w-100">
               <thead class="thead-danger">
                  <tr>
                     <td colspan="1" width="5%"></td>
                     <td colspan="2" width="25%" class="text-center" id="parent"> {!! Form::select('local', ['' => ''] + $local, null, ['class' => 'form-control form-control-sm', 'id' => 'buscar_select1']) !!} </td>
                     <td colspan="1" width="5%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna3"></td>
                     <td colspan="1" width="20%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna4"></td>
                     <td colspan="1" width="5%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna5"></td>
                     <td colspan="1" width="25%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna6"></td>
                  </tr>
                  <tr class="text-center font-weight">
                     <th width="5%">Nº</th>
                     <th width="10%">CODLOCAL</th>
                     <th width="20%">LOCAL</th>
                     <th width="10%">CODAREA</th>
                     <th width="20%">AREA</th>
                     <th width="10%">CODOFICINA</th>
                     <th width="20%">OFICINA</th>
                  </tr>
               </thead>
            <tbody class="text-center"></tbody>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}
</div> <!-- end row -->

@endsection


@section('script')
<script src="{{ asset('scripts/script_ubicaciones.js') }}"></script>
@endsection