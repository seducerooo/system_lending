<?php
namespace App\Http\Controllers;

use App\Models\Contract;
use App\Http\Requests\CreateContractRequest;
use App\Models\Application;
use http\Client\Request;
use App\Models\Setting;

class ContractController extends Controller
{
    public function store(CreateContractRequest $request)
    {
        $interestRate = Setting::where('key', 'interest_rate')->value('value');
        $loanApplication = Application::findOrFail($request->application_id);

        $contract = Contract::create([
            'application_id' => $request->application_id,
            'sign_date' => $request->sign_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'interest_rate' => $interestRate,
            'loan_term_months' => $loanApplication->loan_term_months,
            'principal' => $loanApplication->principal,
            'status' => Contract::STATUS_ACTIVE
        ]);

        return response()->json(['contract' => $contract], 201);
    }

    public function terminate(Contract $contract, Request $request)
    {
        // Check if the user is an admin
        if (!$request->user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark the contract as terminated
        $contract->update(['status' => Contract::STATUS_TERMINATED]);

        return response()->json(['message' => 'Contract terminated successfully']);
    }

}
