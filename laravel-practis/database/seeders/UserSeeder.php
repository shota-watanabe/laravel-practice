<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create(); // admin
        User::factory()->count(98)->create(); // その他 100 件作る

        // モデルのデフォルト値の一部をオーバーライド
        User::factory()->create([
            'name' => 'Shota Watanabe',
        ]);

        // モデルのインスタンス化
        $user = User::factory()->make([
            'name' => 'PRUM Watanabe'
        ]);
        $user->save();
    }
}
