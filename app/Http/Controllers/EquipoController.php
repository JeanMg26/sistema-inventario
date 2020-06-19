<?php

namespace App\Http\Controllers;

use App\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EquipoController extends Controller
{
   public function __construct()
   {
      $this->middleware('permission:EQUIPO-LISTAR|EQUIPO-CREAR|EQUIPO-EDITAR|EQUIPO-ELIMINAR', ['only' => ['index', 'show']]);
      $this->middleware('permission:EQUIPO-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:EQUIPO-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:EQUIPO-ELIMINAR', ['only' => ['destroy']]);
   }

   public function datatables()
   {
      $equipo = Equipo::select('equipos.*');

      return DataTables::of($equipo)
         ->addColumn('opciones', function ($equipo) {

            '<div>';
            if (Auth::user()->can('EQUIPO-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $equipo->id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('EQUIPO-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion edit mr-1" id="' . $equipo->id . '">
                  <span class="far fa-edit fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('EQUIPO-EDITAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $equipo->id . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($equipo) {
            if (Auth::user()->can('EQUIPO-EDITAR')) {
               if ($equipo->estado == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $equipo->id . '" id="equipo' . $equipo->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                    </div>';
               }

               if ($equipo->estado == '0') {
                  return
                  '<div class="centrar">
                        <input data-id="' . $equipo->id . '" id="equipo' . $equipo->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
                    </div>';
               }
            } else {
               if ($equipo->estado == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($equipo->estado == '0') {
                  return
                     '<button type="button" class="btn btn-danger btn-sm btn-accion2"><i class="far fa-times"></i></button>';
               }
            }
         })
         ->addIndexColumn()
         ->rawColumns(['opciones', 'checkbox-estado'])
         ->make(true);
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('equipos.index');
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
         'nom_equi' => 'required|max:20|unique:equipos,nombre,NULL,id',
         'est_equi' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $data         = new Equipo;
      $data->nombre = strtoupper($request->nom_equi);
      $data->estado = $request->est_equi;
      $data->save();
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
         $equipo = Equipo::findOrFail($id);
         return response()->json(['equipo' => $equipo]);
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
         $equipo = Equipo::findOrFail($id);
         return response()->json(['result' => $equipo]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Equipo $equipo)
   {
      $rules = [
         'nom_equi' => 'required|max:20|unique:equipos,nombre,' . $request->equipo_id . ',id',
         'est_equi' => 'required',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $equipo         = Equipo::findOrFail($request->equipo_id);
      $equipo->nombre = strtoupper($request->nom_equi);
      $equipo->estado = $request->est_equi;
      $equipo->save();
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
      $quipo = Equipo::findOrFail($id);
      $quipo->delete();
   }

   public function cambiarEstadoEquipo(Request $request)
   {

      $equipo         = Equipo::find($request->equipo_id);
      $equipo->nombre = $equipo->nombre;
      $equipo->estado = $request->estado;
      $equipo->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);

   }
}
