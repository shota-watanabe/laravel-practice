<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SectionTest extends TestCase
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

    public function test_index(): void
    {
        $url = route('companies.show', $this->companies->first()->id);
        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->get($url);

        $response->assertStatus(200);

        $sections = $response->original['sections'];

        $this->assertCount(15, $sections);
    }

    public function test_store(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $url = route('companies.sections.store', ['company' => $company->id, 'section' => $section->id]);
        $section_name = $this->faker->word();

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->post($url, [
            'company_id' => $company->id,
            'name' => $section_name,
        ])->assertRedirect(route('login'));

        $this->actingAs($this->user)
            ->post($url, [
                'company_id' => $company->id,
                'name' => $section_name,
            ])->assertStatus(302);;

        $this->assertDatabaseHas('sections', [
            'name' => $section_name,
        ]);

        // バリデーション
        $this->actingAs($this->user)
            ->post($url, [
                'company_id' => $company->id,
                'name' => null,
            ]);

        $validation = 'nameは必ず指定してください。';
        $this->get(route('companies.sections.create', $company->id))->assertSee($validation);

        $this->actingAs($this->user)
            ->post($url, [
                'company_id' => $company->id,
                'name' => str_repeat('a', 256),
            ]);

        $validation = 'nameは、255文字以下で指定してください。';
        $this->get(route('companies.sections.create', $company->id))->assertSee($validation);

    }

    public function test_edit(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $url = route('companies.sections.edit', ['company' => $company->id, 'section' => $section->id]);

        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        $this->actingAs($this->user)->get($url)->assertStatus(200);
    }

    public function test_update(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $url = route('companies.sections.update', ['company' => $company->id, 'section' => $section->id]);
        $section_name = $this->faker->word();

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->put($url, [
            'name' => $section_name,
        ])->assertRedirect(route('login'));

        $this->actingAs($this->user)
            ->put($url, [
                'name' => $section_name,
            ])->assertStatus(302);;

        $this->assertDatabaseHas('sections', [
            'name' => $section_name,
        ]);

        // バリデーション
        $this->actingAs($this->user)
            ->put($url, [
                'name' => null,
            ]);

        $validation = 'nameは必ず指定してください。';
        $this->get(route('companies.sections.edit', ['company' => $company->id, 'section' => $section->id]))->assertSee($validation);

        $this->actingAs($this->user)
            ->put($url, [
                'name' => str_repeat('a', 256),
            ]);

        $validation = 'nameは、255文字以下で指定してください。';
        $this->get(route('companies.sections.edit', ['company' => $company->id, 'section' => $section->id]))->assertSee($validation);

    }

}
