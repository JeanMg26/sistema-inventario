<?php

namespace App\Http\Controllers;

use App\Charts\UserLineChart;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

   public function chartLineAjax(Request $request)
   {
      $year  = $request->has('year') ? $request->year : date('Y');

      $bienes_enc = DB::table('supervisiones')
                ->select(DB::raw('SUM(bienes_enc) as encontrados'), DB::raw('MONTH(fecha) as mes'))
                ->whereYear('fecha', $year)
                ->where('deleted_at', null)
                ->groupBy('mes')
                ->pluck('encontrados');

      $bienes_adic = DB::table('supervisiones')
                ->select(DB::raw('SUM(bienes_adic) as adicionales'), DB::raw('MONTH(fecha) as mes'))
                ->whereYear('fecha', $year)
                ->where('deleted_at', null)
                ->groupBy('mes')
                ->pluck('adicionales');

      $chart = new UserLineChart;
      $chart2 = new UserLineChart;

      $chart->dataset('New User Register Chart', 'line', $bienes_enc)->options([
         'fill'        => 'true',
         'borderColor' => '#51C1C0',
      ]);

      $chart->dataset('New User Register Chart', 'line', $bienes_adic)->options([
         'fill'        => 'true',
         'borderColor' => '#51C1C0',
      ]);



      // $users = User::select(\DB::raw("COUNT(*) as count"))
      //    ->whereYear('created_at', $year)
      //    ->groupBy(\DB::raw("Month(created_at)"))
      //    ->pluck('count');

      // $chart = new UserLineChart;

      // $chart->dataset('New User Register Chart', 'line', $users)->options([
      //    'fill'        => 'true',
      //    'borderColor' => '#51C1C0',
      // ]);

      return $chart->api();
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

      $year  = request()->has('year') ? $request->year : date('Y');

      // $bienes_enc = DB::table('supervisiones')
      //           ->select(DB::raw('SUM(bienes_enc) as encontrados'), DB::raw('SUM(bienes_adic) as adicionales'), DB::raw('MONTH(fecha) as mes'))
      //           ->whereYear('fecha', $year)
      //           ->where('deleted_at', null)
      //           ->groupBy('mes')
      //           ->pluck('encontrados');

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
         ->whereYear('fecha', $year)
         ->where('deleted_at', null)
         ->groupBy('mes')
         ->orderBy(DB::raw('FIELD(mes, "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre")'))
         ->pluck('mes');




      // $meses = User::select(DB::raw("COUNT(*) as count"),
      //    DB::raw('(CASE
      //       WHEN MONTH(created_at) = "1" THEN "Enero"
      //       WHEN MONTH(created_at) = "2" THEN "Febrero"
      //       WHEN MONTH(created_at) = "3" THEN "Marzo"
      //       WHEN MONTH(created_at) = "4" THEN "Abril"
      //       WHEN MONTH(created_at) = "5" THEN "Mayo"
      //       WHEN MONTH(created_at) = "6" THEN "Junio"
      //       WHEN MONTH(created_at) = "7" THEN "Julio"
      //       WHEN MONTH(created_at) = "8" THEN "Agosto"
      //       WHEN MONTH(created_at) = "9" THEN "Septiembre"
      //       WHEN MONTH(created_at) = "10" THEN "Octubre"
      //       WHEN MONTH(created_at) = "11" THEN "Noviembre"
      //       WHEN MONTH(created_at) = "12" THEN "Diciembre"
      //       ELSE "Otro"
      //       END) as mes'))
      //    ->whereYear('created_at', $year)
      //    ->groupBy('mes')
      //    ->orderBy(DB::raw('FIELD(mes, "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre")'))
      //    ->pluck('mes');

      $api = url('/chart-line-ajax');

      $chart = new UserLineChart;
      $chart->labels($meses)->load($api);

      return view('chartLine', compact('chart'));
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
