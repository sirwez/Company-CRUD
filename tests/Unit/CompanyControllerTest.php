<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function testIndex()
    {
        $user = \App\Models\User::create([
            'name' => 'Weslley',
            'email' => 'weslley.aquinog12@gmail.com',
            'password' => bcrypt('Weslley12#'),
        ]);

        $response = $this->actingAs($user)
            ->get('/login');

        $response->assertStatus(302);
    }

    /** @test */
    public function it_returns_the_companies_index_page()
    {
        $response = $this->get(route('companies.index'));
        $response->assertOk();
        $response->assertViewIs('companies.index');
    }

    /** @test */
    public function it_returns_the_company_create_page()
    {
        $response = $this->get(route('companies.create'));
        $response->assertOk();
        $response->assertViewIs('companies.create');
    }

    /** @test */
    public function it_creates_a_new_company()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
        ];

        $response = $this->post(route('companies.store'), $data);
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', $data);
    }

    /** @test */
    public function it_shows_a_company()
    {
        $company = Company::factory()->create();

        $response = $this->get(route('companies.show', $company));
        $response->assertOk();
        $response->assertViewIs('companies.show');
        $response->assertViewHas('company', $company);
    }

    /** @test */
    public function it_returns_the_company_edit_page()
    {
        $company = Company::factory()->create();

        $response = $this->get(route('companies.edit', $company));
        $response->assertOk();
        $response->assertViewIs('companies.edit');
        $response->assertViewHas('company', $company);
    }

    /** @test */
    public function it_updates_a_company()
    {
        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
        ];

        $response = $this->put(route('companies.update', $company), $data);
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', $data);
    }

    /** @test */
    public function it_deletes_a_company()
    {
        $company = Company::factory()->create();

        $response = $this->delete(route('companies.destroy', $company));
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }
}
