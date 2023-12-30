<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function storeConsultation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'disease_history' => 'required|string',
            'current_symptoms' => 'required|string',
            'doctor_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()],422);
        }

        $inputToken = $request->input('token');
        $user = User::where('login_tokens', $inputToken)->first();
        $userId = $user->id;

        $formData = $request->only(['disease_history', 'current_symptoms','doctor_id']);
        $formData['society_id'] = $userId; 

        $consultation = Consultation::create($formData);

        $consultation->doctor;

        $consultation->save();

        return response()->json([
            'message' => 'Request consultation sent successful',
            'data' => $consultation
        ]);

    }

    public function getConsultation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->erros()]);
        }

        $inputToken = $request->input('token');
        $user = User::where('login_tokens', $inputToken)->first();
        $userId = $user->id;
        
        $consultation = Consultation::with('doctor')->where('society_id', $userId)->get();

        return response()->json($consultation,200);

    }


}
