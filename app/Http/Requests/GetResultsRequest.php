<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetResultsRequest extends FormRequest
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
            'order' => ['in:asc,desc'],
            'order_by' => ['in:finished_at,score', 'required_with:order']
        ];
    }
}
