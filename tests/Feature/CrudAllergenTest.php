<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Allergen;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudAllergenTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function userCanSeeAllAllergensOrderByDateCreation()
    {
        //Given 4 allergens in db
        $meal1 = factory(Allergen::class)->create(['created_at' => now()->subDays(4)]);
        $meal2 = factory(Allergen::class)->create(['created_at' => now()->subDays(3)]);
        $meal3 = factory(Allergen::class)->create(['created_at' => now()->subDays(2)]);
        $meal4 = factory(Allergen::class)->create(['created_at' => now()->subDays(1)]);

        //Make get request to api/allergens
        $response = $this->getJson('api/allergens');

        //Then we get 4 allergens order by date creation
        $response->assertJson([
            'meta' => ['total' => 4]
        ]);
        $response->assertJsonStructure([
            'data','links' => ['first','last','next','prev']
        ]);

        $this->assertEquals(
            $meal4->name,
            $response->json()["data"][0]["name"]
        );
    }

    /** @test */
    public function userCanSeeOneAllergen()
    {
        //Given 1 ingredient in db
        $ingredient = factory(Allergen::class)->create();

        //Make get request to 'api/allergens/{allergens->id}'
        $response = $this->getJson(route('api.allergens.show',$ingredient->id));

        //Assert that the response has a successful status code (statusCode >= 200 && code <= statusCode)
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name'
            ]
        ]);
    }

    /** @test */
    public function userCanCreateOneAllergen()
    {
        //Make post request to allergens
        $response = $this->postJson(route('api.allergens.store'),[
                'name' => 'Alérgeno',
            ]
        );
        // Assert that response and the db has the given data
        $response->assertStatus(201);
        $response->assertJson([
            'name' => 'Alérgeno'
        ]);
        $this->assertDatabaseHas('allergens',[
            'name' => 'Alérgeno'
        ]);
    }

    /** @test */
    public function userCanUpdateMeal()
    {
        //Given 1 allergens in db
        $ingredient = factory(Allergen::class)->create([
            'id'          => '1',
            'name'        => 'Alérgeno 1',
        ]);

        $this->assertDatabaseHas('allergens',[
            'name' => 'Alérgeno 1',
        ]);

        //Data to update allergens
        $data = [
            'name' => 'Alérgeno peligrosísimo',
        ];

        //Make put request to 'api/allergens/{allergens->id}'
        $response = $this->putJson(route('api.allergens.update',$ingredient->id), $data);

        $response->assertSuccessful();
        $response->assertJson([
            'name'         => 'Alérgeno peligrosísimo',
        ]);
    }

    /** @test */
    public function userCanDeleteAllergen()
    {
        //Given 1 allergens in db
        $allergen = factory(Allergen::class)->create();

        //Make delete request to 'allergens/{allergens}'
        $response = $this->deleteJson(route('api.allergens.delete',$allergen));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('allergens',[$allergen->id]);
    }
}
