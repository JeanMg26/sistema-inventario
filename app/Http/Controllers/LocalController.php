<?php

namespace App\Http\Controllers;

use App\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class LocalController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:LOCAL-LISTAR|LOCAL-CREAR|LOCAL-EDITAR|LOCAL-ELIMINAR', ['only' => ['index', 'store']]);
      $this->middleware('permission:LOCAL-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:LOCAL-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:LOCAL-ELIMINAR', ['only' => ['destroy']]);
   }

   public function datatables()
   {
      $local = Local::select('locales.*');

      return DataTables::of($local)
         ->addColumn('acciones', function ($local) {
            '<div>';
            if (Auth::user()->can('LOCAL-LISTAR')) {
               $mostrar = 
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $local->id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('LOCAL-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion edit mr-1" id="' . $local->id . '">
                  <span class="far fa-edit fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('LOCAL-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $local->id . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($local) {

            if (Auth::user()->can('USUARIO-EDITAR')) {
               if ($local->estado == '1') {
                  return
                  '<div class="centrar">
                     <input id="local' . $local->id . '" data-id="' . $local->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($local->estado == '0') {
                  return
                  '<div class="centrar">
                  <input id="local' . $local->id . '" data-id="' . $local->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
               </div>';
               }


            }else{
               if ($local->estado == '1') {
                  return
                  '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($local->estado == '0') {
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
      return view('locales.index');
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
         'cod_local' => 'required|max:15|unique:locales,codlocal,NULL,id,deleted_at,NULL',
         'des_local' => 'required|max:50|unique:locales,descripcion,NULL,id,deleted_at,NULL',
         'est_local' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $local              = new Local;
      $local->codlocal    = $request->cod_local;
      $local->descripcion = strtoupper($request->des_local);
      $local->estado      = $request->est_local;
      $local->save();
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
         $local = Local::findOrFail($id);
         return response()->json(['local' => $local]);
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
         $local = Local::findOrFail($id);
         return response()->json(['local' => $local]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Local $local)
   {
      $rules = [
         'cod_local' => 'required|max:15|unique:locales,codlocal,' . $request->local_id . ',id,deleted_at,NULL',
         'des_local' => 'required|max:50|unique:locales,descripcion,' . $request->local_id . ',id,deleted_at,NULL',
         'est_local' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $local              = Local::findOrFail($request->local_id);
      $local->codlocal    = $request->cod_local;
      $local->descripcion = strtoupper($request->des_local);
      $local->estado      = $request->est_local;
      $local->save();
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
      $local = Local::findOrFail($id);
      $local->delete();
   }

   public function cambiarEstadoLocal(Request $request)
   {
      $local              = Local::find($request->local_id);
      $local->codlocal    = $local->codlocal;
      $local->descripcion = $local->descripcion;
      $local->estado      = $request->estado;
      $local->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);
   }
}
