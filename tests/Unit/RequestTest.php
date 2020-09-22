<?php

namespace Tests\Unit;

use App\Models\CarType;
use App\Models\Contract;
use App\Models\ProvinceAirport;
use App\Models\Request;
use App\Models\RequestCustomer;
use App\Models\RequestDestination;
use App\Models\User;
use Tests\TestCase as TestCase;

class RequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new Request();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->request);
    }

    public function testTableName()
    {
        $this->assertEquals('requests', $this->request->getTable());
    }

    public function testFillable()
    {
        $this->assertEquals([
            'car_type_id',
            'province_airport_id',
            'pickup',
            'user_id',
            'status',
            'budget',
            'note',
        ], $this->request->getFillable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->request->getKeyName());
    }

    public function testUserRelation()
    {
        $this->testBelongToRelation(
            User::class,
            'user_id',
            'id',
            $this->request->user()
        );
    }

    public function testCarTypeRelation()
    {
        $this->testBelongToRelation(
            CarType::class,
            'car_type_id',
            'id',
            $this->request->carTypes()
        );
    }

    public function testProvinceAirportRelation()
    {
        $this->testBelongToRelation(
            ProvinceAirport::class,
            'province_airport_id',
            'id',
            $this->request->provinceAirports()
        );
    }

    public function testRequestDestinationRelation()
    {
        $this->testHasManyRelation(
            RequestDestination::class,
            'request_id',
            $this->request->requestDestinations()
        );
    }

    public function testRequestCustomerRelation()
    {
        $this->testHasOneRelation(
            RequestCustomer::class,
            'request_id',
            $this->request->requestCustomer()
        );
    }

    public function testContractRelation()
    {
        $this->testHasOneRelation(
            Contract::class,
            'request_id',
            $this->request->contract()
        );
    }
}
