<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
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
        $response = $this->get('/companies');

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $response->assertRedirect('/login');

        $response = $this->actingAs($this->user)->get('/companies');

        $response->assertStatus(200);

        $companies = $response->original['companies'];
        $this->assertCount(15, $companies);
    }
}
