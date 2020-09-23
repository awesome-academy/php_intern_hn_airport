<?php

namespace Tests\Unit;

use App\Models\HostDetail;
use App\Models\Province;
use App\Models\ProvinceAirport;
use Tests\TestCase;

class ProvinceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $province;

    protected function setUp(): void
    {
        parent::setUp();
        $this->province = new Province();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->province);
    }

    public function testTableName()
    {
        $this->assertEquals('provinces', $this->province->getTable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->province->getKeyName());
    }

    public function testHostDetailRelation()
    {
        $this->testHasManyRelation(
            HostDetail::class,
            'province_id',
            $this->province->hostDetails()
        );
    }

    public function testProvinceAirportRelation()
    {
        $this->testHasManyRelation(
            ProvinceAirport::class,
            'province_id',
            $this->province->provinceAirports()
        );
    }
}
