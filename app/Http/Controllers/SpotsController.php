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
            // 'date' => 'required|string'
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

        $spotVacinationsCount = Spots::with('vaccinations_count')->find($id)->count();
        $spot = Spots::find($id);

        if (!$spot) {
            return response()->json(['Error' => 'Spots not found']);
        }
      
        return response()->json([
            'date' => $request->input('date'),
            'spot' => $spot,
            'vaccinations_count' => $spotVacinationsCount
        ],200); 

    }
}
