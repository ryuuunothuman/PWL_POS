<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KategoriResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * because in our website, there isn't login verification, we just make this authorize process true. This without role in database, middleware, policy and gate that we usually use in authorization process
         */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_kode' => 'bail|required|unique:m_kategori,kategori_kode, '.$this->route('kategori').',kategori_id|string|min:4|max:10',
            'kategori_nama' => 'bail|required|string|max:100'
        ];
    }
}