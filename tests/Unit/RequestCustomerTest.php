<?php

namespace Tests\Unit;

use App\Models\Request;
use App\Models\RequestCustomer;
use Tests\TestCase;

class RequestCustomerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $requestCustomer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->requestCustomer = new RequestCustomer();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->requestCustomer);
    }

    public function testTableName()
    {
        $this->assertEquals('request_customers', $this->requestCustomer->getTable());
    }

    public function testFillable()
    {
        $this->assertEquals([
            'name',
            'phone',
            'request_id',
        ], $this->requestCustomer->getFillable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->requestCustomer->getKeyName());
    }

    public function testRequestRelation()
    {
        $this->testBelongToRelation(
            Request::class,
            'request_id',
            'id',
            $this->requestCustomer->request()
        );
    }
}
