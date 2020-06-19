@extends('main')

@section('titulo')
   Catálogo
@endsection

@section('contenido')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fad fa-book mr-1"></i>Catálogo</li>
</ol>

<div class="row mt-3">

   
   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">
            <table id="tabla_catalogo" class="table table-sm table-bordered table-hover text-nowrap w-100">
               <thead class="thead-danger">
                  <tr>
                     <td colspan="1" width="5%"></td>
                     <td colspan="1" width="15%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna1"></td>
                     <td colspan="1" width="80%"><input class="form-control form-control-sm form-control-xs" id="buscar_columna2"></td>
                  </tr>
                  <tr class="text-center font-weight">
                     <th width="5%">Nº</th>
                     <th width="15%">CÓDIGO</th>
                     <th width="80%">DESCRIPCIÓN</th>
                  </tr>
               </thead>
            <tbody class=""></tbody>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}
</div> <!-- end row -->

@endsection


@section('script')
<script src="{{ asset('scripts/script_catalogo.js') }}"></script>
@endsection