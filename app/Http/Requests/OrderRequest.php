<?php

namespace App\Http\Requests;

class OrderRequest extends BaseRequest
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
                'user_id' => 'required',
                'price_sale' => 'required'
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
            'user_id.required' => 'O campo user_id é obrigatório!',
            'price_sale.required' => 'O campo price_sale é obrigatório!'
        ];
    }
}
