<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rua' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string',
            'complemento' => 'required|string',
            'cep' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string'
        ];
    }
}
