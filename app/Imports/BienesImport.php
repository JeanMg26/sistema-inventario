<?php

namespace App\Imports;

use App\Bien;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BienesImport implements ToModel, WithBatchInserts, WithChunkReading, WithValidation, WithStartRow, ShouldQueue  
{
   use Importable;

   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   public function model(array $row)
   {

      return new Bien([
         'codbien'      => $row[0],
         'descripcion'  => $row[1],
         'codlocal'     => $row[2],
         'local'        => $row[3],
         'codarea'      => $row[4],
         'area'         => $row[5],
         'codoficina'   => $row[6],
         'oficina'      => $row[7],
         'pabellon'     => $row[8],
         'codusuario'   => $row[9],
         'usuario'      => $row[10],
         'estado'       => $row[11],
         'marca'        => $row[12],
         'modelo'       => $row[13],
         'dimension'    => $row[14],
         'color'        => $row[15],
         'serie'        => $row[16],
         'fec_reg'      => $row[17],
         'sit_bien'     => $row[18],
         'dsc_otros'    => $row[19],
         'obs_interna'  => $row[20],
         'cod_completo' => $row[2] . $row[4] . $row[6],
      ]);
   }

   public function rules(): array
   {
      return [
         '0'  => 'required|min:12|max:12|unique:bienes,codbien',
         '1'  => 'required|max:250',
         '2'  => 'required|min:3|max:20',
         '3'  => 'required|max:150',
         '4'  => 'required|max:20',
         '5'  => 'required|max:150',
         '6'  => 'required|max:20',
         '7'  => 'required|max:150',
         '8'  => 'required|max:100',
         '9'  => 'required|max:6',
         '10' => 'required|max:100',
         '11' => 'required|max:2',
         '12' => 'max:50',
         '13' => 'max:50',
         '14' => 'max:50',
         '15' => 'max:50',
         '16' => 'max:50',
         '17' => 'required|date_format:Y-m-d',
         '18' => 'required|max:2',
         '19' => 'max:255',
         '20' => 'max:255',

      ];
   }

   public function customValidationMessages()
   {
      return [

         '0.required'     => 'El código del bien es obligatorio.',
         '0.min'          => 'El código del bien debe ser minimo de 12 caracteres.',
         '0.max'          => 'El código del bien debe ser máximo de 12 caracteres.',
         '0.unique'       => 'El código del bien ya esta siendo usado.',
         '1.required'     => 'La descripción del bien es obligatoria.',
         '1.max'          => 'La descripción del bien debe ser máximo de 250 caracteres.',
         '2.required'     => 'El código del local es obligatorio.',
         '2.min'          => 'El código del local debe ser minimo de 3 caracteres.',
         '2.max'          => 'El código del local debe ser máximo de 20 caracteres.',
         '3.required'     => 'El nombre del local es obligatorio.',
         '3.max'          => 'El nombre del local debe ser máximo de 150 caracteres.',
         '4.required'     => 'El código del área es obligatorio.',
         '4.max'          => 'El código del área debe ser máximo de 20 caracteres.',
         '5.required'     => 'El nombre de área es obligatorio.',
         '5.max'          => 'El nombre del área debe ser máximo de 150 caracteres.',
         '6.required'     => 'El código de la oficina es obligatorio.',
         '6.max'          => 'El código de la oficina debe ser máximo de 20 caracteres.',
         '7.required'     => 'El nombre de la oficina es obligatorio.',
         '7.max'          => 'El nombre de la oficina debe ser máximo de 150 caracteres.',
         '8.required'     => 'El nombre del pabellón es obligatorio.',
         '8.max'          => 'El nombre del pabellón debe ser máximo de 100 caracteres.',
         '9.required'     => 'El código del usuario es obligatorio.',
         '9.max'          => 'El código del usuario debe ser máximo de 6 caracteres.',
         '10.required'    => 'El nombre del usuario es obligatorio.',
         '10.max'         => 'El nombre del usuario debe ser máximo de 100 caracteres.',
         '11.required'    => 'El estado del bien es obligatorio.',
         '11.max'         => 'El estado del bien debe ser máximo de 2 caracteres.',
         '12.max'         => 'La marca del bien debe ser máximo de 50 caracteres.',
         '13.max'         => 'El modelo del bien debe ser máximo de 50 caracteres.',
         '14.max'         => 'La dimensión del bien debe ser máximo de 50 caracteres.',
         '15.max'         => 'El color del bien debe ser máximo de 50 caracteres.',
         '16.max'         => 'La serie del bien debe ser máximo de 50 caracteres.',
         '17.required'    => 'La fecha de registro del bien es obligatorio.',
         '17.date_format' => 'El formato de fecha debe ser YY-MM-DD.',
         '18.required'    => 'La situación del bien es obligatorio.',
         '18.max'         => 'La situación del bien debe ser de máximo de 2 caracteres.',
         '19.max'         => 'Las caracteristicas del bien debe ser máximo de 255 caracteres.',
         '20.max'         => 'La observación interna del bien debe ser máximo de 255 caracteres.',
      ];
   }

   public function batchSize(): int
   {
      return 300;
   }

   public function chunkSize(): int
   {
      return 300;
   }

   public function startRow(): int
   {
      return 3;
   }

}
