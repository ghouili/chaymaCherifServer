<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::with('rubric')->get();
        return response()->json([
            'success' => true,
            'message' => 'tt budgets',
            'data' => $budgets,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetRequest $request)
    {
        // return dd($request);
        $budget = Budget::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'budget a ete cree avec success',
            'data' => $budget,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        return response()->json([
            'success' => true,
            'message' => 'budget trouver avec success',
            'data' => $budget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        $budget->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'budget modifier avec success',
            'data' => $budget,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return response()->json([
            'success' => true,
            'message' => 'budget Suprimer avec success',
            'data' => null,
        ]);
    }
}
