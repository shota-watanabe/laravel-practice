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

    public function test_index(): void
    {
        $url = route('companies.index');

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->get($url)->assertRedirect('/login');

        $response = $this->actingAs($this->user)->get($url);

        $response->assertStatus(200);
    }

    public function test_create(): void
    {
        $url = route('companies.create');

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->get($url)->assertRedirect('/login');

        $this->actingAs($this->user)->get($url)->assertStatus(200);
    }

    public function test_store(): void
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

    public function test_edit(): void
    {
        $url = route('companies.edit', $this->companies->random()->first()->id);

        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        $this->actingAs($this->user)->get($url)->assertStatus(200);

    }

    public function test_update()
    {
        $company = $this->companies->random()->first();

        $company_name = $this->faker->company;

        $url = route('companies.update', $company->id);

        // Guest のときは、login にリダイレクトされる
        $this->put($url, [
            'name' => $company_name,
        ])->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)
            ->put($url, [
                'name' => $company_name,
            ]);

        $response->assertStatus(302);

        // 更新後 companies.show にリダイレクトされる
        $response->assertRedirect(route('companies.show', compact('company')));

        $this->assertDatabaseHas('companies', [
            'name' => $company_name,
        ]);
    }

    public function test_destroy()
    {
        $company = $this->companies->random()->first();

        $url = route('companies.destroy', $company->id);

        // Guest のときは、login にリダイレクトされる
        $this->delete($url)->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->delete($url);

        $response->assertStatus(302);

        // 削除後 companies.index にリダイレクトされる
        $response->assertRedirect(route('companies.index'));

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);
    }
}
