<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCRequest extends FormRequest
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
            'nom_usu'    => 'required|string|unique:users,name,NULL,id,deleted_at,NULL',
            'email_usu'  => 'required|email|max:40|unique:users,email,NULL,id,deleted_at,NULL',
            'est_usu'    => 'required',
            'rol_usu'    => 'required',
            'pass_usu'   => 'required|min:4|max:20',
            'repass_usu' => 'required|same:pass_usu|min:4|max:20',
            'imagen_usu'  => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ];
    }
}
