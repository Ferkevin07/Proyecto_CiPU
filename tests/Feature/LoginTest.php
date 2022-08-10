<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_products()
    {
        $response = $this->get('http://localhost:8000/');

        $response->assertStatus(200);
    }

    /** @test Login */
    public function check_auth()
    {
        $response = $this->get('http://localhost:8000/api/products');
            
        $response->assertStatus(200);
    }

    /** @test login 3*/
    public function test_product()
    {
        $response = $this->json('GET', 'http://localhost:8000/api/products/5', [], ['Authorization'=>'eyJ0eXAiOiJ'] );
        $response->assertStatus(200)
                ->assertExactJson([
                    'id'=>5,
                    'name'=>'Prof.',
                    'stock'=>32,
                    'description'=>'Ea autem cum numquam eum excepturi eum.',
                    'price_min'=>16.61,
                    'price_max'=>62.10,
                    'state'=>true,
                    'type_id'=>1,
                    'created_at'=>'2022-08-10 01:48:18',
                    'updated_at'=>'2022-08-10 01:48:18'
                ]);
    }

    
}
