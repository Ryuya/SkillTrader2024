<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory(1000)
            ->create()
            ->each(function ($user) {
                $user->configureLearnableSkills(); // ユーザーが学びたいスキルを関連付ける
                $user->configureTeachableSkills(); // ユーザーが教えられるスキルを関連付ける
            });
    }
}
