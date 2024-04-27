<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class LoanApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow anyone to create a loan application
    }

    public function rules()
    {
        // Fetch all settings
        $settings = Setting::all();

        $loan_duration_min = $settings->where('key', 'loan_duration_min')->first();
        $loan_duration_max = $settings->where('key', 'loan_duration_max')->first();
        $principal_amount_min = $settings->where('key', 'principal_amount_min')->first();
        $principal_amount_max = $settings->where('key', 'loan_duration_max')->first();

        $fileTypes = $settings->where('key', 'file_types')->value('value');
        $minFileSize = $settings->where('key', 'min_file_size')->value('value');
        $maxFileSize = $settings->where('key', 'max_file_size')->value('value');

        return [
            'user_id' => 'required',
            'duration_months' => 'required|integer|min:'.$loan_duration_min.'|max:'.$loan_duration_max,
            'principal_amount' => 'required|numeric|min:'.$principal_amount_min.'|max:'.$principal_amount_max,
            'documents' => 'required|array',
            'documents.*' => 'required|file|mimes:'.$fileTypes.'|min:'.$minFileSize.'|max:'.$maxFileSize,
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Get the uploaded document types
            $uploadedDocumentTypes = collect($this->file('documents', []))->map(function ($file) {
                return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            });

            // Get the required document types
            $requiredDocumentTypes = ['passport', 'id_card'];

            // Check if all required document types are uploaded
            foreach ($requiredDocumentTypes as $requiredDocumentType) {
                if (!$uploadedDocumentTypes->contains($requiredDocumentType)) {
                    $validator->errors()->add('documents', 'Document type "'.$requiredDocumentType.'" is required.');
                }
            }
        });

    }
}
