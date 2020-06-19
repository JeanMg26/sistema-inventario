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
   <li class="breadcrumb-item">
      <a href="{{ route('bienes.index') }}"><i class="fad fa-tv mr-1"></i></i>Bienes</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><i class="fal fa-file-excel mr-1"></i>Importar</li>
</ol>
<div class="card">
   <div class="card-body d-flex justify-content-center row my-3">
      {!! Form::open(['route' => 'bienes.import.excel', 'method' => 'POST' , 'class' => 'col-12 col-sm-11 col-md-9 col-lg-8 col-xl-6', 'id' => 'form-ImportarExcel', 'files' => true]) !!}
      {!! Form::token() !!}
      <div class="row">
         <div class="col-12 mb-3 px-0">
            <a href="{{ url('excel/formato-importar-bienes.xlsx') }}" style="float: right;" class="btn btn-success btn-sm" title="Modelo">
               <i class="fas fa-file-excel mr-2"></i>Descargar Modelo
            </a>
         </div>
         <div class="col-12 px-0">
            <div class="card border-success">
               <div class="card-header bg-transparent">Importar Registros
               </div>
               <div class="card-body">
                  <div class="col-12 mt-2" id="padre">
                     <div class="input-group p-0  ">
                        <div class="custom-file">
                           {!! Form::file('files', ['class' => 'custom-file-input', 'id' => 'files', 'accept' =>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']) !!}
                           {!! Form::label('files', 'Elegir archivo', ['class' => 'custom-file-label']) !!}
                        </div>
                     </div>
 
                     <div class="text-center font-mini mt-2">
                        {!! Html::decode(Form::label('aviso', 'Sólo archivos XLS XLSX')) !!}
                     </div>
 
                     <div class="form-group d-none" id="process">
                        <div class="progress mb-3">
                           <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                           </div>
                        </div>

                     </div>
                     
                     <div class="alert alert-success py-0 pl-2 mb-0 mt-2 d-none" id="files-success"></div>
                     <div class="alert alert-danger py-0 pl-2 mb-0 mt-2 d-none color-uns" id="files-error"></div>
                     <div id="form-errors"></div>
                  </div>
                  
                  
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card-footer text-center">
      {!! Form::button('<i class="far fa-broom mr-2"></i>Vaciar Tabla', ['class'=>'btn btn-danger btn-sm mr-1', 'id'=>'truncate_tabla']) !!}
      {!! Form::button('<i class="fas fa-upload mr-2"></i>Importar', ['class'=>'btn btn-info btn-sm mr-1 action_button', 'type'=>'submit']) !!}
      <a href="{{ route('bienes.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-secondary btn-sm mb-0 ml-1', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>
@endsection

@section('script')
<script src="{{ asset('scripts/script_bienesImport.js') }}"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
@endsection