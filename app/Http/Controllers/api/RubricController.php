<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Rubric;
use App\Http\Requests\StoreRubricRequest;
use App\Http\Requests\UpdateRubricRequest;

class RubricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rubrics = Rubric::all();
        return response()->json([
            'success' => true,
            'message' => 'tt rubriques',
            'data' => $rubrics,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRubricRequest $request)
    {
        $rubric = Rubric::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'rubrique a ete cree avec success',
            'data' => $rubric,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rubric $rubric)
    {
        return response()->json([
            'success' => true,
            'message' => 'rubrique trouver avec success',
            'data' => $rubric,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRubricRequest $request, Rubric $rubric)
    {
        $rubric->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'rubrique modifier avec success',
            'data' => $rubric,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rubric $rubric)
    {
        $rubric->delete();
        return response()->json([
            'success' => true,
            'message' => 'Rubric Suprimer avec success',
            'data' => null,
        ]);
    }
}
