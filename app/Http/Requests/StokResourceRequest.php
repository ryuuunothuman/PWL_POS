<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StokResourceRequest extends FormRequest
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
            'barang_id' => 'bail|required|exists:m_barang',
            'user_id' => 'bail|required|exists:m_user',
            'stok_tanggal' => 'bail|required|date',
            'stok_jumlah' => 'bail|required|integer'
        ];
    }
}