@extends('main')
@section('contenido')
<div class="card-group">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-12">
               <div class="d-flex no-block align-items-center">
                  <div>
                     <h3><i class="far fa-map-marker-check"></i></h3>
                     <p class="text-muted">BIENES UBICADOS</p>
                  </div>
                  <div class="ml-auto">
                     <h2 class="counter text-success">{{ $ubicados }}</h2>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="progress-light">
                  <div class="progress-bar bg-success" role="progressbar" style="width: {{ round(($ubicados*100)/$total) }}%; height: 6px;"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Column -->
   <!-- Column -->
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-12">
               <div class="d-flex no-block align-items-center">
                  <div>
                     <h3><i class="far fa-map-marker-minus"></i></h3>
                     <p class="text-muted">BIENES NO UBICADOS</p>
                  </div>
                  <div class="ml-auto">
                     <h2 class="counter text-danger">{{ $faltantes }}</h2>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="progress-light">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: {{ round(($faltantes*100)/$total) }}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Column -->
   <!-- Column -->
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-12">
               <div class="d-flex no-block align-items-center">
                  <div>
                     <h3><i class="far fa-map-marker-plus"></i></h3>
                     <p class="text-muted">BIENES ADICIONALES</p>
                  </div>
                  <div class="ml-auto">
                     <h2 class="counter text-info">{{ $adicionales }}</h2>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="progress-light">
                  <div class="progress-bar bg-info" role="progressbar" style="width: {{ round(($adicionales*100)/$total) }}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Column -->
   <!-- Column -->
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-12">
               <div class="d-flex no-block align-items-center">
                  <div>
                     <h3><i class="far fa-tv"></i></h3>
                     <p class="text-muted">BIENES TOTALES</p>
                  </div>
                  <div class="ml-auto">
                     <h2 class="counter text-primary">{{ $total }}</h2>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="progress-light">
                  <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <!-- Column -->
   <div class="col-lg-8 col-md-12">
      <div class="card" >
         <div class="card-body">
            <div class="d-flex mb-2 align-items-center no-block">
               <h5 class="card-title font-weight">INVENTARIO - 2020</h5>
            </div>
            <div class="row d-flex justify-content-center">
               <div class="col-11">
                  <div style="height: 305px !important">
                     {!! $chart->container() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Column -->
   <div class="col-lg-4 col-md-12">
      <div class="row">
         <!-- Column -->
         <div class="col-md-12">
            <div class="card bg-cyan text-white">
               <div class="card-body ">
                  <div class="text-center mb-3 mt-2"><i class="far fa-birthday-cake fa-3x"></i></div>
                  <h3 class="text-center font-weight">CUMPLEAÑOS DEL MES</h3>
                  <ul class="list-unstyled text-center mt-3">

                     @foreach ($personal as $persona)
                     <li><i class="far fa-check mr-1"></i> {{ $persona->nombres.' '.$persona->apellidos }} ({{ strtoupper(\Jenssegers\Date\Date::parse($persona->fec_nac)->format('j \\de F')) }} ) </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
         <!-- Column -->
         <div class="col-md-12">
            <div class="card bg-info text-white">
               <div class="card-body">
                  <div id="myCarouse2" class="carousel slide" data-ride="carousel">
                     <!-- Carousel items -->
                     <div class="carousel-inner">
                        @foreach ($empleado as $key => $personal)
                        <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                           <h4 class="cmin-height text-center font-weight">{{ $personal->nombres.' '.$personal->apellidos}}</h4>
                           <div class="d-flex no-block align-items-center">
                              <span>
                                 @if ($personal->rutaimagen == "")
                                 <img class="img-circle" width="50" src="{{ url('/img/user.jpg') }}">
                                 @else
                                 <img class="img-circle" width="50" src="/uploads/{{$personal->rutaimagen}}">
                                 @endif
                              </span>
                              <span class="ml-3 mt-2">
                                 <p class="text-white m-b-0 "><span class="font-weight">PROFESIÓN:</span>  {{ $personal->profesion }} </p>
                                 <p class="text-white mt-1 mb-0"><span class="font-weight">CARGO:</span> {{ $personal->cargo }}</p>

                                 @if ($personal->celular == '' || $personal->celular == null)
                                    <p class="text-white mt-1 mb-0"><span class="font-weight">CELULAR:</span> ---------------- </p>
                                 @else
                                    <p class="text-white mt-1 mb-0"><span class="font-weight">CELULAR:</span> {{ $personal->celular }}</p>
                                 @endif
                                 
                                 <p class="text-white mt-1 mb-0"><span class="font-weight">CUMPLEAÑOS:</span> {{ strtoupper(\Jenssegers\Date\Date::parse($personal->fec_nac)->format('j \\de F')) }}</p>
                              </span>
                           </div>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Column -->
      </div>
   </div>
</div>
<div class="row">
   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">
            <h4 class="font-weight">TABLA - CRUCE DE BIENES</h4>
            <table id="tabla_cruces" class="table table-sm table-bordered text-nowrap w-100">
               <thead class="thead-danger">
                  <tr class="text-center font-weight">
                     <th colspan="4"></th>
                     <th colspan="3" style="font-size: 13px !important; padding: 10px 10px !important;">BIENES - BASE DE DATOS</th>
                     <th colspan="3" style="font-size: 13px !important; padding: 10px 10px !important;">BIENES - LUGAR FÍSICO</th>
                  </tr>
                  <tr class="text-center font-weight">
                     <th scope="col">Nº</th>
                     <th scope="col">EQUIPO</th>
                     <th scope="col">CODBIEN</th>
                     <th scope="col">NOMBRE DEL BIEN</th>
                     <th scope="col">CODLOCAL</th>
                     <th scope="col">CODAREA</th>
                     <th scope="col">CODOFICINA</th>
                     <th scope="col">CODLOCAL</th>
                     <th scope="col">CODAREA</th>
                     <th scope="col">CODOFICINA</th>
                  </tr>
               </thead>
               <tbody class="text-center">
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

@endsection
@section('script')
<script src="{{ asset('scripts/script_inicio.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chart->script() !!}

@endsection