<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $role;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = new Role();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->role);
    }

    public function testTableName()
    {
        $this->assertEquals('roles', $this->role->getTable());
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->role->getKeyName());
    }

    public function testRoleRelation()
    {
        $this->testHasManyRelation(
            User::class,
            'role_id',
            $this->role->users()
        );
    }
}
