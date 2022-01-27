<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{

    public function getOrganizations(Request $request){
        $organizations = Organization::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'organizations' => $organizations]);
    }

    public function createOrganization(OrganizationRequest $request)
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
    }

    public function updateOrganization(OrganizationRequest $request, $organizationId)
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
            return $this->getOrganizations($request);
        }
    }
}
