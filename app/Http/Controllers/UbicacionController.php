<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UbicacionController extends Controller
{

   public function datatables()
   {

      $ubicaciones = DB::table('oficinas')
         ->join('areas', 'areas.id', '=', 'oficinas.areas_id')
         ->join('locales', 'locales.id', '=', 'oficinas.locales_id')
         ->select('locales.codlocal as codlocal', 'locales.descripcion as local', 'areas.codarea as codarea', 'areas.descripcion as area', 'oficinas.codoficina as codoficina', 'oficinas.descripcion as oficina')
         ->where([
            ['locales.deleted_at', null],
            ['areas.deleted_at', null],
            ['oficinas.deleted_at', null],
         ]);

      return DataTables::of($ubicaciones)
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
         ->join('oficinas', 'oficinas.locales_id', '=', 'locales.id')
         ->select('locales.*')
         ->selectRaw("CONCAT(locales.codlocal,' - ', locales.descripcion) as concat_local")
         ->where([
            ['locales.deleted_at', null],
            ['oficinas.deleted_at', null],
         ])
         ->orderBy('codlocal', 'asc')
         ->pluck('concat_local', 'codlocal')
         ->toArray();

      return view('ubicaciones.index', compact('local'));
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
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      //
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
