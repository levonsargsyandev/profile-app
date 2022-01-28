<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * Class ExperienceController
 */
class ExperienceController extends Controller
{

    /**
     * Display a listing of the experiences of the auth user.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request, $statusCode = 200): JsonResponse
    {
        $experiences = Experience::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'experiences' => $experiences], $statusCode);
    }


    /**
     * Create an experience.
     *
     * @param ExperienceRequest $request
     * @return JsonResponse
     */

    public function store(ExperienceRequest $request): JsonResponse
    {
        $experience = [
            'user_id' => $request->user()->id,
            'company_name' => $request->companyName,
            'role' => $request->role,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'present' => $request->present,
            'description' => $request->description
        ];

        $response = Experience::create($experience);

        if ($response) {
            return response()->json(['success' => true, 'experience' => $experience], 201);
        }

        return response()->json(['success' => false]);
    }


    /**
     * Update the specified experience.
     *
     * @param ExperienceRequest $request
     * @param int $experienceId
     * @return JsonResponse
     */

    public function update(ExperienceRequest $request, int $experienceId): JsonResponse
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
            return $this->index($request, 201);
        }

        return response()->json(['success' => false]);
    }
}
