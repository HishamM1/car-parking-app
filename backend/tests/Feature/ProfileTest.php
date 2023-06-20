<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    public function testUserCanGetTheirProfile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/v1/profile');
        $response->assertStatus(200)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => $user->name]);
    }
    public function testUserCanChangePassword()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'testing123',
            'password_confirmation' => 'testing123',
        ]);
        $response->assertStatus(202);
    }

}