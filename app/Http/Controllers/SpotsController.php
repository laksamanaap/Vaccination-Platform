<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spots;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpotsController extends Controller
{
    public function getVacinationSpots(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $inputToken = $request->input('token');
        $user = User::where('login_tokens', $inputToken)->first();
        $userRegionalId = $user->regional_id;

        $spot = Regional::with('spots.spot_vaccine.vaccine')->find($userRegionalId);

        return response()->json($spot,200);

    }

    public function getDetailVacinationSpots(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $date = $request->input('date');

        $spotVacinationsCount = Spots::withCount('vaccinations_count as total_doses')
        ->with('vaccinations_count')
        ->find($id);

        // Handle get vaccination by date
        $vaccinationByDate = Spots::with(['vaccinations_count' => function ($query) use ($date) {
        $query->whereDate('date', $date);
        }])
        ->find($id);

        // Handle get total dose
        $totalDose = $spotVacinationsCount->total_doses;

        $spot = Spots::with('spot_vaccine.vaccine')
        ->find($id);

        if (!$spot) {
            return response()->json(['Error' => 'Spots not found']);
        }
      
        return response()->json([
            'date' => $request->input('date'),
            'spot' => $spot,
            'vaccinations_count_list' => $spotVacinationsCount->vaccinations_count,
            'vaccination_list_date' => $vaccinationByDate->vaccinations_count,
            'vaccinations_count' => $totalDose
        ],200); 

    }
}
