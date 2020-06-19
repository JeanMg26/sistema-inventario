<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolURequest extends FormRequest
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
            'nom_rol'  => 'required|max:20|unique:roles,name,' . $this->role . ',id,deleted_at,NULL',
            'est_rol'  => 'required',
            'permisos' => 'required|array',
        ];
    }
}
