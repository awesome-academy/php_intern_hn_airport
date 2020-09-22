<?php

namespace Tests\Unit;

use App\Models\Province;
use App\Models\ProvinceAirport;
use App\Models\Request;
use Tests\TestCase;

class ProvinceAirportTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $provinceAirport;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provinceAirport = new ProvinceAirport();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->provinceAirport);
    }

    public function testTableName()
    {
        $this->assertEquals('province_airports', $this->provinceAirport->getTable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->provinceAirport->getKeyName());
    }

    public function testProvinceRelation()
    {
        $this->testBelongToRelation(
            Province::class,
            'province_id',
            'id',
            $this->provinceAirport->provinces()
        );
    }

    public function testRequestRelation()
    {
        $this->testHasManyRelation(
            Request::class,
            'province_airport_id',
            $this->provinceAirport->requests()
        );
    }
}
