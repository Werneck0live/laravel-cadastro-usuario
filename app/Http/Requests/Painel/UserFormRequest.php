<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'name'      => 'required|min:3|max:100',
            'email'     => 'required|min:5|max:100',
            'cpf'       => 'required|numeric',
            'telefone'  => 'numeric',
            'password'  => 'required'
        ];

    }

    public function messages()
    {
        return[
            'name.required'     => 'O campo nome é de preenchimento obrigatório!',
            'name.min'          => 'O tamanho mínimo do campo nome é de 3 caracteres!',
            'name.max'          => 'O tamanho máximo do campo nome é de 100 caracteres!',
            'email.required'    => 'O campo email é de preenchimento obrigatório!',
            'email.min'         => 'O tamanho mínimo do campo e-mail é de 5 caracteres!',
            'email.max'         => 'O tamanho máximo do campo e-mail é de 100 caracteres!',
            'cpf.required'      => 'O campo cpf é de preenchimento obrigatório!',
            'cpf.numeric'       => 'O campo CPF deve ser numérico!',
            'telefone.numeric'  => 'O campo Telefone deve ser numérico!',
            'password.required' => 'A senha é obrigatória!'
        ];
    }
}
