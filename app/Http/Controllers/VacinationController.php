<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacination;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacinationController extends Controller
{

    public function storeVaccination(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => "required|string",
            'spot_id' => "required|string",
            'date' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $inputToken = $request->input('token');
        $user = User::where('login_tokens', $inputToken)->first();
        $userSocietyId = $user->id;

        $consultation = Consultation::where('society_id', $userSocietyId)->first();
        $consultationStatus = $consultation->status;
        $consultationId = $consultation->id;

        // Check user vaccination
        $societyIdCount = Vacination::where('society_id', $userSocietyId)->count();

        // Count Day

        if ($consultationStatus === "pending") {
            return response()->json(['message' => 'Your consultation must be accepted by doctor before'],422);
        } else if($societyIdCount >= 2) {
            return response()->json(['message' => 'Society has been 2x vaccinated'],422);
        } else {
            $formData = $request->only(['spot_id','date']);
            $formData['society_id'] = $userSocietyId;

            $vaccinationData = Vacination::create($formData);
            $vaccinationData->save();

            return response()->json($vaccinationData,200);
        }



    }

    public function getVaccination(Request $request)
    {
        $vaccinations = Vacination::with(['spots.regional', 'vaccine', 'medicals'])
        ->get();

        if (!$vaccinations) {
            return response()->json(['error' => 'Vaccination not found'], 404);
        }

        $response = [
        'vaccinations' => collect($vaccinations)->map(function ($vaccination) {
        return [
            'id' => $vaccination->id,
            'dose' => $vaccination->dose,
            'date' => $vaccination->date,
            'society_id' => $vaccination->society_id,
            'spot_id' => $vaccination->spot_id,
            'vaccine_id' => $vaccination->vaccine_id,
            'doctor_id' => $vaccination->doctor_id,
            'officer_id' => $vaccination->officer_id,
            // 'spots' => collect($vaccination->spots)->map(function ($spot) {
            //     return [
            //         'id' => $spot->id,
            //         'regional_id' => $spot->regional_id,
            //         'name' => $spot->name,
            //         'address' => $spot->address,
            //         'serve' => $spot->serve,
            //         'capacity' => $spot->capacity,
            //         'regional' => [
            //             'id' => $spot->regional->id,
            //             'province' => $spot->regional->province,
            //             'district' => $spot->regional->district,
            //         ],
            //     ];
            //     })->toArray(),
                // 'vaccine' => [
                //     'id' => $vaccination->vaccine->id,
                //     'name' => $vaccination->vaccine->name,
                // ],
                // 'vaccinator' => [
                //     'id' => $vaccination->medicals->id,
                //     'role' => $vaccination->medicals->role,
                //     'name' => $vaccination->medicals->name,
                // ],
                'second' => null,
            ];
            })->toArray(),
        ];

      return response()->json($vaccinations , 200);

    }
}
