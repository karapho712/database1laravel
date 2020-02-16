<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class alumnidatabasesRequest extends FormRequest
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
            'nama' => 'required|max:255', 
            'id_periode' => 'required',
            'tingkat_kompetensi' => 'nullable|max:255',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_pengambilan' => 'nullable|date',
            'keterangan' => 'nullable|max:255'
            //
        ];
    }
}
