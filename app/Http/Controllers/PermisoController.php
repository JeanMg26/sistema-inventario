<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermisoController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:PERMISO-LISTAR|PERMISO-CREAR|PERMISO-EDITAR|PERMISO-ELIMINAR', ['only' => ['index', 'store']]);
      $this->middleware('permission:PERMISO-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:PERMISO-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:PERMISO-ELIMINAR', ['only' => ['destroy']]);
   }

   public function datatables()
   {
      $permiso = DB::table('permissions')
         ->select('id', 'module', DB::raw('SUBSTRING_INDEX(name,"-",-1) as nombre'), 'status')
         ->get();

      return DataTables::of($permiso)
         ->addColumn('acciones', function ($permiso) {
            '<div>';
            if (Auth::user()->can('PERMISO-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $permiso->id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('PERMISO-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion edit mr-1" id="' . $permiso->id . '">
                  <span class="far fa-edit fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('PERMISO-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $permiso->id . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($permiso) {
            if (Auth::user()->can('PERMISO-EDITAR')) {
               if ($permiso->status == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $permiso->id . '" id="permiso' . $permiso->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($permiso->status == '0') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $permiso->id . '" id="permiso' . $permiso->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
                  </div>';
               }
            } else {
               if ($permiso->status == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($permiso->status == '0') {
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

      return view('permisos.index');
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

      // dd($request->nom_permiso_hidden);

      $rules = [

         'mod_permiso'        => 'required|max:40',
         'nom_permiso_hidden' => 'required|max:40|unique:permissions,name',
         'est_permiso'        => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $permiso         = new Permission;
      $permiso->module = strtoupper($request->mod_permiso);
      $permiso->name   = strtoupper($request->nom_permiso_hidden);
      $permiso->status = $request->est_permiso;
      $permiso->save();
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
         $permiso = Permission::findOrFail($id);
         return response()->json(['permiso' => $permiso]);
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
         $permiso = Permission::findOrFail($id);
         return response()->json(['permiso' => $permiso]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Permission $permission)
   {
      $rules = [
         'mod_permiso'        => 'required|max:40',
         'nom_permiso_hidden' => 'required|max:40|unique:permissions,name,' . $request->permiso_id,
         'est_permiso'        => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $permiso         = Permission::findOrFail($request->permiso_id);
      $permiso->module = strtoupper($request->mod_permiso);
      $permiso->name   = strtoupper($request->nom_permiso_hidden);
      $permiso->status = $request->est_permiso;
      $permiso->save();
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
      $permiso = Permission::findOrFail($id);
      $permiso->delete();
   }

   public function cambiarEstadoPermiso(Request $request)
   {
      $permiso         = Permission::find($request->permiso_id);
      $permiso->name   = $permiso->name;
      $permiso->module = $permiso->module;
      $permiso->status = $request->estado;
      $permiso->save();
      return response()->json(['success' => 'Estado actualizado correctamente.']);

   }

}
