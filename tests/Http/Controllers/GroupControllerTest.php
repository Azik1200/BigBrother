<?php

namespace Tests\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_group_successfully()
    {
        // Create a mock authenticated user
        $user = User::factory()->create();

        // Log in the user
        Auth::login($user);

        // Data to be sent with the request
        $data = [
            'name' => 'Test Group',
            'user_id' => $user->id,
        ];

        // Send POST request to the store method
        $response = $this->post(route('groups.store'), $data);

        // Assert redirection to the index route
        $response->assertRedirect(route('groups.index'));

        // Assert the success message is in the session
        $response->assertSessionHas('success', 'Группа успешно создана!');

        // Assert the group exists in the database
        $this->assertDatabaseHas('groups', [
            'name' => 'Test Group',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_returns_validation_error_when_name_is_missing()
    {
        // Create a mock authenticated user
        $user = User::factory()->create();

        // Log in the user
        Auth::login($user);

        // Data with missing name
        $data = [
            'name' => '',
            'user_id' => $user->id,
        ];

        // Send POST request to the store method
        $response = $this->post(route('groups.store'), $data);

        // Assert the validation error
        $response->assertSessionHasErrors(['name']);

        // Assert the group is not created in the database
        $this->assertDatabaseMissing('groups', [
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_returns_validation_error_when_user_id_is_missing()
    {
        // Create a mock authenticated user
        $user = User::factory()->create();

        // Log in the user
        Auth::login($user);

        // Data with missing user_id
        $data = [
            'name' => 'Test Group',
            'user_id' => null,
        ];

        // Send POST request to the store method
        $response = $this->post(route('groups.store'), $data);

        // Assert the validation error
        $response->assertSessionHasErrors(['user_id']);

        // Assert the group is not created in the database
        $this->assertDatabaseMissing('groups', [
            'name' => 'Test Group',
        ]);
    }
}
