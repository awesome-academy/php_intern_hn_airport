<?php

namespace Tests\Unit;

use App\Models\Request;
use App\Models\RequestDestination;
use Tests\TestCase;

class RequestDestinationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $requestDestination;

    protected function setUp(): void
    {
        parent::setUp();
        $this->requestDestination = new RequestDestination();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->requestDestination);
    }

    public function testTableName()
    {
        $this->assertEquals('request_destinations', $this->requestDestination->getTable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->requestDestination->getKeyName());
    }

    public function testRequestRelation()
    {
        $this->testBelongToRelation(
            Request::class,
            'request_id',
            'id',
            $this->requestDestination->requests()
        );
    }
}
