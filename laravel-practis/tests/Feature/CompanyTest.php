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
        Company::factory()->count(20)->create();
        $this->user = User::factory()->create();
    }

    public function test_company_index(): void
    {
        $url = route('companies.index');
        $response = $this->get($url);

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $response->assertRedirect('/login');

        $response = $this->actingAs($this->user)->get($url);

        $response->assertStatus(200);

        $companies = $response->original['companies'];

        $this->assertCount(15, $companies);
    }

    public function test_company_create(): void
    {
        $url = route('companies.create');

        $response = $this->get($url);

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $response->assertRedirect('/login');

        $response = $this->actingAs($this->user)->get($url);

        $response->assertStatus(200);
    }
}
