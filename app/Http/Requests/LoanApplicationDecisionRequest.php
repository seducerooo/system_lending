<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanApplicationDecisionRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->isAdmin(); // Only allow admins to decide on loan applications
    }

    public function rules()
    {
        return [
            'status' => 'required|in:approved,rejected',
            'reject_reason' => 'required_if:status,rejected',
        ];
    }
}
