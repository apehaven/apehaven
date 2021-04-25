<?php

namespace Tests\Feature\Nova;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tipoff\Authorization\Models\User;

class DashboardResourceTest extends TestCase
{
    public function getUserByRole($role)
    {
        return User::role($role)->first() ?: User::factory()->create()->assignRole($role);
    }

    /**
     * @dataProvider dataProviderForIndexByRole
     * @test
     */
    public function index(string $role, bool $hasAccess)
    {
        $this->actingAs($this->getUserByRole($role));
        $hasAccess ? $this->get('/admin')->assertStatus(200) : $this->get('/admin')->assertStatus(403);
        $hasAccess ? $this->get('/admin/dashboards/')->assertStatus(200) : $this->get('/admin/dashboards/')->assertStatus(403);
    }

    public function dataProviderForIndexByRole()
    {
        return [
            'Admin' => ['Admin', true],
            'Owner' => ['Owner', true],
            'Executive' => ['Executive', true],
            'Staff' => ['Staff', true],
            'Former Staff' => ['Former Staff', false],
            'Customer' => ['Customer', false],
        ];
    }
}
