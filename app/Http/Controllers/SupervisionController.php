<?php

namespace App\Http\Controllers;

use App\Equipo;
use App\Supervision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SupervisionController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:SUPERVISION-LISTAR|SUPERVISION-CREAR|SUPERVISION-EDITAR|SUPERVISION-ELIMINAR', ['only' => ['index', 'store']]);
      $this->middleware('permission:SUPERVISION-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:SUPERVISION-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:SUPERVISION-ELIMINAR', ['only' => ['destroy']]);
   }

   public function datatables(Request $request)
   {
      $supervision = Supervision::query();

      if (!empty($request->fecha_desde)) {

         $fecha_desde = date('Y-m-d', strtotime(Input::get('fecha_desde')));
         $fecha_hasta = date('Y-m-d', strtotime(Input::get('fecha_hasta')));

         $supervision->
            whereRaw("date(supervisiones.fecha) >= '" . $fecha_desde . "' AND date(supervisiones.fecha) <= '" . $fecha_hasta . "'");
      }

      $super_final = $supervision->join('equipos', 'equipos.id', '=', 'supervisiones.equipos_id')
         ->select('supervisiones.*', 'equipos.nombre as equipo')
         ->where('supervisiones.deleted_at', null);

      return DataTables::of($super_final)
         ->addColumn('acciones', function ($supervision) {
            '<div>';
            if (Auth::user()->can('SUPERVISION-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $supervision->id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('SUPERVISION-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion edit mr-1" id="' . $supervision->id . '">
                  <span class="far fa-edit fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('SUPERVISION-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $supervision->id . '">
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
      $year = DB::table('supervisiones')
         ->select('supervisiones.*')
         ->selectRaw('DATE_FORMAT(supervisiones.fecha, "%Y") as year')
         ->selectRaw('CONCAT("INVENTARIO ", DATE_FORMAT(supervisiones.fecha, "%Y")) as nombre')
         ->where('supervisiones.deleted_at', null)
         ->orderBy('fecha', 'desc')
         ->pluck('nombre', 'year')
         ->toArray();

      $equipo = Equipo::where('estado', 1)->orderBy('nombre', 'asc')->pluck('nombre', 'id')->toArray();

      $equipoBuscar = DB::table('equipos')
         ->join('supervisiones', 'supervisiones.equipos_id', '=', 'equipos.id')
         ->select('equipos.id as equipoID', 'equipos.nombre as equipoN', 'supervisiones.*')
         ->where([
            ['supervisiones.deleted_at', null],
         ])
         ->orderBy('equipoN', 'asc')
         ->pluck('equipoN', 'equipoN')
         ->toArray();

      return view('supervisiones.index', ['equipo' => $equipo, 'equipoBuscar' => $equipoBuscar, 'year' => $year]);
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
      $rules = [
         'equipo'      => 'required',
         'bienes_enc'  => 'required|numeric|digits_between:1,4',
         'bienes_adic' => 'nullable|numeric|digits_between:1,4',
         'fecha'       => 'required|date_format:d-m-Y',
         'observacion' => 'nullable|max:200',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $super             = new Supervision;
      $super->equipos_id = $request->equipo;
      $super->bienes_enc = $request->bienes_enc;
      // Verificar si adic tiene o no bienes
      if ($request->bienes_adic == '' || $request->bienes_adic == null) {
         $super->bienes_adic = '0';
      } else {
         $super->bienes_adic = $request->bienes_adic;
      }
      $super->fecha       = date('Y-m-d', strtotime($request->fecha));
      $super->observacion = strtoupper($request->observacion);
      $super->user_ing    = Auth::user()->id;

      $super->save();

      return response()->json(['success' => 'Registro agregado correctamente.']);
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
         $super  = Supervision::findOrFail($id);
         $equipo = Equipo::findOrFail($super->equipos_id);
         return response()->json(['super' => $super, 'equipo' => $equipo]);
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
      if (request()->ajax()) {
         $super = Supervision::findOrFail($id);
         return response()->json(['super' => $super]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Supervision $supervision)
   {
      $rules = [
         'equipo'      => 'required',
         'bienes_enc'  => 'required|numeric|digits_between:1,4',
         'bienes_adic' => 'nullable|numeric|digits_between:1,4',
         'fecha'       => 'required|date_format:d-m-Y',
         'observacion' => 'nullable|max:200',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $super              = Supervision::findOrFail($request->supervision_id);
      $super->equipos_id  = $request->equipo;
      $super->bienes_enc  = $request->bienes_enc;
      // Verificar si adic tiene o no bienes
      if ($request->bienes_adic == '' || $request->bienes_adic == null) {
         $super->bienes_adic = '0';
      } else {
         $super->bienes_adic = $request->bienes_adic;
      }
      $super->fecha       = date('Y-m-d', strtotime($request->fecha));
      $super->observacion = strtoupper($request->observacion);
      $super->user_ing    = Auth::user()->id;
      $super->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $super = Supervision::findOrFail($id);
      $super->delete();
   }
}
