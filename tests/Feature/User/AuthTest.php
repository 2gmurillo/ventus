<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aUserCanViewRegisterForm()
    {
        //$this->withoutExceptionHandling();
        //Act
        $response = $this->get('/register');

        //Assert
        $response->assertOk();
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function aUserCanRegister()
    {
        //Act
        $response = $this->post('/register', [
            'name' => 'Juango',
            'email' => 'gonzalo@amuletto.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        //Assert
        $user = User::orderBy('id', 'desc')->first();
        $this->assertEquals('Juango', $user->name);
        $this->assertEquals('gonzalo@amuletto.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
        $response->assertRedirect('/home');
    }

    /** @test */
    public function registerErrorMailFormatPass()
    {
        //Act
        $response = $this->post('/register', [
            'name' => 'Juango',
            'email' => 'gonzaloamuletto.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        //Assert
        $response->assertRedirect();
    }

    /** @test */
    public function registerErrorConfirmPass()
    {
        //Act
        $response = $this->post('/register', [
            'name' => 'Juango',
            'email' => 'gonzalo@amuletto.com',
            'password' => 'password',
            'password_confirmation' => 'incorrect-password',
        ]);

        //Assert
        $response->assertRedirect();
    }

    /** @test */
    public function aUserCanViewLoginForm()
    {
        //Act
        $response = $this->get('/login');

        //Assert
        $response->assertOk();
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function anAuthenticatedUserCannotViewLoginForm()
    {
        //Arrange
        $user = User::factory()->make();

        //Act
        $response = $this->actingAs($user)->get('/login');

        //Assert
        $response->assertRedirect('/home');
    }

    /** @test */
    public function anUserCanLoginWithCorrectCredentials()
    {
        //Arrange
        $user = User::factory()->create([
            'password' => Hash::make($password = 'password'),
        ]);

        //Act
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        //Assert
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function anUserCannotLoginWithIncorrectCredentials()
    {
        //Arrange
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        //Act
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ]);

        //Assert
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
