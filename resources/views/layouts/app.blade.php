
<html lang="{{ app()->getLocale() }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Inventario | Sistema de Inventario</title>
      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}" defer></script>
      <!-- Icons -->
      {!!Html::style('css/all.css')!!}
      <!-- Styles -->
      {!!Html::style("css/bootstrap.css")!!}
      {!!Html::style("css/login.css")!!}
      {!!Html::style("css/icheck-bootstrap.css")!!}
      <!-- Fonts -->
      {!!Html::style('fonts/font.css')!!}

   </head>
   <body>
      <div id="app">
      <div class="mt-5 text-center">
         <img src="{{ url('img/logo_final_uns.png') }}" class="img-fluid mr-2" width="200px">
         <h1 class="mt-1 font-weight-bold">Control de Inventario</h1>
      </div>
      <main class="py-4">
         <div class="container">
            @yield('content')
         </div>
      </main>
   </div>
</body>
</html>