<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class JobVacancyTest extends TestCase
{
    protected string $userToken;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_vacancy()
    {

        $user = User::all()->last();
        $response = $this->actingAs($user)
            ->post('api/vacancies', [
                "title" => "title",
                "description" => "description",
                "tags" => [
                    "tags1",
                    "tags2"
                ]
            ]);

        $response->assertStatus(201)->assertJsonFragment([
            "title" => "title",
            "description" => "description",
            "likes" => null,
            "isLiked" => false,
            "tags" => [
                "tags1",
                "tags2"
            ],
            "responses" => null
        ]);
        $this->assertEquals(3, $user->coins);

    }

    public function test_update_vacancy()
    {

        $user = User::all()->last();
        $vacancyId = $user->jobVacancies->last()->id;
        $response = $this->actingAs($user)
            ->put("api/vacancies/$vacancyId", [
                "title" => "222title",
                "description" => "222description",
                "tags" => [
                    "222tags1"
                ]
            ]);

        $response->assertStatus(200)->assertJsonFragment([
            "title" => "title",
            "description" => "222description",
            "likes" => 0,
            "isLiked" => false,
            "tags" => [
                "222tags1"
            ],
            "responses" => 0
        ]);
        $this->assertEquals(3, $user->coins);
    }

    public function test_like_vacancy()
    {

        $user = User::all()->last();

        $response = $this->actingAs($user)
            ->post("api/vacancies/5/like");

        $response->assertStatus(204);

        $response = $this->actingAs($user)
            ->get("api/likedVacancies/");
        $response->assertStatus(200)->assertJsonFragment([
            'id' => 5,
            'isLiked' => true
        ])->assertJsonMissing([
            'isLiked' => false
        ]);
        $this->assertEquals(3, $user->coins);
    }

    public function test_like_user_get_his_vacancies()
    {
        $randomUserId = rand(1, 20);
        $user = User::all()->last();
        $firstUser = User::all()->find($randomUserId);
        $vacancyId = $firstUser->jobVacancies[0]->id;
        $response = $this->actingAs($user)
            ->post("api/users/$randomUserId/like");
        $response->assertStatus(204);

        $response = $this->actingAs($user)
            ->get("api/likedUsersVacancies/");
        $response->assertStatus(200)->assertJsonFragment([
            'id' => $vacancyId,
        ]);
        $this->assertEquals(3, $user->coins);
    }
}
