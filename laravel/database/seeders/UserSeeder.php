<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'username',
            'email' => 'email@example.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->count(20)->create();
        $users = User::all();

        $users->each(function ($user) use ($users) {
            for ($x = 0; $x < rand(2, 20); $x++) {
                $randomUser = $users->random()->id;
                if ($user->id !== $randomUser) {
                    $user->addLike($randomUser);
                }
            }
        });
    }
}
