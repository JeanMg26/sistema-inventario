<?php

namespace App\Http\Controllers;

use App\Area;
use App\Bien;
use App\Cruce;
use App\Equipo;
use App\Local;
use App\Oficina;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CruceController extends Controller
{
   public function __construct()
   {
      $this->middleware('permission:CRUCE-LISTAR|CRUCE-CRUZAR', ['only' => ['index']]);
      $this->middleware('permission:CRUCE-CRUZAR', ['only' => ['cruzarBien']]);
   }

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
         ->where('cruces.deleted_at', null);

      return DataTables::of($cruce)
         ->addColumn('acciones', function ($cruce) {

            if ($cruce->estadoCruce == '0') {
               '<div>';
               if (Auth::user()->can('CRUCE-LISTAR')) {
                  $mostrar =
                  '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $cruce->cruceID . '">
                     <span class="fal fa-eye fa-xs"></span>
                  </button>';
               }
               if (Auth::user()->can('CRUCE-CRUZAR')) {
                  $mostrar .=
                  '<button class="btn btn-info btn-accion cruce mr-1" id="' . $cruce->cruceID . '">
                     <span class="far fa-check fa-xs"></span>
                  </button>';
               }
               '</div>';
               return $mostrar;
            }

            if ($cruce->estadoCruce == '1') {
               '<div>';
               if (Auth::user()->can('CRUCE-LISTAR')) {
                  $mostrar2 =
                  '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $cruce->cruceID . '">
                     <span class="fal fa-eye fa-xs"></span>
                  </button>';
               }
               '</div>';
               return $mostrar2;
            }

         })
         ->addIndexColumn()
         ->rawColumns(['acciones'])
         ->make(true);

   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $year = DB::table('cruces')
         ->select('cruces.*')
         ->selectRaw('DATE_FORMAT(cruces.created_at, "%Y") as year')
         ->selectRaw('CONCAT("INVENTARIO ", DATE_FORMAT(cruces.created_at, "%Y")) as nombre')
         ->where('cruces.deleted_at', null)
         ->orderBy('created_at', 'desc')
         ->pluck('nombre', 'year')
         ->toArray();

      $equipo = DB::table('equipos')
         ->join('cruces', 'cruces.equipos_id', '=', 'equipos.id')
         ->select('equipos.nombre as equipo', 'cruces.*')
         ->where('cruces.deleted_at', null)
         ->pluck('equipo', 'equipo')
         ->toArray();

      return view('cruces.index', ['equipo' => $equipo, 'year' => $year]);
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

   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      if (request()->ajax()) {

         $cruce       = Cruce::findOrFail($id);
         $usuario     = User::findOrFail($cruce->user_ing);
         $equipo      = Equipo::findOrFail($cruce->equipos_id);
         $bien        = Bien::findOrFail($cruce->bienes_id);
         $local_db    = Local::findOrFail($cruce->locales_db);
         $area_db     = Area::findOrFail($cruce->areas_db);
         $oficina_db  = Oficina::findOrFail($cruce->oficinas_db);
         $local_enc   = Local::findOrFail($cruce->locales_enc);
         $area_enc    = Area::findOrFail($cruce->areas_enc);
         $oficina_enc = Oficina::findOrFail($cruce->oficinas_enc);

         return response()->json(['cruce' => $cruce, 'equipo' => $equipo, 'bien' => $bien, 'local_db' => $local_db, 'area_db' => $area_db, 'oficina_db' => $oficina_db, 'local_enc' => $local_enc, 'area_enc' => $area_enc, 'oficina_enc' => $oficina_enc, 'usuario' => $usuario]);
      }
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

   public function cruzarBien(Request $request)
   {

      $cruce = Cruce::find($request->cruce_id);

      $cruce->bienes_id    = $cruce->bienes_id;
      $cruce->equipos_id   = $cruce->equipos_id;
      $cruce->locales_db   = $cruce->locales_db;
      $cruce->areas_db     = $cruce->areas_db;
      $cruce->oficinas_db  = $cruce->oficinas_db;
      $cruce->locales_enc  = $cruce->locales_enc;
      $cruce->areas_enc    = $cruce->areas_enc;
      $cruce->oficinas_enc = $cruce->oficinas_enc;
      $cruce->observacion  = $cruce->observacion;
      $cruce->estado       = $request->cruce_estado;
      $cruce->save();
      return response()->json(['success' => 'El bien se cruzó correctamente.']);

   }
}
