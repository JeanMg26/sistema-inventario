<?php

namespace App\Http\Controllers;

use App\Area;
use App\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AreaController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:AREA-LISTAR|AREA-CREAR|AREA-EDITAR|AREA-ELIMINAR', ['only' => ['index', 'store']]);
      $this->middleware('permission:AREA-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:AREA-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:AREA-ELIMINAR', ['only' => ['destroy']]);
   }

   public function datatables()
   {
      $area = DB::table('areas')
         ->join('locales', 'locales.id', '=', 'areas.locales_id')
         ->select('areas.descripcion as areaD', 'areas.id as area_id', 'areas.codarea as area_codarea', 'areas.estado as area_est', 'locales.codlocal as local_codlocal', 'locales.descripcion as local_des')
         ->where([
            ['locales.deleted_at', null],
            ['areas.deleted_at', null],
         ]);

      return DataTables::of($area)
         ->addColumn('acciones', function ($area) {
            '<div>';
            if (Auth::user()->can('AREA-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $area->area_id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('AREA-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion edit mr-1" id="' . $area->area_id . '">
                  <span class="far fa-edit fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('AREA-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $area->area_id . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($area) {
            if (Auth::user()->can('AREA-EDITAR')) {
               if ($area->area_est == '1') {
                  return
                  '<div class="centrar">
                        <input data-id="' . $area->area_id . '" id="area' . $area->area_id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                    </div>';
               }

               if ($area->area_est == '0') {
                  return
                  '<div class="centrar">
                        <input data-id="' . $area->area_id . '" id="area' . $area->area_id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
                    </div>';
               }
            } else {
               if ($area->area_est == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($area->area_est == '0') {
                  return
                     '<button type="button" class="btn btn-danger btn-sm btn-accion2"><i class="far fa-times"></i></button>';
               }
            }
         })
         ->addIndexColumn()
         ->rawColumns(['acciones', 'checkbox-estado'])
         ->make(true);
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $codlocal = DB::table('locales')
         ->join('areas', 'areas.locales_id', '=', 'locales.id')
         ->select('locales.codlocal as local_codlocal', 'locales.id as local_id')
         ->selectRaw('CONCAT(locales.codlocal," - ",locales.descripcion) as locales')
         ->where([
            ['locales.deleted_at', null],
            ['areas.deleted_at', null],
         ])
         ->orderBy('local_id', 'asc')
         ->pluck('locales', 'local_codlocal')
         ->toArray();

      $local = DB::table('locales')
         ->select('locales.*')
         ->selectRaw('CONCAT(locales.codlocal," - ",locales.descripcion) as locales')
         ->where([
            ['locales.deleted_at', null],
            ['locales.estado', 1],
         ])
         ->pluck('locales', 'id')
         ->toArray();

      return view('areas.index', ['codlocal' => $codlocal, 'local' => $local]);
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
         'local'    => 'required',
         'cod_area' => 'required|max:15|unique:areas,codarea,NULL,id,deleted_at,NULL,locales_id,' . $request->local,
         'des_area' => 'required|max:100|unique:areas,descripcion,NULL,id,deleted_at,NULL,locales_id,' . $request->local,
         'est_area' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $area              = new Area;
      $area->codarea     = strtoupper($request->cod_area);
      $area->descripcion = strtoupper($request->des_area);
      $area->locales_id  = $request->local;
      $area->estado      = $request->est_area;
      $area->save();
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
         $area  = Area::findOrFail($id);
         $local = Local::findOrFail($area->locales_id);
         return response()->json(['area' => $area, 'local' => $local]);
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
         $area = Area::findOrFail($id);
         return response()->json(['area' => $area]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Area $area)
   {
      $rules = [
         'local'    => 'required',
         'cod_area' => 'required|max:15|unique:areas,codarea,' . $request->area_id . ',id,deleted_at,NULL,locales_id,' . $request->local,
         'des_area' => 'required|max:100|unique:areas,descripcion,' . $request->area_id . ',id,deleted_at,NULL,locales_id,' . $request->local,
         'est_area' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $area              = Area::findOrFail($request->area_id);
      $area->codarea     = strtoupper($request->cod_area);
      $area->descripcion = strtoupper($request->des_area);
      $area->locales_id  = $request->local;
      $area->estado      = $request->est_area;
      $area->save();
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
      $area = Area::findOrFail($id);
      $area->delete();
   }

   public function cambiarEstadoArea(Request $request)
   {
      $area              = Area::find($request->area_id);
      $area->codarea     = $area->codarea;
      $area->descripcion = $area->descripcion;
      $area->locales_id  = $area->locales_id;
      $area->estado      = $request->estado;
      $area->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);

   }
}
