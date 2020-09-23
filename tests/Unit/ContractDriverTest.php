<?php

namespace Tests\Unit;

use App\Models\Contract;
use App\Models\ContractDriver;
use Tests\TestCase;

class ContractDriverTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $contractDriver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contractDriver = new ContractDriver();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->contractDriver);
    }

    public function testTableName()
    {
        $this->assertEquals('contract_drivers', $this->contractDriver->getTable());
    }

    public function testFillable()
    {
        $this->assertEquals([
            'name',
            'phone',
            'contract_id',
            'car_plate',
            'avatar',
            'car_name',
        ], $this->contractDriver->getFillable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->contractDriver->getKeyName());
    }

    public function testContractRelation()
    {
        $this->testBelongToRelation(
            Contract::class,
            'contract_id',
            'id',
            $this->contractDriver->contract()
        );
    }
}
