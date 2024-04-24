<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangResourceRequest extends FormRequest
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
            'kategori_id' => 'bail|required|exists:m_kategori',
            'barang_kode' => 'bail|required|unique:m_barang,barang_kode, '.$this->route('barang').',barang_id|string|min:3|max:10',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ];
    }
}