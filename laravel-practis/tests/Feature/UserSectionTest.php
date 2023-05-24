<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSectionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     */

    public function setUp(): void
    {
        parent::setUp();
        $this->companies = Company::factory()->create();
        $this->sections = Section::factory()->count(100)->create();
        $this->user = User::factory()->create();
    }

    public function test_store(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();
        $random_user_id = $company->users->random()->first()->id;

        $url = route('companies.sections.user_sections.store', ['company' => $company->id, 'section' => $section->id]);

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->post($url, [
            'user_id' => $random_user_id,
            'section_id' => $section->id,
        ])->assertRedirect(route('login'));

        $this->actingAs($this->user)
            ->post($url, [
                'user_id' => $company->users->random()->first()->id,
                'section_id' => $section->id,
            ])->assertStatus(302);

        $this->assertDatabaseHas('user_section', [
            'user_id' => $random_user_id,
            'section_id' => $section->id
        ]);
    }
}
