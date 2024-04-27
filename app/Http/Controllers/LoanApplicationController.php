<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanApplicationRequest;
use App\Http\Requests\LoanApplicationDecisionRequest;
use App\Models\Application;

class LoanApplicationController extends Controller
{
    public function store(LoanApplicationRequest $request)
    {
        // Retrieve the authenticated user's ID
        $userId = auth()->id();

        // Merge the user_id with validated request data
        $validatedData = array_merge($request->validated(), ['user_id' => $userId]);

        // Create the loan application
        $loanApplication = Application::create($validatedData);
        // Upload and store documents
        foreach ($request->file('documents') as $file) {
            $path = $file->store('documents');
            $fileName = $file->getClientOriginalName();

            // Create document record for each file
            $loanApplication->documents()->create([
                'file_path' => $path,
                'file_type' => $fileName
            ]);
        }

        // Return the created loan application
        return response()->json(['loan_application' => $loanApplication], 201);
    }

    public function decideApplication(LoanApplicationDecisionRequest $request, Application $application)
    {
        // Update the application status and reason
        $application->update($request->validated());

        // Return the updated application
        return response()->json(['loan_application' => $application]);
    }
    
}

