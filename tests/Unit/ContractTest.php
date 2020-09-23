<?php

namespace Tests\Unit;

use App\Models\Contract;
use App\Models\ContractDriver;
use App\Models\Request;
use App\Models\User;
use Tests\TestCase;

class ContractTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $contract;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contract = new Contract();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->contract);
    }

    public function testTableName()
    {
        $this->assertEquals('contracts', $this->contract->getTable());
    }

    public function testFillable()
    {
        $this->assertEquals([
            'request_id',
            'supplier_id',
            'pickup',
            'status',
        ], $this->contract->getFillable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->contract->getKeyName());
    }

    public function testUserRelation()
    {
        $this->testBelongToRelation(
            User::class,
            'supplier_id',
            'id',
            $this->contract->users()
        );
    }

    public function testRequestRelation()
    {
        $this->testBelongToRelation(
            Request::class,
            'request_id',
            'id',
            $this->contract->request()
        );
    }

    public function testContractDriverRelation()
    {
        $this->testHasOneRelation(
            ContractDriver::class,
            'contract_id',
            $this->contract->contractDriver()
        );
    }
}
