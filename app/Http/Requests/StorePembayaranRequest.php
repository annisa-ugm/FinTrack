<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class StorePembayaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_pembayaran' => 'required',
            'id_siswa' => 'required',
            'id_user' => 'required',
            'tanggal_pembayaran' => 'required',
            'jenis_pembayaran' => 'required',
            'nominal' => 'required',
            'catatan' => 'nullable'
        ];
    }
}
