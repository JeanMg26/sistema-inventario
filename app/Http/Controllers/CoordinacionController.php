<?php

namespace App\Http\Controllers;

use App\Area;
use App\Coordinacion;
use App\Equipo;
use App\Http\Requests\CoordinacionCRequest;
use App\Http\Requests\CoordinacionURequest;
use App\Local;
use App\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\DataTables;

class CoordinacionController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:COORDINACION-LISTAR|COORDINACION-CREAR|COORDINACION-EDITAR|COORDINACION-ELIMINAR', ['only' => ['index', 'store']]);
      $this->middleware('permission:COORDINACION-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:COORDINACION-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:COORDINACION-ELIMINAR', ['only' => ['destroy']]);
   }

   // *********** DATOS PARA LOCAL - AREA **************
   public function coordinacion_areas()
   {
      // if ($request->ajax()) {

      $local_id = Input::get('localID');
      $area     = Area::where([
         ['locales_id', '=', $local_id],
         ['deleted_at', null],
         ['estado', 1],
      ])->get();
      return response()->json($area);
      // }
   }

   // *********** DATOS PARA AREA - OFICINA **************
   public function coordinacion_oficinas()
   {
      // if ($request->ajax()) {

      $area_id = Input::get('areaID');
      $oficina = Oficina::where([
         ['areas_id', '=', $area_id],
         ['deleted_at', null]
      ])->get();
      return response()->json($oficina);
      // }
   }

   public function equipo_empleado(Request $request)
   {
      if ($request->ajax()) {
         $equipo_id = Input::get('equipoid');
         $empleado  = DB::table('empleados')
            ->join('users', 'users.empleados_id', '=', 'empleados.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')

            ->select('empleados.*', 'empleados.rutaimagen as imagen', 'roles.name as rol')
            ->where([
               ['equipos_id', '=', $equipo_id],
               ['empleados.deleted_at', null],
               ['empleados.estado', 1],
            ])
            ->get();
         return response()->json($empleado);
      }

   }

   public function datatables()
   {
      $coordinacion = DB::table('coordinaciones')
         ->join('equipos', 'equipos.id', '=', 'coordinaciones.equipos_id')
         ->join('locales', 'locales.id', '=', 'coordinaciones.locales_id')
         ->join('areas', 'areas.id', '=', 'coordinaciones.areas_id')
         ->join('oficinas', 'oficinas.id', '=', 'coordinaciones.oficinas_id')
         ->select('coordinaciones.estado as est_coordinacion', 'coordinaciones.id as coordinacion_id', 'coordinaciones.cod_completo as cod_compC', 'coordinaciones.created_at as fechaC', 'coordinaciones.bienes_ubi as ubicados', 'coordinaciones.bienes_noubi as noubicados', 'coordinaciones.bienes_adic as adicionales', 'coordinaciones.observacion as observacion', 'equipos.nombre as equipo', 'locales.codlocal as codlocal', 'locales.descripcion as local', 'areas.codarea as codarea', 'areas.descripcion as area', 'oficinas.codoficina as codoficina', 'oficinas.descripcion as oficina', 'coordinaciones.hoja_ent as hoja_ent', 'coordinaciones.sticker_ent as sticker_ent', 'coordinaciones.fec_ent as fec_ent', 'coordinaciones.hoja_ret as hoja_ret', 'coordinaciones.sticker_ret as sticker_ret', 'coordinaciones.adic_ret as adic_ret', 'coordinaciones.fec_ret as fec_ret')
         ->where([
            ['coordinaciones.deleted_at', null],
            ['locales.deleted_at', null],
            ['areas.deleted_at', null],
            ['oficinas.deleted_at', null],
         ]);

      return DataTables::of($coordinacion)
         ->addColumn('acciones', function ($coordinacion) {
            '<div>';
            if (Auth::user()->can('COORDINACION-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $coordinacion->coordinacion_id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('COORDINACION-CREAR')) {
               $mostrar .=
               ' <a href="' . route("coordinaciones.edit", $coordinacion->coordinacion_id) . '" class="btn btn-info btn-accion mr-1">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('COORDINACION-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $coordinacion->coordinacion_id . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
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
      $equipo = DB::table('equipos')
         ->join('coordinaciones', 'coordinaciones.equipos_id', '=', 'equipos.id')
         ->select('coordinaciones.*', 'equipos.*')
         ->where([
            ['coordinaciones.deleted_at', null],
         ])
         ->orderBy('equipos.nombre', 'asc')
         ->pluck('equipos.nombre', 'equipos.nombre')
         ->toArray();

      $year = DB::table('coordinaciones')
         ->select('coordinaciones.*')
         ->selectRaw('DATE_FORMAT(coordinaciones.created_at, "%Y") as year')
         ->selectRaw('CONCAT("INVENTARIO ", DATE_FORMAT(coordinaciones.created_at, "%Y")) as nombre')
         ->where('coordinaciones.deleted_at', null)
         ->orderBy('created_at', 'desc')
         ->pluck('nombre', 'year')
         ->toArray();

      return view('coordinaciones.index', ['equipo' => $equipo, 'year' => $year]);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $local = DB::table('locales')
         ->select('locales.*')
         ->selectRaw('CONCAT(locales.codlocal," - ", locales.descripcion) as concat_local')
         ->where([
            ['locales.deleted_at', null],
            ['locales.estado', 1],
         ])
         ->orderBy('codlocal', 'asc')
         ->pluck('concat_local', 'id')
         ->toArray();

      $equipo = Equipo::where('estado', 1)->pluck('nombre', 'id')->toArray();
      return view('coordinaciones.create', ['equipo' => $equipo, 'local' => $local]);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(CoordinacionCRequest $request)
   {
      $coordinacion = new Coordinacion;

      $clocal   = Local::where('id', $request->local)->pluck('codlocal')->first();
      $carea    = Area::where('id', $request->area)->pluck('codarea')->first();
      $coficina = Oficina::where('id', $request->oficina)->pluck('codoficina')->first();

      $coordinacion->hoja_ent    = $request->hoja_ent;
      $coordinacion->sticker_ent = $request->sticker_ent;
      $coordinacion->fec_ent     = date('Y-m-d', strtotime($request->fec_ent));
      $coordinacion->hoja_ret    = $request->hoja_ret;
      $coordinacion->sticker_ret = $request->sticker_ret;
      $coordinacion->adic_ret    = $request->adic_ret;
      if ($request->fec_ret == '') {
         $coordinacion->fec_ret = null;
      } else {
         $coordinacion->fec_ret = date('Y-m-d', strtotime($request->fec_ret));
      }
      $coordinacion->bienes_ubi   = $request->bienes_ubi;
      $coordinacion->bienes_noubi = $request->bienes_noubi;
      $coordinacion->bienes_adic  = $request->bienes_adic;
      $coordinacion->observacion  = strtoupper($request->observacion);
      $coordinacion->equipos_id   = $request->nom_equipo;
      $coordinacion->locales_id   = $request->local;
      $coordinacion->areas_id     = $request->area;
      $coordinacion->oficinas_id  = $request->oficina;
      $coordinacion->cod_completo = $clocal . $carea . $coficina;
      $coordinacion->estado       = $request->btn_estado;
      $coordinacion->user_ing     = Auth::user()->id;
      $coordinacion->save();
      toastr()->success('Registro agregado correctamente.');
      return redirect('coordinaciones');
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

         $coordinacion = Coordinacion::findOrFail($id);
         $equipo       = Equipo::findOrFail($coordinacion->equipos_id);

         $empleado = DB::table('empleados')
            ->join('equipos', 'equipos.id', '=', 'empleados.equipos_id')
            ->join('users', 'users.empleados_id', '=', 'empleados.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('empleados.*', 'equipos.*', 'roles.name as rol')
            ->where('empleados.equipos_id', '=', $equipo->id)
            ->get();

         $local   = Local::findOrFail($coordinacion->locales_id);
         $area    = Area::findOrFail($coordinacion->areas_id);
         $oficina = Oficina::findOrFail($coordinacion->oficinas_id);

         return response()->json(['coordinacion' => $coordinacion, 'equipo' => $equipo, 'empleado' => $empleado, 'local' => $local, 'area' => $area, 'oficina' => $oficina]);
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
      $local = DB::table('locales')
         ->select('locales.*')
         ->selectRaw('CONCAT(locales.codlocal," - ", locales.descripcion) as concat_local')
         ->where([
            ['locales.deleted_at', null],
            ['locales.estado', 1],
         ])
         ->orderBy('codlocal', 'asc')
         ->pluck('concat_local', 'id')
         ->toArray();

      $area = DB::table('areas')
         ->select('areas.*')
         ->selectRaw('CONCAT(areas.codarea," - ", areas.descripcion) as concat_area')
         ->where([
            ['areas.deleted_at', null],
            ['areas.estado', 1],
         ])
         ->orderBy('codarea', 'asc')
         ->pluck('concat_area', 'id')
         ->toArray();

      $oficina = DB::table('oficinas')
         ->select('oficinas.*')
         ->selectRaw('CONCAT(oficinas.codoficina," - ", oficinas.descripcion) as concat_oficina')
         ->where([
            ['oficinas.deleted_at', null],
            ['oficinas.estado', 1],
         ])
         ->orderBy('codoficina', 'asc')
         ->pluck('concat_oficina', 'id')
         ->toArray();

      $equipo       = Equipo::where('estado', 1)->pluck('nombre', 'id')->toArray();
      $coordinacion = Coordinacion::findOrFail($id);

      return view('coordinaciones.edit', ['equipo' => $equipo, 'local' => $local, 'area' => $area, 'oficina' => $oficina, 'coordinacion' => $coordinacion]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(CoordinacionURequest $request, $id)
   {
      $coordinacion = Coordinacion::findOrFail($id);
      $clocal       = Local::where('id', $request->local)->pluck('codlocal')->first();
      $carea        = Area::where('id', $request->area)->pluck('codarea')->first();
      $coficina     = Oficina::where('id', $request->oficina)->pluck('codoficina')->first();

      $coordinacion->hoja_ent     = $request->hoja_ent;
      $coordinacion->sticker_ent  = $request->sticker_ent;
      $coordinacion->fec_ent      = date('Y-m-d', strtotime($request->fec_ent));
      $coordinacion->hoja_ret     = $request->hoja_ret;
      $coordinacion->sticker_ret  = $request->sticker_ret;
      if ($request->adic_ret == '' || $request->adic_ret == null) {
         $coordinacion->adic_ret = '0';
      }else{
         $coordinacion->adic_ret     = $request->adic_ret;
      }
      $coordinacion->fec_ret      = date('Y-m-d', strtotime($request->fec_ret));
      $coordinacion->bienes_ubi   = $request->bienes_ubi;
      $coordinacion->bienes_noubi = $request->bienes_noubi;
      if ($request->bienes_adic == '' || $request->bienes_adic == null) {
         $coordinacion->bienes_adic = '0';
      }else{
         $coordinacion->bienes_adic     = $request->bienes_adic;
      }
      $coordinacion->observacion  = strtoupper($request->observacion);
      $coordinacion->equipos_id   = $request->nom_equipo;
      $coordinacion->locales_id   = $request->local;
      $coordinacion->areas_id     = $request->area;
      $coordinacion->oficinas_id  = $request->oficina;
      $coordinacion->cod_completo = $clocal . $carea . $coficina;
      $coordinacion->estado       = $request->btn_estado;
      $coordinacion->user_ing     = Auth::user()->id;
      $coordinacion->save();
      toastr()->info('Registro actualizado correctamente.');
      return redirect('coordinaciones');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $coordinacion = Coordinacion::findOrFail($id);
      $coordinacion->delete();
   }
}
