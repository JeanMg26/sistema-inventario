<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Favicon icon -->
      {!!Html::favicon('img/logo-uns.png')!!}
      <title>@yield('titulo', 'Inventario') | Sistema de Inventario</title>
      <!-- This page CSS -->
      <!-- Normalize -->
      {!!Html::style('css/normalize.css')!!}
      <!-- Icons -->
      {!!Html::style('css/all.css')!!}
      <!-- Fonts -->
      {!!Html::style('fonts/font.css')!!}
      <!-- Custom Css -->
      {!!Html::style("assets/dist/css/styles.css")!!}
      {!!Html::style("css/bootstrap-select.css")!!}
      {!!Html::style("css/estilo.css")!!}
      <!-- Estilo Togle para DataTables -->
      {!!Html::style('css/bootstrap4-toggle.min.css')!!}
      <!-- DataTables -->
      {!!Html::style("css/datatables/dataTables.bootstrap4.min.css")!!}
      {!!Html::style("css/datatables/rowGroup.dataTables.min.css")!!}
      <!-- Select2 Input -->
      {!!Html::style('css/select2.css')!!}
      <!-- Alertas Toaster -->
      {!! Html::style('css/toastr.css') !!}
      {{-- {!!Html::style('css/sweetalert.css')!!} --}}
      <!-- Calendario Datepicker -->
      {!!Html::style('css/datepicker/bootstrap-datepicker3.css')!!}
      <!-- Rutas Ziggy para Laravel en Archivos JS -->
      @routes
      
   </head>
   <body class="skin-red fixed-layout pr-0">
      <div id="main-wrapper">
         @include("tema.header")
         @include("tema.aside")
         <div class="page-wrapper">
            <div class="container-fluid">
               @yield('contenido')
               @include('usuarios.perfil_usuario')
              
               
            </div>
         </div>
         @include("tema.footer")
      </div>
      <!-- ============================================================== -->
      <!-- All Jquery -->
      <!-- ============================================================== -->
      {!! Html::script("js/jquery-3.4.1.js") !!}
      <!-- Bootstrap popper Core JavaScript -->
      {!! Html::script("js/popper.min.js") !!}
      {!! Html::script("js/bootstrap.min.js") !!}
      {!! Html::script("js/bootstrap-select.js") !!}
      <!-- slimscrollbar scrollbar JavaScript -->
      {!! Html::script("assets/dist/js/perfect-scrollbar.jquery.min.js") !!}
      <!--Wave Effects -->
      {!! Html::script("assets/dist/js/waves.js") !!}
      <!--Menu sidebar -->
      {!! Html::script("assets/dist/js/sidebarmenu.js") !!}
      <!--Custom JavaScript -->
      {!! Html::script("assets/dist/js/custom.js") !!}
      <!-- DataTables -->
      {!! Html::script("js/datatables/jquery.dataTables.min.js") !!}
      {!! Html::script("js/datatables/dataTables.bootstrap4.min.js") !!}
      {!! Html::script('js/datatables/dataTables.rowGroup.min.js') !!}
      {!! Html::script('js/datatables/dataTables.suma.js') !!}
      {!! Html::script('js/datatables/dataTables.buttons.min.js') !!}
      {!! Html::script('js/datatables/buttons.bootstrap4.min.js') !!}
      {!! Html::script('js/datatables/buttons.colVis.min.js') !!}
      {!! Html::script('js/datatables/buttons.html5.min.js') !!}
      {!! Html::script('js/datatables/buttons.print.min.js') !!}
      {!! Html::script('js/datatables/jszip.min.js') !!}
      {!! Html::script('js/datatables/pdfmake.min.js') !!}
      {!! Html::script('js/datatables/vfs_fonts.js') !!}
      <!-- Estilo Togle para DataTables -->
      {!! Html::script('js/bootstrap4-toggle.min.js') !!}
      <!-- Formato para las fecha en DataTables -->
      {!! Html::script('js/select2.min.js')!!}
      {!!Html::script('js/select2-spanish.js')!!}
      <!-- Alertas Toaster -->
      {{-- {!!Html::script('js/sweetalert.js')!!} --}}
      {!!Html::script('js/sweetalert2.all.min.js')!!}
      {!! Html::script('js/toastr.min.js') !!}
      @toastr_render
      <!-- Validation Client-Side -->
      {!!Html::script('js/jquery.validate.min.js')!!}
      {!!Html::script('js/jquery.validate.file.js')!!}
      <!-- Formato para las fecha en DataTables -->
      {{ Html::script('js/moment.min.js') }}
      {{ Html::script('js/moment-with-locales.min.js') }}
      <!-- Calendario Datepicker -->
      {!!Html::script('js/datepicker/bootstrap-datepicker.js')!!}
      {!!Html::script('js/datepicker/bootstrap-datepicker.es.min.js')!!}
      <!-- Formatos para Input Date -->
      {!!Html::script('js/jquery.mask.min.js')!!}      
      <!-- Google Graficos -->
      {!!Html::script('js/google-charts-loader.js')!!}
      <!-- Script Usuario -->
      {!! Html::script('js/myscript.js') !!}
      {!! Html::script('js/validaciones.js') !!}
      {!! Html::script('js/actualizar_usuario.js') !!}
      <!-- Bootstrap Input-File -->
      {!!Html::script('js/bs-custom-file-input.js')!!}

      @yield('script')

   </body>
</html>