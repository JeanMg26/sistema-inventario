<?php

namespace App\Http\Controllers;

use App\Area;
use App\Local;
use App\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class OficinaController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:OFICINA-LISTAR|OFICINA-CREAR|OFICINA-EDITAR|OFICINA-ELIMINAR', ['only' => ['index', 'store']]);
      $this->middleware('permission:OFICINA-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:OFICINA-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:OFICINA-ELIMINAR', ['only' => ['destroy']]);
   }

   public function areas(Request $request)
   {
      if (request()->ajax()) {
         $local_id = Input::get('local_id');
         $area     = Area::where([
            ['locales_id', '=', $local_id],
            ['deleted_at', null],
            ['estado', 1],
         ])
            ->get();
         return response()->json($area);
      }
   }

   public function datatables()
   {
      $oficina = DB::table('oficinas')
         ->join('areas', 'areas.id', '=', 'oficinas.areas_id')
         ->join('locales', 'locales.id', '=', 'oficinas.locales_id')
         ->select('oficinas.descripcion as oficinaD', 'oficinas.id as oficinaID', 'oficinas.codoficina as oficinaC', 'oficinas.estado as oficinaE', 'areas.descripcion as areaD', 'areas.codarea as areaC', 'locales.codlocal as localC', 'locales.descripcion as localD')
         ->where('oficinas.deleted_at', null);

      return DataTables::of($oficina)
         ->addColumn('acciones', function ($oficina) {
            '<div>';
            if (Auth::user()->can('OFICINA-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $oficina->oficinaID . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('OFICINA-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion edit mr-1" id="' . $oficina->oficinaID . '">
                  <span class="far fa-edit fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('OFICINA-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $oficina->oficinaID . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($oficina) {
            if (Auth::user()->can('OFICINA-EDITAR')) {
               if ($oficina->oficinaE == '1') {
                  return
                  '<div class="centrar">
                        <input data-id="' . $oficina->oficinaID . '" id="oficina' . $oficina->oficinaID . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                    </div>';
               }

               if ($oficina->oficinaE == '0') {
                  return
                  '<div class="centrar">
                        <input data-id="' . $oficina->oficinaID . '" id="oficina' . $oficina->oficinaID . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
                    </div>';
               }
            } else {
               if ($oficina->oficinaE == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($oficina->oficinaE == '0') {
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
      $localD = DB::table('locales')
         ->join('oficinas', 'oficinas.locales_id', '=', 'locales.id')
         ->select('oficinas.id as oficinaID', 'oficinas.descripcion as oficinaD', 'locales.id as localID', 'locales.codlocal as localC', 'locales.descripcion as localD')
         ->selectRaw("CONCAT(locales.codlocal,' - ', locales.descripcion) as concat_local")
         ->where([
            ['locales.deleted_at', null],
            ['oficinas.deleted_at', null],
         ])
         ->orderBy('localID', 'asc')
         ->pluck('concat_local', 'localD')
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

      return view('oficinas.index', ['local' => $local, 'localD' => $localD]);
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
         'local'       => 'required',
         'area'        => 'required',
         'cod_oficina' => 'required|max:15|unique:oficinas,codoficina,NULL,id,deleted_at,NULL,areas_id,' . $request->area,
         'des_oficina' => 'required|max:100|unique:oficinas,descripcion,NULL,id,deleted_at,NULL,areas_id,' . $request->area,
         'est_oficina' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $oficina              = new Oficina;
      $oficina->codoficina  = strtoupper($request->cod_oficina);
      $oficina->descripcion = strtoupper($request->des_oficina);
      $oficina->locales_id  = $request->local;
      $oficina->areas_id    = $request->area;
      $oficina->estado      = $request->est_oficina;
      $oficina->save();
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
         $oficina = Oficina::findOrFail($id);
         $area    = Area::findOrFail($oficina->areas_id);
         $local   = Local::findOrFail($area->locales_id);
         return response()->json(['oficina' => $oficina, 'local' => $local, 'area' => $area]);
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
         $oficina = Oficina::findOrFail($id);
         return response()->json(['oficina' => $oficina]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Oficina $oficina)
   {
      $rules = [
         'local'       => 'required',
         'area'        => 'required',
         'cod_oficina' => 'required|max:15|unique:oficinas,codoficina,' . $request->oficina_id . ',id,deleted_at,NULL,areas_id,' . $request->area,
         'des_oficina' => 'required|max:100|unique:oficinas,descripcion,' . $request->oficina_id . ',id,deleted_at,NULL,areas_id,' . $request->area,
         'est_oficina' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $oficina              = Oficina::findOrFail($request->oficina_id);
      $oficina->codoficina  = strtoupper($request->cod_oficina);
      $oficina->descripcion = strtoupper($request->des_oficina);
      $oficina->locales_id  = $request->local;
      $oficina->areas_id    = $request->area;
      $oficina->estado      = $request->est_oficina;
      $oficina->save();
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
      $oficina = Oficina::findOrFail($id);
      $oficina->delete();
   }

   public function cambiarEstadoFicina(Request $request)
   {
      $oficina              = Oficina::find($request->oficina_id);
      $oficina->codoficina  = $oficina->codoficina;
      $oficina->descripcion = $oficina->descripcion;
      $oficina->locales_id  = $oficina->locales_id;
      $oficina->areas_id    = $oficina->areas_id;
      $oficina->estado      = $request->estado;
      $oficina->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);

   }
}
