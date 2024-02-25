<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('1234'), // パスワードを1234に設定
            'api_token' => Str::random(60), // APIトークンを生成
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * ユーザーが学びたいスキルを関連付けます。
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function configureLearnableSkills()
    {
        return $this->afterCreating(function (User $user) {
            $skills = Skill::inRandomOrder()->limit(3)->get(); // ランダムに3つのスキルを取得
            $user->learnableSkills()->attach($skills); // ユーザーが学びたいスキルとして関連付ける
        });
    }

    /**
     * ユーザーが教えられるスキルを関連付けます。
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function configureTeachableSkills()
    {
        return $this->afterCreating(function (User $user) {
            $skills = Skill::inRandomOrder()->limit(3)->get(); // ランダムに3つのスキルを取得
            $user->teachableSkills()->attach($skills); // ユーザーが教えられるスキルとして関連付ける
        });
    }
}
