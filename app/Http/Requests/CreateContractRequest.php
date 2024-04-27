<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateContractRequest extends FormRequest
{

    public function authorize()
    {
        return $this->user()->isAdmin(); // Only allow admins to create contracts
    }

    public function rules()
    {
        return [
            'application_id' => [
                'required',
                Rule::exists('applications', 'id'),
            ],
            'sign_date' => 'required|date',
            'start_date' => [
                'required',
                'date',
                'after:sign_date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value)->isPast()) {
                        $fail('The '.$attribute.' must be a date in the future.');
                    }
                },
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value)->isPast()) {
                        $fail('The '.$attribute.' must be a date in the future.');
                    }
                },
            ]
        ];
    }
}
