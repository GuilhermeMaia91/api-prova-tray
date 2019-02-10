<?php

namespace App\Http\Requests;

class UserRequest extends BaseRequest
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
        if ($this->method() == 'POST') {
            return [
                'name' => 'required',
                'email' => 'required'
            ];
        }

        if (in_array($this->method(), ['PUT', 'PATCH'])){
            return [
                'id' => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo name é obrigatório!',
            'email.required' => 'O campo email é obrigatório!'
        ];
    }
}
