<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Http\Controllers\OrganizationController;

/**
 * @covers  OrganizationController
 */
class OrganizationControllerTest extends TestCase
{
    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        // create user
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->user = Auth::user();
    }

    /**
     * A test for organization creation.
     * @covers OrganizationController::store
     * @return void
     */
    public function test_create_valid_organization()
    {
        $this->assertNotNull($this->user['id']);

        $data = [
            'user_id' => $this->user['id'],
            'organizationName' => 'Test name',
            'association' => 'Test role',
            'startDate' => '2022-01-27 17:00:00',
            'endDate' => '2022-02-27 17:00:00',
            'present' => false,
            'description' => 'Test Description'
        ];

        $response = $this->call('POST', '/api/organizations', $data);
        $response->assertStatus(201);
        $response = $response->getOriginalContent();
        $this->assertTrue($response['success']);
        $organization = $response['organization'];

        $user = DB::table('users')->find($this->user['id']);

        $this->assertEquals($data['user_id'], $user->id);
        $this->assertEquals($data['user_id'], $organization['user_id']);
        $this->assertEquals($data['organizationName'], $organization['organization_name']);
        $this->assertEquals($data['association'], $organization['association']);
        $this->assertEquals($data['startDate'], $organization['start_date']);
        $this->assertEquals($data['endDate'], $organization['end_date']);
        $this->assertEquals($data['present'], $organization['present']);
        $this->assertEquals($data['description'], $organization['description']);
    }

    /**
     * A test for organization update.
     * @covers OrganizationController::update
     * @return void
     */
    public function test_update_organization()
    {
        $this->assertNotNull($this->user['id']);
        $this->test_create_valid_organization();

        $organization = DB::table('organizations')->where('user_id', $this->user['id'])->first();

        $data = [
            'user_id' => $this->user['id'],
            'organizationName' => 'Test name updated',
            'association' => 'Test role updated',
            'startDate' => '2021-01-27 17:00:00',
            'endDate' => '2022-09-27 17:00:00',
            'present' => false,
            'description' => 'Test description updated'
        ];

        $response = $this->call('PUT', "/api/organizations/$organization->id", $data);

        $response->assertStatus(201);
        $response = $response->getOriginalContent();
        $this->assertTrue($response['success']);
    }

    /**
     * A test for failure organization creation.
     *
     * @dataProvider organization_provider
     *
     * @param $organizationName
     * @param $association
     * @param $startDate
     * @param $endDate
     * @return void
     */
    public function test_create_failure_organization($organizationName, $association, $startDate, $endDate): void
    {
        $data = [
            'companyName' => $organizationName,
            'role' => $association,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $response = $this->call('POST', '/api/organizations', $data);
        $response = $response->getOriginalContent();

        $this->assertNull($response);
    }

    public function organization_provider(): iterable
    {
        return [
            [
                'organizationName' => 'Test name',
                'association' => 'Test role',
                'startDate' => '2022-01-27 17:00:00',
                'endDate' => '2021-02-27 17:00:00', // early then start date
            ],
            [
                'organizationName' => '', // companyName is not exist
                'association' => 'Test role',
                'startDate' => '2022-01-27 17:00:00',
                'endDate' => '2022-02-27 17:00:00', // early then start date
            ],
            [
                'organizationName' => 'Test name',
                'association' => '', // role is not exist
                'startDate' => '2022-01-27 17:00:00',
                'endDate' => '2022-02-27 17:00:00', // early then start date
            ],
            [
                'organizationName' => 'Test name',
                'association' => 'Test role',
                'startDate' => '', // startDate is not exist
                'endDate' => '2022-02-27 17:00:00', // early then start date
            ]
        ];
    }

}
