<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Http\Requests\StoreDemandeRequest;
use App\Http\Requests\UpdateDemandeRequest;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandes = Demande::with('budget', 'user')->get();;
        return response()->json([
            'success' => true,
            'message' => 'tt demandes',
            'data' => $demandes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDemandeRequest $request)
    {
        // return dd($request);
        $demande = Demande::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'demande a ete cree avec success',
            'data' => $demande,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Demande $demande)
    {
        return response()->json([
            'success' => true,
            'message' => 'demande trouver avec success',
            'data' => $demande,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDemandeRequest $request, Demande $demande)
    {
        $demande->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'demande modifier avec success',
            'data' => $demande,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demande $demande)
    {
        $demande->delete();
        return response()->json([
            'success' => true,
            'message' => 'demande Suprimer avec success',
            'data' => null,
        ]);
    }


    public function getDemandeCount()
    {

        $count = Demande::select(DB::raw('status, count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');
        $totalDemandes = DB::table('demande')->count();

        $stats = DB::table('demande')
            ->select(DB::raw('status, count(*) as total'))
            ->groupBy('status')
            ->get();

        $stats = $stats->map(function ($item) use ($totalDemandes) {
            $item->percentage = round(($item->total / $totalDemandes) * 100, 2);
            return $item;
        });

        $stats = $stats->pluck('percentage', 'status');



        return response()->json([
            'success' => true,
            'message' => 'stats',
            'datap' => $stats,
            'datac' => $count,
        ]);
    }

    public function getDemandePerYear()
    {

        $totale = count(Demande::all());
        $stats = DB::table('demande')
            ->select(DB::raw('annee'), DB::raw('count(*) as total'))
            ->groupBy('annee')
            ->get();

        $acceptedStats = DB::table('demande')
            ->where('status', 'accepter')
            ->select(DB::raw('annee'), DB::raw('count(*) as accepted'))
            ->groupBy('annee')
            ->get();

        $refusedStats = DB::table('demande')
            ->where('status', 'refuser')
            ->select(DB::raw('annee'), DB::raw('count(*) as refused'))
            ->groupBy('annee')
            ->get();

        $formattedData = [
            [
                'name' => 'Accepter',
                'color' => '#1A56DB',
                'data' => [],
            ],
            [
                'name' => 'Refuser',
                'color' => '#FDBA8C',
                'data' => [],
            ],
        ];

        foreach ($stats as $stat) {
            $acceptedCount = $acceptedStats->where('annee', $stat->annee)->first();
            $acceptedCount = $acceptedCount ? $acceptedCount->accepted : 0;

            $refusedCount = $refusedStats->where('annee', $stat->annee)->first();
            $refusedCount = $refusedCount ? $refusedCount->refused : 0;

            $formattedData[0]['data'][] = ['x' => $stat->annee, 'y' => $refusedCount];
            $formattedData[1]['data'][] = ['x' => $stat->annee, 'y' => $acceptedCount];
        }

        return response()->json([
            'success' => true,
            'message' => 'stats',
            'total' => $totale,
            'data' => $formattedData,
        ]);
    }
}
