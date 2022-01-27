<?php

namespace App\Http\Requests;

use App\Rules\MaxWords;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResourceCreateRequest
 *
 * @property $description
 */
class OrganizationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'organizationName' => [
                'required',
                'string'
            ],
            'association' => [
                'required',
                'string'
            ],
            'startDate' => [
                'required',
                'date'
            ],
            'endDate' => [
                'nullable',
                'date',
                'after:startDate'
            ],
            'description' => [
                'nullable',
                'string',
                new MaxWords(100),
            ],
        ];
    }
}
