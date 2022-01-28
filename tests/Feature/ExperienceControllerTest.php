<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Http\Controllers\ExperienceController;

/**
 * @covers  ExperienceController
 */
class ExperienceControllerTest extends TestCase
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
     * A test for experience creation.
     * @covers ExperienceController::store
     * @return void
     */
    public function test_create_valid_experience()
    {
        $this->assertNotNull($this->user['id']);

        $data = [
            'user_id' => $this->user['id'],
            'companyName' => 'Test name',
            'role' => 'Test role',
            'startDate' => '2022-01-27 17:00:00',
            'endDate' => '2022-02-27 17:00:00',
            'present' => false,
            'description' => 'Test Description'
        ];

        $response = $this->call('POST', '/api/experiences', $data);
        $response->assertStatus(201);
        $response = $response->getOriginalContent();
        $this->assertTrue($response['success']);
        $experience = $response['experience'];

        $user = DB::table('users')->find($this->user['id']);

        $this->assertEquals($data['user_id'], $user->id);
        $this->assertEquals($data['user_id'], $experience['user_id']);
        $this->assertEquals($data['companyName'], $experience['company_name']);
        $this->assertEquals($data['role'], $experience['role']);
        $this->assertEquals($data['startDate'], $experience['start_date']);
        $this->assertEquals($data['endDate'], $experience['end_date']);
        $this->assertEquals($data['present'], $experience['present']);
        $this->assertEquals($data['description'], $experience['description']);
    }

    /**
     * A test for experience update.
     *@covers ExperienceController::update
     * @return void
     */
    public function test_update_experience()
    {
        $this->assertNotNull($this->user['id']);
        $this->test_create_valid_experience();

        $experience = DB::table('experiences')->where('user_id', $this->user['id'])->first();

        $data = [
            'user_id' => $this->user['id'],
            'companyName' => 'Test name updated',
            'role' => 'Test role updated',
            'startDate' => '2021-01-27 17:00:00',
            'endDate' => '2022-09-27 17:00:00',
            'present' => false,
            'description' => 'Test description updated'
        ];

        $response = $this->call('PUT', "/api/experiences/$experience->id", $data);

        $response->assertStatus(201);
        $response = $response->getOriginalContent();
        $this->assertTrue($response['success']);
    }

    /**
     * A test for failure experience creation.
     *
     * @dataProvider experience_provider
     *
     * @param $companyName
     * @param $role
     * @param $startDate
     * @param $endDate
     * @return void
     */
    public function test_create_failure_experience($companyName, $role, $startDate, $endDate): void
    {
        $data = [
            'companyName' => $companyName,
            'role' => $role,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $response = $this->call('POST', '/api/experiences', $data);
        $response = $response->getOriginalContent();

        $this->assertNull($response);
    }

    public function experience_provider(): iterable
    {
        return [
            [
                'companyName' => 'Test name',
                'role' => 'Test role',
                'startDate' => '2022-01-27 17:00:00',
                'endDate' => '2021-02-27 17:00:00', // early then start date
            ],
            [
                'companyName' => '', // companyName is not exist
                'role' => 'Test role',
                'startDate' => '2022-01-27 17:00:00',
                'endDate' => '2022-02-27 17:00:00', // early then start date
            ],
            [
                'companyName' => 'Test name',
                'role' => '', // role is not exist
                'startDate' => '2022-01-27 17:00:00',
                'endDate' => '2022-02-27 17:00:00', // early then start date
            ],
            [
                'companyName' => 'Test name',
                'role' => 'Test role',
                'startDate' => '', // startDate is not exist
                'endDate' => '2022-02-27 17:00:00', // early then start date
            ]
        ];
    }

}
