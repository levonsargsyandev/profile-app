<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function getExperiences(Request $request){
        $experiences = Experience::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'experiences' => $experiences]);
    }

    public function createExperience(ExperienceRequest $request)
    {
        $response = Experience::create([
            'user_id' => $request->user()->id,
            'company_name' => $request->companyName,
            'role' => $request->role,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'present' => $request->present,
            'description' => $request->description
        ]);

        if ($response) {
            return response()->json(['success' => true]);
        }
    }

    public function updateExperience(ExperienceRequest $request, $experienceId)
    {
        $experience = Experience::findOrFail($experienceId);

        $response = $experience->update([
            'company_name' => $request->companyName,
            'role' => $request->role,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'present' => $request->present,
            'description' => $request->description
        ]);

        if ($response) {
            return $this->getExperiences($request);
        }
    }
}
