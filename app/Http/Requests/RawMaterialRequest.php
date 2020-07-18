<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RawMaterialRequest extends FormRequest
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
            'raw_material_id' => 'required|numeric',
            'name' => 'required|max:255',
            'code' => 'max:255',
            'tag' => 'max:255',
            'price' => 'required|max:255'
        ];
    }
}
