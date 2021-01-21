<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthenticatedUserCanListUsers()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $authenticatedUser = User::factory()->create();

        //Act
        $this->actingAs($authenticatedUser);
        $response = $this->get(route('admin.users.index'));

        //Assert
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
        $responseUsers = $response->getOriginalContent()['users'];
        $this->assertEquals($responseUsers->first()->id, $authenticatedUser->id);
    }
}
