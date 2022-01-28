<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OrganizationController
 */
class OrganizationController extends Controller
{
    /**
     * Display a listing of the organizations of the auth user.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        $organizations = Organization::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'organizations' => $organizations]);
    }


    /**
     * Create an organization.
     *
     * @param OrganizationRequest $request
     * @return JsonResponse
     */

    public function store(OrganizationRequest $request): JsonResponse
    {
        $response = Organization::create([
            'user_id' => $request->user()->id,
            'organization_name' => $request->organizationName,
            'association' => $request->association,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'present' => $request->present,
            'description' => $request->description
        ]);

        if ($response) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Update the specified organization.
     *
     * @param OrganizationRequest $request
     * @param int $organizationId
     * @return JsonResponse
     */

    public function update(OrganizationRequest $request, int $organizationId): JsonResponse
    {
        $organization = Organization::findOrFail($organizationId);

        $response = $organization->update([
            'organization_name' => $request->organizationName,
            'association' => $request->association,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'present' => $request->present,
            'description' => $request->description
        ]);

        if ($response) {
            return $this->index($request);
        }

        return response()->json(['success' => false]);
    }
}
