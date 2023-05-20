<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->companies = Company::factory()->count(20)->create();
        $this->user = User::factory()->create();
    }

    public function test_company_index(): void
    {
        $url = route('companies.index');

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->get($url)->assertRedirect('/login');

        $response = $this->actingAs($this->user)->get($url);

        $response->assertStatus(200);

        $companies = $response->original['companies'];

        $this->assertCount(15, $companies);
    }

    public function test_company_create(): void
    {
        $url = route('companies.create');

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->get($url)->assertRedirect('/login');

        $this->actingAs($this->user)->get($url)->assertStatus(200);
    }

    public function test_company_store(): void
    {
        $url = route('companies.store');
        $company_name = $this->faker->company;

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->post($url, [
            'name' => $company_name,
        ])->assertRedirect(route('login'));

        $this->actingAs($this->user)
            ->post($url, [
                'name' => $company_name,
            ])->assertStatus(302);;

        $this->assertDatabaseHas('companies', [
            'name' => $company_name,
        ]);

        // バリデーション
        $response = $this->actingAs($this->user)
            ->post($url, [
                'name' => null,
            ]);

        $validation = 'nameは必ず指定してください。';
        $this->get(route('companies.create'))->assertSee($validation);
    }

    public function test_show(): void
    {
        $url = route('companies.show', $this->companies->random()->first()->id);
        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        $this->actingAs($this->user)->get($url)->assertStatus(200);

        // 存在しない ID のときは、404 になる
        $this->actingAs($this->user)->get(route('companies.show', 9999))->assertStatus(404);
    }
}
