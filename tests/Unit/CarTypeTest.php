<?php

namespace Tests\Unit;

use App\Models\CarType;
use App\Models\HostDetail;
use App\Models\Request;
use Tests\TestCase;

class CarTypeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $carType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->carType = new CarType();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->carType);
    }

    public function testTableName()
    {
        $this->assertEquals('car_types', $this->carType->getTable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->carType->getKeyName());
    }

    public function testRequestRelation()
    {
        $this->testHasManyRelation(
            Request::class,
            'car_type_id',
            $this->carType->requests()
        );
    }

    public function testHostDetailRelation()
    {
        $this->testHasManyRelation(
            HostDetail::class,
            'car_type_id',
            $this->carType->hostDetails()
        );
    }
}
