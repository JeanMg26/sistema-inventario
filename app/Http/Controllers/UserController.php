<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Equipo;
use App\Http\Requests\UserCRequest;
use App\Http\Requests\UserURequest;
use App\Profesion;
use App\Rules\ValidarActualPass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
   public function __construct()
   {
      $this->middleware('permission:USUARIO-LISTAR|USUARIO-CREAR|USUARIO-EDITAR|USUARIO-ELIMINAR|USUARIO-RESET', ['only' => ['index', 'store']]);
      $this->middleware('permission:USUARIO-CREAR', ['only' => ['create', 'store']]);
      $this->middleware('permission:USUARIO-EDITAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:USUARIO-CREAR', ['only' => ['destroy']]);
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function datatables()
   {
      $user = DB::table('users')
         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
         ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
         ->select('users.*', 'roles.name as role')
         ->where([
            ['roles.deleted_at', null],
            ['roles.status', 1],
            ['users.deleted_at', null],
         ]);

      return DataTables::of($user)
         ->addColumn('acciones', function ($user) {
            '<div>';
            if (Auth::user()->can('USUARIO-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $user->id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('USUARIO-EDITAR')) {
               $mostrar .=
               '<a href="' . route("usuarios.edit", $user->id) . '" class="btn btn-info btn-accion mr-1">
                  <span class="far fa-edit fa-xs"></span>
               </a>';
            }
            if (Auth::user()->can('USUARIO-ELIMINAR')) {
               $mostrar .=
               '<button class="btn btn-danger btn-accion delete mr-1" id="' . $user->id . '">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>';

               if ($user->empleados_id != '' || $user->empleados_id != null) {
                  $mostrar .=
                  '<button type="button" class="btn btn-success btn-sm btn-accion reset" id="' . $user->id . '" >
                     <i class="fad fa-unlock-alt"></i>
                  </button>';
               } 
               
            }
            '</div>';
            return $mostrar;
         })
         ->addColumn('checkbox-estado', function ($user) {

            if (Auth::user()->can('USUARIO-EDITAR')) {
               if ($user->status == '1') {
                  return
                  '<div class="centrar">
                     <input data-id="' . $user->id . '" id="user' . $user->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger" checked >
                  </div>';
               }

               if ($user->status == '0') {
                  return
                  '<div class="centrar">
                  <input data-id="' . $user->id . '" id="user' . $user->id . '" class="toggle-class" type="checkbox" data-size="xs" data-onstyle="success" data-offstyle="danger">
               </div>';
               }
            } else {
               if ($user->status == '1') {
                  return
                     '<button type="button" class="btn btn-success btn-sm btn-accion"><i class="far fa-check"></i></button>';
               }
               if ($user->status == '0') {
                  return
                     '<button type="button" class="btn btn-danger btn-sm btn-accion2"><i class="far fa-times"></i></button>';
               }
            }
         })
         ->addIndexColumn()
         ->rawColumns(['acciones', 'checkbox-estado'])
         ->make(true);
   }

   public function index(Request $request)
   {
      $year = DB::table('users')
         ->select('users.*')
         ->selectRaw('DATE_FORMAT(users.created_at, "%Y") as year')
         ->selectRaw('CONCAT("INVENTARIO ", DATE_FORMAT(users.created_at, "%Y")) as nombre')
         ->where('users.deleted_at', null)
         ->orderBy('created_at', 'desc')
         ->pluck('nombre', 'year')
         ->toArray();

      $rol = DB::table('users')
         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
         ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
         ->select('roles.name as rol_name')
         ->where([
            ['roles.deleted_at', null],
            ['roles.status', 1],
            ['users.deleted_at', null],
         ])
         ->orderBy('rol_name', 'asc')
         ->pluck('rol_name', 'rol_name')
         ->toArray();

      return view('usuarios.index', compact('year', 'rol'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $rol = Role::where([
         ['roles.deleted_at', null],
         ['roles.status', 1],
      ])
         ->pluck('name', 'id')
         ->toArray();

      return view('usuarios.create', compact('rol'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(UserCRequest $request)
   {

      dd($request->file('imagen_usu'));

      $usuario           = new User;
      $usuario->name     = strtoupper($request->nom_usu);
      $usuario->email    = strtoupper($request->email_usu);
      $usuario->password = bcrypt($request->pass_usu);
      $usuario->status   = $request->est_usu;
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_usu') == null) {
         $usuario->rutaimagen = "";
      } else {
         $usuario->rutaimagen = $request->file('imagen_usu')->store('personal');
      }

      $usuario->save();
      $usuario->assignRole($request->input('rol_usu'));
      toastr()->success('Registro agregado correctamente.');
      return redirect('usuarios');
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

         $usuario = User::findOrFail($id);
         $rol     = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.*')
            ->where('model_has_roles.model_id', '=', $usuario->id)
            ->first();

         if ($usuario->empleados_id == null) {
            return response()->json(['usuario' => $usuario, 'rol' => $rol]);

         } else {
            $empleado  = Empleado::findOrFail($usuario->empleados_id);
            $profesion = Profesion::findOrFail($empleado->profesiones_id);
            $equipo    = Equipo::findOrFail($empleado->equipos_id);
            return response()->json(['usuario' => $usuario, 'rol' => $rol, 'empleado' => $empleado, 'profesion' => $profesion, 'equipo' => $equipo]);
         }

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
      $usuario = User::find($id);
      $rol     = Role::where([
         ['roles.deleted_at', null],
         ['roles.status', 1],
      ])
         ->pluck('name', 'name')
         ->toArray();
      $usuarioRol = $usuario->roles->pluck('name', 'name')->all();
      return view('usuarios.edit', compact('usuario', 'rol', 'usuarioRol'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(UserURequest $request, $id)
   {

      $usuario        = User::find($id);
      $usuario->name  = strtoupper($request->nom_usu);
      $usuario->email = strtoupper($request->email_usu);
      // ****** PASSWORD ***********
      if ($request->pass_usu == '' || $request->pass_usu == null) {
         $usuario->password = $usuario->password;
      } else {
         $usuario->password = bcrypt($request->pass_usu);
      }
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_usu') == null) {
         $usuario->rutaimagen = $usuario->rutaimagen;
      } else {
         $usuario->rutaimagen = $request->file('imagen_usu')->store('usuarios');
      }

      $usuario->status = $request->est_usu;
      $usuario->save();
      DB::table('model_has_roles')->where('model_id', $id)->delete();
      $usuario->assignRole($request->input('rol_usu'));

      toastr()->info('Registro actualizado correctamente.');
      return redirect('usuarios');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $usuario = User::find($id);
      $usuario->delete();
      // DB::table('model_has_roles')->where('model_id', $id)->delete();
   }

   public function cambiarEstadoUsuario(Request $request)
   {
      $usuario           = User::find($request->usuario_id);
      $usuario->name     = $usuario->name;
      $usuario->email    = $usuario->email;
      $usuario->password = $usuario->password;
      $usuario->status   = $request->estado;
      $usuario->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);
   }

   public function editarPerfilUsuario($id)
   {
      if (request()->ajax()) {
         $usuario = User::find($id);
         $rol     = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.*')
            ->where('model_has_roles.model_id', '=', $usuario->id)
            ->first();

         return response()->json(['usuario' => $usuario, 'rol' => $rol]);
      }
   }

   public function actualizarPerfilUsuario(Request $request, User $user)
   {

      // dd($request->repass);

      $rules = [
         'nom_usu'        => 'required|string|unique:users,name,' . $request->perfilusuario_id . ',id,deleted_at,NULL',
         'email_usu'      => 'required|email|max:40|unique:users,email,' . $request->perfilusuario_id . ',id,deleted_at,NULL',
         'est_usu'        => 'required',
         'oldpass_usu'    => ['sometimes', 'required', new ValidarActualPass],
         'pass_usu'       => 'sometimes|required|min:4|max:20',
         'repass_usu'     => 'sometimes|required|same:pass_usu|min:4|max:20',
         'imagen_usuario' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $usuario        = User::findOrFail($request->perfilusuario_id);
      $usuario->name  = strtoupper($request->nom_usu);
      $usuario->email = $usuario->email;
      // ****** PASSWORD ***********
      if ($request->pass_usu == '' || $request->pass_usu == null) {
         $usuario->password = $usuario->password;
      } else {
         $usuario->password = bcrypt($request->pass_usu);
      }
      // **** COMPROBAR IMAGEN ****
      if ($request->file('imagen_usuario') == null) {
         $usuario->rutaimagen = $usuario->rutaimagen;
      } else {
         $usuario->rutaimagen = $request->file('imagen_usuario')->store('usuarios');
      }

      $usuario->status = $usuario->status;
      $usuario->save();
      // DB::table('model_has_roles')->where('model_id', $request->perfilusuario_id)->delete();
      // $usuario->assignRole($request->input('rol_usu'));

      return response()->json(['success' => 'Perfil actualizado correctamente.']);

   }

   public function resetPassword(Request $request)
   {

      $usuario  = User::find($request->reset_id);
      $empleado = Empleado::findOrFail($usuario->empleados_id);
      // RESET PASS
      $primera_lnombre   = substr($empleado->nombres, 0, 1);
      $primera_lapellido = substr($empleado->apellidos, 0, 1);
      $clave             = $primera_lapellido . $primera_lnombre . $empleado->nrodoc;

      $usuario->name     = $usuario->name;
      $usuario->email    = $usuario->email;
      $usuario->password = bcrypt($clave);
      $usuario->status   = $usuario->status;
      $usuario->save();
      return response()->json(['success' => 'Contraseña restablecida correctamente.']);

   }
}
