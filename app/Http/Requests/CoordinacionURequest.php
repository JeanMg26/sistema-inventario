<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoordinacionURequest extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
   public function authorize()
   {
      return true;
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
   public function rules()
   {
      return [
         'hoja_ent'     => 'required|numeric|digits_between:1,4',
         'sticker_ent'  => 'required|numeric|digits_between:1,4',
         'fec_ent'      => 'required|date_format:d-m-Y',
         'hoja_ret'     => 'required|numeric|digits_between:1,4',
         'sticker_ret'  => 'required|numeric|digits_between:1,4',
         'adic_ret'     => 'nullable|numeric|digits_between:1,4',
         'fec_ret'      => 'required|date_format:d-m-Y|after_or_equal:fec_ent',
         'bienes_ubi'   => 'required|numeric|digits_between:1,4',
         'bienes_noubi' => 'required|numeric|digits_between:1,4',
         'bienes_adic'  => 'nullable|numeric|digits_between:1,4',
         'local'        => 'required',
         'area'         => 'required',
         'oficina'      => 'required',
         'nom_equipo'   => 'required',
      ];
   }
}
