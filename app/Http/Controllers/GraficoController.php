<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class GraficoController extends Controller
{

   public function graficoTotal(Request $request)
    {
        if ($request->input('year_total')) {

            $chart_total = DB::table('supervisiones')
                ->select(DB::raw('SUM(bienes_enc) as suma'), DB::raw('SUM(bienes_adic) as suma2'), DB::raw('MONTH(fecha) as mes'))
                ->whereYear('fecha', $request->input('year_total'))
                ->where('deleted_at', null)
                ->groupBy('mes')
                ->get();

            $output = array();

            foreach ($chart_total as $row) {

                if ($row->mes == '1') {
                    $mes = 'Enero';
                }

                if ($row->mes == '2') {
                    $mes = 'Febrero';
                }

                if ($row->mes == '3') {
                    $mes = 'Marzo';
                }

                if ($row->mes == '4') {
                    $mes = 'Abril';
                }

                if ($row->mes == '5') {
                    $mes = 'Mayo';
                }

                if ($row->mes == '6') {
                    $mes = 'Junio';
                }

                if ($row->mes == '7') {
                    $mes = 'Julio';
                }

                if ($row->mes == '8') {
                    $mes = 'Agosto';
                }

                if ($row->mes == '9') {
                    $mes = 'Septiembre';
                }

                if ($row->mes == '10') {
                    $mes = 'Octubre';
                }

                if ($row->mes == '11') {
                    $mes = 'Noviembre';
                }

                if ($row->mes == '12') {
                    $mes = 'Diciembre';
                }

                $output[] = array(

                    'mes'   => $mes,
                    'suma'  => $row->suma,
                    'suma2' => $row->suma2,
                );
            }

            return json_encode($output);

        }
    }


    public function graficoEquipos(Request $request)
    {
        if ($request->input('year')) {

            $chart_equipo = DB::table('supervisiones')
                ->join('equipos', 'equipos.id', '=', 'supervisiones.equipos_id')
                ->select(DB::raw('SUM(bienes_enc) as bienes_enc'), DB::raw('SUM(bienes_adic) as bienes_adic'), 'equipos.nombre as equipo')
                ->whereYear('fecha', $request->input('year'))
                ->where('deleted_at', null)
                ->groupBy('equipo')
                ->get();

            $output = array();

            foreach ($chart_equipo as $row) {

                $output[] = array(

                    'equipo'      => $row->equipo,
                    'bienes_enc'  => $row->bienes_enc,
                    'bienes_adic' => $row->bienes_adic,
                );
            }

            return json_encode($output);

        }
    }


    public function graficoEquipos1(Request $request)
    {
        if ($request->input('fecha_desde')) {

            $fecha_desde = date('Y-m-d', strtotime(Input::get('fecha_desde')));
            $fecha_hasta = date('Y-m-d', strtotime(Input::get('fecha_hasta')));

            $chart_equipo = DB::table('supervisiones')
                ->join('equipos', 'equipos.id', '=', 'supervisiones.equipos_id')
                ->select(DB::raw('SUM(bienes_enc) as bienes_enc'), DB::raw('SUM(bienes_adic) as bienes_adic'), 'equipos.nombre as equipo')
                ->whereRaw("date(supervisiones.fecha) >= '" . $fecha_desde . "' AND date(supervisiones.fecha) <= '" . $fecha_hasta . "'")
                ->where('deleted_at', null)
                ->groupBy('equipo')
                ->get();

            $output = array();

            foreach ($chart_equipo as $row) {

                $output[] = array(

                    'equipo'      => $row->equipo,
                    'bienes_enc'  => $row->bienes_enc,
                    'bienes_adic' => $row->bienes_adic,
                );
            }

            return json_encode($output);

        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year_total = DB::table('supervisiones')
            ->selectRaw('YEAR(fecha) as years')
            ->where('deleted_at', null)
            ->orderBy('fecha', 'desc')
            ->pluck('years', 'years')
            ->toArray();

        $year = DB::table('supervisiones')
            ->selectRaw('YEAR(fecha) as years')
            ->where('deleted_at', null)
            ->orderBy('fecha', 'desc')
            ->pluck('years', 'years')
            ->toArray();

        return view('graficos.index', ['year_total' => $year_total, 'year' => $year]);
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
