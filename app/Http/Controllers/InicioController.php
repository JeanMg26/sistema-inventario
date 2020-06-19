<?php

namespace App\Http\Controllers;

use App\Charts\SupervisionLine;
use App\Empleado;
use App\Supervision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;
use Yajra\DataTables\DataTables;

class InicioController extends Controller
{

   public function datatables()
   {

      $cruce = DB::table('cruces')
         ->join('bienes', 'bienes.id', '=', 'cruces.bienes_id')
         ->join('equipos', 'equipos.id', '=', 'cruces.equipos_id')
         ->join('locales as localDB', 'localDB.id', '=', 'cruces.locales_db')
         ->join('locales as localENC', 'localENC.id', '=', 'cruces.locales_enc')
         ->join('areas as areaDB', 'areaDB.id', '=', 'cruces.areas_db')
         ->join('areas as areaENC', 'areaENC.id', '=', 'cruces.areas_enc')
         ->join('oficinas as oficinaDB', 'oficinaDB.id', '=', 'cruces.oficinas_db')
         ->join('oficinas as oficinaENC', 'oficinaENC.id', '=', 'cruces.oficinas_enc')
         ->select('cruces.estado as estadoCruce', 'cruces.id as cruceID', 'cruces.created_at as year', 'bienes.codbien as codbien', 'bienes.descripcion as bienes', 'equipos.nombre as equipo', 'localDB.codlocal as codlocalDB', 'localDB.descripcion as localDB', 'areaDB.codarea as codareaDB', 'areaDB.descripcion as areaDB', 'oficinaDB.codoficina as codoficinaDB', 'oficinaDB.descripcion as oficinaDB', 'localENC.codlocal as codlocalENC', 'localENC.descripcion as localENC', 'areaENC.codarea as codareaENC', 'areaENC.descripcion as areaENC', 'oficinaENC.codoficina as codoficinaENC', 'oficinaENC.descripcion as oficinaENC')
         ->where([
            ['cruces.deleted_at', null],
            ['equipos.estado', 1],
            ['localDB.estado', 1],
            ['localENC.estado', 1],
            ['areaDB.estado', 1],
            ['areaENC.estado', 1],
            ['oficinaDB.estado', 1],
            ['oficinaENC.estado', 1],
         ]);

      return DataTables::of($cruce)
         ->addIndexColumn()
         ->make(true);

   }

   public function chartLineAjax(Request $request)
   {

      $bienes_enc = DB::table('supervisiones')
         ->select(DB::raw('SUM(bienes_enc) as encontrados'), DB::raw('MONTH(fecha) as mes'))
         ->whereYear('fecha', '2020')
         ->where('deleted_at', null)
         ->groupBy('mes')
         ->pluck('encontrados');

      $bienes_adic = DB::table('supervisiones')
         ->select(DB::raw('SUM(bienes_adic) as adicionales'), DB::raw('MONTH(fecha) as mes'))
         ->whereYear('fecha', '2020')
         ->where('deleted_at', null)
         ->groupBy('mes')
         ->pluck('adicionales');

      $chart = new SupervisionLine;

      $chart->dataset('Bienes Encontrados', 'line', $bienes_enc)->options([
         'fill'        => 'true',
         'borderColor' => '#339AF0',
      ]);

      $chart->dataset('Bienes Adicionales', 'line', $bienes_adic)->options([
         'fill'        => 'true',
         'borderColor' => '#FFC078',
      ]);

      return $chart->api();
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      // Mostrar cumple del mes de los empleados
      $personal = Empleado::whereMonth('fec_nac', date('m'))
         ->where([
            ['empleados.deleted_at', null],
            ['empleados.estado', 1],
         ])
         ->get();

      // Mostrar en los cards informacion de los bienes
      $ubicados = Supervision::selectraw('SUM(bienes_enc) as bienes_ubicados')
         ->where('deleted_at', null)->pluck('bienes_ubicados')->first();
      $adicionales = Supervision::selectraw('SUM(bienes_adic) as bienes_adicionales')
         ->where('deleted_at', null)->pluck('bienes_adicionales')->first();
      $total     = '26670';
      $faltantes = $total - $ubicados;

      // Mostrar empleados en carouse
      $empleado = DB::table('empleados')
         ->join('users', 'users.empleados_id', '=', 'empleados.id')
         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
         ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
         ->join('profesiones', 'profesiones.id', '=', 'empleados.profesiones_id')
         ->select('empleados.*', 'profesiones.nombre as profesion', 'roles.name as cargo')
         ->where([
            ['empleados.deleted_at', null],
            ['empleados.estado', 1],
            ['roles.deleted_at', null],
            ['roles.status', 1],
         ])
         ->orderBy('empleados.nombres', 'asc')
         ->get();

      // Grafico Bienes Total - Mostrar labels segun bienes
      $meses = DB::table('supervisiones')
         ->select(DB::raw('SUM(bienes_enc) as encontrados'), DB::raw('SUM(bienes_adic) as adicionales'),
            DB::raw('(CASE
            WHEN MONTH(fecha) = "1" THEN "Enero"
            WHEN MONTH(fecha) = "2" THEN "Febrero"
            WHEN MONTH(fecha) = "3" THEN "Marzo"
            WHEN MONTH(fecha) = "4" THEN "Abril"
            WHEN MONTH(fecha) = "5" THEN "Mayo"
            WHEN MONTH(fecha) = "6" THEN "Junio"
            WHEN MONTH(fecha) = "7" THEN "Julio"
            WHEN MONTH(fecha) = "8" THEN "Agosto"
            WHEN MONTH(fecha) = "9" THEN "Septiembre"
            WHEN MONTH(fecha) = "10" THEN "Octubre"
            WHEN MONTH(fecha) = "11" THEN "Noviembre"
            WHEN MONTH(fecha) = "12" THEN "Diciembre"
            ELSE "Otro"
            END) as mes'))
         ->whereYear('fecha', '2020')
         ->where('deleted_at', null)
         ->groupBy('mes')
         ->orderBy(DB::raw('FIELD(mes, "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre")'))
         ->pluck('mes');

      $api = url('/chart-line-ajax');

      $chart = new SupervisionLine;
      $chart->labels($meses)->load($api);

      return view('inicio.index', ['ubicados' => $ubicados, 'adicionales' => $adicionales, 'total' => $total, 'personal' => $personal, 'faltantes' => $faltantes, 'chart' => $chart, 'empleado' => $empleado]);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
