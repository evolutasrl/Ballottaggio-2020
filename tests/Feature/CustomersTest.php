<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Portfolio;

class CustomersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations {
        runDatabaseMigrations as baseRunDatabaseMigrations;
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->baseRunDatabaseMigrations();
        $this->seed();
    }

    public function testCanSeeCustomers() 
    {
        $user = User::first();
        $customers = Portfolio::where('nome','olbia')->first();
        $response = $this->actingAs($user)->get('/crm/customers');
        $response->assertSee($customers->first()->nome);
    }

    public function testCantSeeCustomersInNotAccessiblePortfolio() 
    {
        $user = User::first();
        $porfolioSecret = Portfolio::where('nome','secret')->first();
        $customers = $porfolioSecret->customers;
        $response = $this->actingAs($user)->get('/crm/customers');
        $response->assertDontSee($customers->first()->nome);
    }

    public function testCanSeeCustomersWithoutPortfolio() 
    {
        $user = User::first();
        $customers = Customer::doesntHave('portfolios')->get();
        $response = $this->actingAs($user)->get('/crm/customers');
        $response->assertSee($customers->first()->nome);
    }


}
