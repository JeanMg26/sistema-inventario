<?php

namespace App\Http\Controllers;

use App\Area;
use App\Bien;
use App\Coordinacion;
use App\Cruce;
use App\Equipo;
use App\Imports\BienesImport;
use App\Oficina;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class BienController extends Controller
{

   public function __construct()
   {
      $this->middleware('permission:BIEN-LISTAR|BIEN-CRUZAR|BIEN-IMPORTAR', ['only' => ['index']]);
      $this->middleware('permission:BIEN-CRUZAR', ['only' => ['edit', 'update']]);
      $this->middleware('permission:BIEN-IMPORTAR', ['only' => ['excel', 'importExcel']]);
   }

   // ****************** VISTA DEL EXCEL ************************
   public function excel()
   {
      return view('bienes.excel');
   }

   // ******************* USANDO SPOUT *****************************
   // public function importExcel(Request $request)
   // {
   //    // $rules = [
   //    //    'files' => 'required|max:50000|mimes:xls,xlsx',
   //    // ];

   //    // $error = Validator::make($request->all(), $rules);

   //    // if ($error->fails()) {
   //    //    return response()->json(['errors' => $error->errors()]);
   //    // }


   //    $executionStartTime = microtime(true);

   //    $archivo = $request->file('files');
   //    // $reader  = ReaderEntityFactory::createXLSXReader();
   //    $reader = ReaderEntityFactory::createCSVReader();
   //    $reader->setEncoding('ISO-8859-1');
   //    $reader->open($archivo);

   //    foreach ($reader->getSheetIterator() as $sheet) {

   //       foreach ($sheet->getRowIterator() as $index => $row) {

   //          $value = $row->toArray();

   //          if ($index > 1) {
   //             // Importar desde la fila #3

   //             $data = [
   //                'codbien'      => $value[0],
   //                'descripcion'  => $value[1],
   //                'codlocal'     => $value[2],
   //                'local'        => $value[3],
   //                'codarea'      => $value[4],
   //                'area'         => $value[5],
   //                'codoficina'   => $value[6],
   //                'oficina'      => $value[7],
   //                'pabellon'     => $value[8],
   //                'codusuario'   => $value[9],
   //                'usuario'      => $value[10],
   //                'estado'       => $value[11],
   //                'marca'        => $value[12],
   //                'modelo'       => $value[13],
   //                'dimension'    => $value[14],
   //                'color'        => $value[15],
   //                'serie'        => $value[16],
   //                'fec_reg'      => $value[17],
   //                'sit_bien'     => $value[18],
   //                'dsc_otros'    => $value[19],
   //                'obs_interna'  => $value[20],
   //                'cod_completo' => $value[2] . $value[4] . $value[6],
   //             ];

   //             $bienes = new Bien($data);
   //             $bienes->save();
   //          }

   //       }
   //    }

   //    $reader->close();

   //    $executionEndTime = microtime(true);
   //    $data             = round($executionEndTime - $executionStartTime, 2);

   //    $output = array(
   //       'success'           => true,
   //       'registros_totales' => $data,
   //    );

   //    return response()->json($output);

   // }

   // *************** IMPORTAR REGISTROS EN EXCEL ********************
   public function importExcel(Request $request)
   {

      $rules = [
         'files' => 'required|max:50000|mimes:xls,xlsx',
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $archivo = $request->file('files');
      $row     = (new BienesImport)->toArray($archivo);

      try {

         // Excel::import(new BienesImport, $archivo);
         Excel::queueImport(new BienesImport, $archivo);

         $output = array(
            'success'           => true,
            'registros_totales' => (count($row[0])),
         );

         return response()->json($output);

      } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

         $import = new BienesImport();
         $import->import($archivo);

      }
   }

   // *********** TRUNCATE TABLA BIENES *****************
   public function truncateBienes()
   {
      DB::statement('SET FOREIGN_KEY_CHECKS=0');
      DB::table('bienes')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1');

      return response()->json(['success' => true]);
   }

   // *********** DATOS PARA LOCAL - AREA **************
   public function cruce_areas(Request $request)
   {
      if ($request->ajax()) {
         $local_id = Input::get('localID');
         $area     = Area::where([
            ['locales_id', '=', $local_id],
            ['deleted_at', null],
            ['estado', 1],
         ])->get();
         return response()->json($area);
      }
   }

   // *********** DATOS PARA AREA - OFICINA **************
   public function cruce_oficinas(Request $request)
   {
      if ($request->ajax()) {
         $area_id = Input::get('areaID');
         $oficina = Oficina::where([
            ['areas_id', '=', $area_id],
            ['deleted_at', null],
            ['estado', 1],
         ])->get();
         return response()->json($oficina);
      }
   }

   public function datatables()
   {

      $bien = Bien::select('bienes.*');

      return DataTables::of($bien)
         ->addColumn('opciones', function ($bien) {
            '<div>';
            if (Auth::user()->can('BIEN-LISTAR')) {
               $mostrar =
               '<button class="btn btn-warning btn-accion text-white mr-1 view" id="' . $bien->id . '">
                  <span class="fal fa-eye fa-xs"></span>
               </button>';
            }
            if (Auth::user()->can('BIEN-CRUZAR')) {
               $mostrar .=
               '<button class="btn btn-info btn-accion text-white mr-1 location" id="' . $bien->id . '">
                  <span class="far fa-map-marker-alt"></span>
               </button>';
            }
            '</div>';
            return $mostrar;
         })
         ->rawColumns(['opciones'])
         ->addIndexColumn()
         ->make(true);
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
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

      return view('bienes.index', ['local' => $local]);}

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
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      $bien = Bien::findOrFail($id);

      if (Coordinacion::where('cod_completo', '=', $bien->cod_completo)->exists()) {

         if (request()->ajax()) {

            $coordinacion = Coordinacion::where('cod_completo', $bien->cod_completo)->firstOrFail();
            $equipo       = Equipo::where('id', $coordinacion->equipos_id)->firstOrFail();

            return response()->json(['bien' => $bien, 'coordinacion' => $coordinacion, 'equipo' => $equipo]);
         }

      } else {

         if (request()->ajax()) {
            return response()->json(['bien' => $bien]);
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
      if (request()->ajax()) {
         $bien = Bien::findOrFail($id);
         return response()->json(['bien' => $bien]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

   public function update(Request $request, Bien $bien)
   {

      if (auth()->user()->empleados_id == '' || auth()->user()->empleados_id == null) {

         return response()->json(['warning' => 'Usted no pertenece a ningun equipo.']);

      } else {

         $rules = [
            'local_db'    => 'required',
            'area_db'     => 'required',
            'oficina_db'  => 'required',
            'local_enc'   => 'required',
            'area_enc'    => 'required',
            'oficina_enc' => 'required',
         ];

         $error = Validator::make($request->all(), $rules);

         if ($error->fails()) {
            return response()->json(['errors' => $error->errors()]);
         }

         $bien = Bien::findOrFail($request->bien_id);

         $equipo_id = DB::table('users')
            ->join('empleados', 'empleados.id', '=', 'users.empleados_id')
            ->join('equipos', 'equipos.id', '=', 'empleados.equipos_id')
            ->select('equipos.id as equipo')
            ->where('empleados.id', Auth::user()->empleados_id)
            ->pluck('equipo')
            ->first();

         $cruce              = new Cruce;
         $cruce->bienes_id   = $bien->id;
         $cruce->equipos_id  = $equipo_id;
         $cruce->locales_db  = $request->local_db;
         $cruce->areas_db    = $request->area_db;
         $cruce->oficinas_db = $request->oficina_db;

         $cruce->locales_enc  = $request->local_enc;
         $cruce->areas_enc    = $request->area_enc;
         $cruce->oficinas_enc = $request->oficina_enc;
         $cruce->observacion  = $request->observacion;
         // $cruce->user_login = ID USUARIO LOGUEADO
         $cruce->estado   = 0;
         $cruce->user_ing = Auth::user()->id;
         $cruce->save();
         return response()->json(['success' => 'Registro actualizado correctamente.']);
      }

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
}
