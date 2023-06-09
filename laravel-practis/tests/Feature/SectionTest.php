<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
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
        $this->companies = Company::factory()->count(2)->create();
        $this->sections = Section::factory()->count(100)->create();
        $this->user = User::factory()->create();
    }

    public function test_index(): void
    {
        $url = route('companies.show', $this->companies->first());

        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->get($url);

        $response->assertStatus(200);

        $sections = $response->original['sections'];

        $this->assertCount(15, $sections);
    }

    public function create(): void
    {
        $company = $this->companies->first();

        $other_company = $this->companies->last();

        $url = route('companies.sections.create', $company);
        $other_company_url = route('companies.sections.create', $other_company);

        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        // 他人の会社の ID ときは、403になる
        $this->actingAs($this->user)->get($other_company_url)->assertStatus(403);

        $this->actingAs($this->user)->get($url)->assertStatus(200);
    }

    public function test_store(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $other_company = $this->companies->last();
        $other_section = $other_company->sections->first();

        $url = route('companies.sections.store', ['company' => $company, 'section' => $section]);
        $other_company_url = route('companies.sections.store', ['company' => $other_company, 'section' => $other_section]);
        $section_name = $this->faker->realText();

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->post($url, [
            'company_id' => $company->id,
            'name' => $section_name,
        ])->assertRedirect(route('login'));

        // 他人の会社の ID ときは、403になる
        $this->authenticated_store_section($other_company, $this->faker->realText(), $other_company_url)
             ->assertStatus(403);

        $this->authenticated_store_section($company, $section_name, $url)
             ->assertStatus(302);

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
        $this->get(route('companies.sections.create', $company))->assertSee($validation);

        $this->actingAs($this->user)
            ->post($url, [
                'company_id' => $company->id,
                'name' => str_repeat('a', 256),
            ]);

        $validation = 'nameは、255文字以下で指定してください。';
        $this->get(route('companies.sections.create', $company))->assertSee($validation);

        $this->actingAs($this->user)
            ->post($url, [
                'name' => $section_name,
            ]);

        $validation = '部署名は既に存在しています。';
        $this->get(route('companies.sections.create', $company))->assertSee($validation);

    }

    public function test_show(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $other_company = $this->companies->last();
        $other_section = $other_company->sections->first();

        $url = route('companies.sections.show', ['company' => $company, 'section' => $section]);
        $other_company_url = route('companies.sections.show', ['company' => $other_company, 'section' => $other_section]);

        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        // 他人の会社の ID ときは、403になる
        $this->actingAs($this->user)->get($other_company_url)->assertStatus(403);

        $this->actingAs($this->user)->get($url)->assertStatus(200);
    }

    public function test_edit(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $url = route('companies.sections.edit', ['company' => $company, 'section' => $section]);

        // Guest のときは、login にリダイレクトされる
        $this->get($url)->assertRedirect(route('login'));

        $this->actingAs($this->user)->get($url)->assertStatus(200);
    }

    public function test_update(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $other_company = $this->companies->last();
        $other_section = $other_company->sections->first();

        $url = route('companies.sections.update', ['company' => $company, 'section' => $section]);
        $other_company_url = route('companies.sections.update', ['company' => $other_company, 'section' => $other_section]);
        $section_name = $this->faker->realText();

        // 認証されていない場合、ログイン画面にリダイレクトされること
        $this->put($url, [
            'name' => $section_name,
        ])->assertRedirect(route('login'));

        // 他人の会社の ID ときは、403になる
        $this->actingAs($this->user)
            ->put($other_company_url, [
                'name' => $section_name,
            ])->assertStatus(403);;

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
        $this->get(route('companies.sections.edit', ['company' => $company, 'section' => $section]))->assertSee($validation);

        $this->actingAs($this->user)
            ->put($url, [
                'name' => str_repeat('a', 256),
            ]);

        $validation = 'nameは、255文字以下で指定してください。';
        $this->get(route('companies.sections.edit', ['company' => $company, 'section' => $section]))->assertSee($validation);

        $section_name = $this->faker->word();

        $url = route('companies.sections.store', ['company' => $company, 'section' => $section]);
        $this->authenticated_store_section($company, $section_name, $url);
        $url = route('companies.sections.update', ['company' => $company, 'section' => $section]);

        $validation = '部署名は既に存在しています。';

        $this->actingAs($this->user)
            ->put($url, [
                'name' => $section_name,
            ]);

        $this->get(route('companies.sections.edit', ['company' => $company, 'section' => $section]))->assertSee($validation);
    }

    public function test_destroy(): void
    {
        $company = $this->companies->first();
        $section = $company->sections->first();

        $other_company = $this->companies->last();
        $other_section = $other_company->sections->first();

        $url = route('companies.sections.destroy', ['company' => $company, 'section' => $section]);
        $other_company_url = route('companies.sections.update', ['company' => $other_company, 'section' => $other_section]);

        // Guest のときは、login にリダイレクトされる
        $this->delete($url)->assertRedirect(route('login'));

        // 他人の会社の ID ときは、403になる
        $this->actingAs($this->user)->delete($other_company_url)->assertStatus(403);

        $response = $this->actingAs($this->user)->delete($url);

        $response->assertStatus(302);

        // 削除後 companies.show にリダイレクトされる
        $response->assertRedirect(route('companies.show', $company));

        $this->assertDatabaseMissing('sections', [
            'id' => $section->id,
        ]);

        $this->assertDatabaseMissing('user_section', [
            'user_id' => $this->user->id,
            'section_id' => $section->id
        ]);

    }

    public function authenticated_store_section($company, $section_name, $url): TestResponse
    {
        $response = $this->actingAs($this->user)
            ->post($url, [
                'company_id' => $company->id,
                'name' => $section_name,
            ]);

        return $response;
    }

}
