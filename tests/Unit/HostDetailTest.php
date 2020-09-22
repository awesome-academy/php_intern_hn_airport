<?php

namespace Tests\Unit;

use App\Models\CarType;
use App\Models\HostDetail;
use App\Models\Province;
use App\Models\User;
use Tests\TestCase;

class HostDetailTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $hostDetail;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hostDetail = new HostDetail();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->hostDetail);
    }

    public function testTableName()
    {
        $this->assertEquals('host_details', $this->hostDetail->getTable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->hostDetail->getKeyName());
    }

    public function testFillable()
    {
        $this->assertEquals([
            'province_id',
            'car_type_id',
            'user_id',
            'quantity',
        ], $this->hostDetail->getFillable());
    }

    public function testUserRelation()
    {
        $this->testBelongToRelation(
            User::class,
            'user_id',
            'id',
            $this->hostDetail->users()
        );
    }

    public function testProvinceRelation()
    {
        $this->testBelongToRelation(
            Province::class,
            'province_id',
            'id',
            $this->hostDetail->provinces()
        );
    }

    public function testCarTypeRelation()
    {
        $this->testBelongToRelation(
            CarType::class,
            'car_type_id',
            'id',
            $this->hostDetail->carTypes()
        );
    }
}
