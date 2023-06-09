<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * モデルのデフォルト状態の定義.
     * ファクトリを使用してモデルを作成するときに適用する必要がある属性値のデフォルトセットを返す.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => function () {
                return Company::first()->id;
            }, // company_id 追加
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // アドミン用のファクトリ定義を追加
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Kosuke Shibuya',
            'email' => 'admin@example.com',
        ]);
    }
}
