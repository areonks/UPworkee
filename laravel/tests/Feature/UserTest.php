<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected string $userToken;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        if (User::all()->count() > 22) {
            dd('wrong DB please check configs');
        }

        //Following code will erase whole dataBase please be careful!!!
        $this->artisan('migrate:fresh');
        $this->seed(
            DatabaseSeeder::class
        );
        $createUserResponse = $this->post('api/register', [
            'email' => 'areonks@gmail.com',
            'password' => '1',
            'username' => 'sdf',
            'password_confirmation' => '1'
        ]);
        $this->userToken = $createUserResponse->json('data')['token'];
        $createUserResponse->assertStatus(200);

    }

    public function test_get_user()
    {

        $user = User::all()->last();
        $getUserResponse = $this->actingAs($user)
            ->get('api/user');
        $getUserResponse->assertStatus(200)->assertJsonFragment(
            [
                "id" => 22,
                "username" => "sdf",
                "email" => "areonks@gmail.com",
                "email_verified_at" => null,
                "coins" => 5,
                "likes" => 0
            ]
        );
    }

    public function test_login()
    {
        $this->userToken ='';
        $loginUserResponse = $this->post('api/login', [
            'email' => 'areonks@gmail.com',
            'password' => '1',
        ]);

        $loginUserResponse->assertStatus(200)->assertJsonStructure(
            ['data' => [
                'token'
            ]]
        );
    }
}
