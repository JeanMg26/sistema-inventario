<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Equipo;
use App\Http\Requests\EmpleadoCRequest;
use App\Http\Requests\EmpleadoURequest;
use App\Profesion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class EmpleadoController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:PERSONAL-LISTAR|PERSONAL-CREAR|PERSONAL-EDITAR|PERSONAL-ELIMINAR', ['only' => ['index', 'store']]);
      $this->middleware('permission:PERSONAL-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:PERSONAL-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:PERSONAL-ELIMINAR', ['only' => ['destroy']]);
   }

   public function datatables()
   {
      $empleado = DB::table('empleados')
         ->join('users', 'users.empleados_id', '=', 'empleados.id')
         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
         ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
         ->join('equipos', 'equipos.id', '=', 'empleados.equipos_id')
         ->join('profesiones', 'profesiones.id', '=', 'empleados.profesiones_id')
         ->select('empleados.*', 'empleados.id as emp_id', 'roles.name as rol_name', 'equipos.nombre as nom_equi', 'profesiones.nombre as profesion')
         ->where([
            ['empleados.deleted_at', null],
            ['users.deleted_at', null],
            ['roles.deleted_at', null],
         ]);

      return DataTables::of($empleado)
         ->addColumn('acciones', function ($empleado) {
            '<div>';
            if (Auth::user()->can('PERSONAL-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $empleado->emp_id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('PERSONAL-EDITAR')) {
               $mostrar .=
               '<a href="' . route("empleados.edit", $empleado->emp_id) . '" class="btn btn-info btn-accion mr-1 edit">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('PERSONAL-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $empleado->emp_id . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($empleado) {
            if (Auth::user()->can('PERSONAL-EDITAR')) {
               if ($empleado->estado == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $empleado->emp_id . '" id="empleado' . $empleado->emp_id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($empleado->estado == '0') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $empleado->emp_id . '" id="empleado' . $empleado->emp_id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" >
                  </div>';
               }
            } else {
               if ($empleado->estado == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($empleado->estado == '0') {
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
      $year = DB::table('empleados')
         ->select('empleados.*')
         ->selectRaw('DATE_FORMAT(empleados.created_at, "%Y") as year')
         ->selectRaw('CONCAT("INVENTARIO ", DATE_FORMAT(empleados.created_at, "%Y")) as nombre')
         ->where('empleados.deleted_at', null)
         ->orderBy('created_at', 'desc')
         ->pluck('nombre', 'year')
         ->toArray();

      return view('empleados.index', ['year' => $year]);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $equipo = Equipo::where('estado', 1)->pluck('nombre', 'id')->toArray();
      $rol    = Role::where([
         ['deleted_at', null],
         ['status', 1],
      ])
         ->pluck('name', 'id')->toArray();
      $profesion = Profesion::pluck('nombre', 'id')->toArray();
      return view('empleados.create', ['profesion' => $profesion, 'rol' => $rol, 'equipo' => $equipo]);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(EmpleadoCRequest $request)
   {
      //***************** TABLA: EMPLEADOS ****************
      $empleado                 = new Empleado;
      $empleado->nombres        = strtoupper($request->nom_emp);
      $empleado->apellidos      = strtoupper($request->ape_emp);
      $empleado->completos      = strtoupper($request->nom_emp . ' ' . $request->ape_emp);
      $empleado->email          = strtoupper($request->email_emp);
      $empleado->genero         = strtoupper($request->gen_emp);
      $empleado->tipodoc        = strtoupper($request->tipodoc_emp);
      $empleado->nrodoc         = $request->nrodoc_emp;
      $empleado->celular        = $request->cel_emp;
      $empleado->fec_nac        = date('Y-m-d', strtotime($request->fec_nac));
      $empleado->profesiones_id = $request->prof_emp;
      $empleado->equipos_id     = $request->equipo_emp;
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_emp') == null) {
         $empleado->rutaimagen = "";
      } else {
         $empleado->rutaimagen = $request->file('imagen_emp')->store('personal');
      }
      $empleado->estado = $request->est_emp;
      $empleado->save();

      // ***************** TABLA: USUARIOS ****************
      $apellido          = explode(' ', strtoupper($request->ape_emp));
      $nombre            = explode(' ', strtoupper($request->nom_emp));
      $primera_lnombre   = substr(strtoupper($request->nom_emp), 0, 1);
      $primera_lapellido = substr(strtoupper($request->ape_emp), 0, 1);
      $dni               = $request->nrodoc_emp;

      // $nom_usuario = $$request->nom_emp . $apellido[0];
      $nom_usuario = $nombre[0] . ' ' . $apellido[0];
      $clave       = $primera_lapellido . $primera_lnombre . $dni;

      $usuario           = new User;
      $usuario->name     = $nom_usuario;
      $usuario->email    = strtoupper($request->email_emp);
      $usuario->password = bcrypt($clave);
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_emp') == null) {
         $usuario->rutaimagen = "";
      } else {
         $usuario->rutaimagen = $request->file('imagen_emp')->store('usuarios');
      }
      $usuario->empleados_id = $empleado->id;
      $usuario->status       = $request->est_emp;
      $usuario->save();
      $usuario->assignRole($request->input('cargo_emp'));

      toastr()->success('Registro agregado correctamente.');

      return redirect('empleados');
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
         $empleado = Empleado::findOrFail($id);
         // NOMBRE DE USUARIO INICIAL
         $nom_usuario = (explode(' ', strtoupper($empleado->nombres))[0]) . ' ' . (explode(' ', strtoupper($empleado->apellidos))[0]);
         $clave       = (substr(strtoupper($empleado->apellidos), 0, 1)) . (substr(strtoupper($empleado->nombres), 0, 1)) . ($empleado->nrodoc);

         $equipo = Equipo::findOrFail($empleado->equipos_id);
         // OBTENER EL ROL DESDE LARAVEL PERMISSION
         $usuario    = User::where('empleados_id', $id)->first();
         $rol        = Role::pluck('name', 'name')->all();
         $usuarioRol = $usuario->roles->first();

         $profesion = Profesion::findOrFail($empleado->profesiones_id);
         return response()->json(['empleado' => $empleado, 'equipo' => $equipo, 'usuarioRol' => $usuarioRol, 'nom_usuario' => $nom_usuario, 'profesion' => $profesion, 'clave' => $clave]);
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
      $empleado = Empleado::findOrFail($id);

      $usuario = User::where('empleados_id', $id)->first();
      $rol     = Role::where([
         ['deleted_at', null],
         ['status', 1],
      ])->pluck('name', 'name')->all();
      $usuarioRol = $usuario->roles->pluck('name', 'name')->all();

      $equipo    = Equipo::where('estado', 1)->pluck('nombre', 'id')->toArray();
      $profesion = Profesion::pluck('nombre', 'id')->toArray();
      return view('empleados.edit', ['empleado' => $empleado, 'profesion' => $profesion, 'rol' => $rol, 'usuarioRol' => $usuarioRol, 'equipo' => $equipo]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

   public function update(EmpleadoURequest $request, $id)
   {
      $empleado                 = Empleado::findOrFail($id);
      $empleado->nombres        = strtoupper($request->nom_emp);
      $empleado->apellidos      = strtoupper($request->ape_emp);
      $empleado->completos      = strtoupper($request->nom_emp . ' ' . $request->ape_emp);
      $empleado->email          = strtoupper($request->email_emp);
      $empleado->genero         = strtoupper($request->gen_emp);
      $empleado->tipodoc        = strtoupper($request->tipodoc_emp);
      $empleado->nrodoc         = $request->nrodoc_emp;
      $empleado->celular        = $request->cel_emp;
      $empleado->fec_nac        = date('Y-m-d', strtotime($request->fec_nac));
      $empleado->profesiones_id = $request->prof_emp;
      $empleado->equipos_id     = $request->equipo_emp;
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_emp') == null) {
         $empleado->rutaimagen = $empleado->rutaimagen;
      } else {
         $empleado->rutaimagen = $request->file('imagen_emp')->store('personal');
      }
      $empleado->estado = $request->est_emp;
      $empleado->save();

      //***************** TABLA: USUARIOS ****************
      $usuario = User::where('empleados_id', $id)->first();
      DB::table('model_has_roles')->where('model_id', $usuario->id)->delete();
      $usuario->assignRole($request->input('cargo_emp'));

      toastr()->info('Registro actualizado correctamente.');
      return redirect('empleados');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

   public function destroy($id)
   {
      $empleado = Empleado::findOrFail($id);
      $usuario  = User::where('empleados_id', $id)->first();

      $usuario->delete();
      $empleado->delete();
      DB::table('model_has_roles')->where('model_id', $usuario->id)->delete();
   }

   public function cambiarEstadoEmpleado(Request $request)
   {
      $empleado                 = Empleado::find($request->empleado_id);
      $empleado->nombres        = $empleado->nombres;
      $empleado->apellidos      = $empleado->apellidos;
      $empleado->completos      = $empleado->completos;
      $empleado->email          = $empleado->email;
      $empleado->genero         = $empleado->genero;
      $empleado->tipodoc        = $empleado->tipodoc;
      $empleado->nrodoc         = $empleado->nrodoc;
      $empleado->celular        = $empleado->celular;
      $empleado->profesiones_id = $empleado->profesiones_id;
      $empleado->equipos_id     = $empleado->equipos_id;
      $empleado->rutaimagen     = $empleado->rutaimagen;
      $empleado->estado         = $request->estado;
      $empleado->save();

      $usuario         = User::where('empleados_id', $request->empleado_id)->first();
      $usuario->status = $request->estado;
      $usuario->save();

      return response()->json(['success' => 'Estado actualizado correctamente.']);

   }
}
