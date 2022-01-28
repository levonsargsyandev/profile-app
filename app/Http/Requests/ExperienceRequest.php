<?php

namespace App\Http\Requests;

use App\Rules\MaxWords;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ExperienceRequest
 *
 * @property $description
 */
class ExperienceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'companyName' => [
                'required',
                'string'
            ],
            'role' => [
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
                new MaxWords(300),
            ]
        ];
    }
}
