<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangeUserStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdminUserCanChangeUserStatus()
    {
        //Arrange
        $authenticatedUser = User::factory()->create([
            'role' => 'admin'
        ]);
        $userToUpdate = User::factory()->create();
        $previousState = $userToUpdate->disabled_at;

        //Act
        $this->actingAs($authenticatedUser)
            ->patch(route('admin.users.status', $userToUpdate));

        //Assert
        $userToUpdate = $userToUpdate->refresh();
        $currentState = $userToUpdate->disabled_at;
        $this->assertNotEquals($previousState, $currentState);
    }


    /** @test */
    public function aNotAdminUserCannotChangeUserStatus()
    {
        //Arrange
        $authenticatedUser = User::factory()->create();
        $userToUpdate = User::factory()->create();
        $previousState = $userToUpdate->disabled_at;

        //Act
        $response = $this->actingAs($authenticatedUser)
            ->patch(route('admin.users.status', $userToUpdate));

        //Assert
        $userToUpdate = $userToUpdate->refresh();
        $currentState = $userToUpdate->disabled_at;
        $response->assertStatus(403);
        $this->assertEquals($previousState, $currentState);
    }
}
