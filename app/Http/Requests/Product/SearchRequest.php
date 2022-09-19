<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Request;

class SearchRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'cities' => ['nullable', 'array'],
            'cities.*' => ['numeric', 'exists:attributes,id'],
            'category' => ['nullable', 'numeric', 'exists:attributes,id'],
        ];
    }
}
