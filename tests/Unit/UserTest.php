<?php

namespace Tests\Unit;

use App\Models\Contract;
use App\Models\HostDetail;
use App\Models\Request;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->user);
    }

    public function testTableName()
    {
        $this->assertEquals('users', $this->user->getTable());
    }

    public function testFillable()
    {
        $this->assertEquals([
            'name', 
            'email', 
            'password', 
            'phone', 
            'avatar', 
            'status', 
            'role_id',
        ], $this->user->getFillable());
    }

    public function testHidden()
    {
        $this->assertEquals([
            'password', 
            'remember_token',
        ], $this->user->getHidden());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->user->getKeyName());
    }

    public function testRoleRelation()
    {
        $this->testBelongToRelation(
            Role::class,
            'role_id',
            'id',
            $this->user->roles()
        );
    }

    public function testRequestRelation()
    {
        $this->testHasManyRelation(
            Request::class,
            'user_id',
            $this->user->requests()
        );
    }

    public function testContractRelation()
    {
        $this->testHasManyRelation(
            Contract::class,
            'supplier_id',
            $this->user->contracts()
        );
    }

    public function testHostDetailRelation()
    {
        $this->testHasManyRelation(
            HostDetail::class,
            'user_id',
            $this->user->hostDetails()
        );
    }
}
