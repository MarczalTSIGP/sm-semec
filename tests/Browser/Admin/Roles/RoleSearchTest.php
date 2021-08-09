<?php

namespace Tests\Unit\Roles;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleSearchTest extends TestCase
{
    use DatabaseTransactions;

    /** @var array */
    protected $roles;

    public function setUp(): void
    {
        parent::setUp();
        $this->roles[] = Role::factory()->create(['name' => 'Professor']);
        $this->roles[] = Role::factory()->create(['name' => 'Educador(a) Infantil ']);
        $this->roles[] = Role::factory()->create(['name' => 'Supervisor(a) Pedagógico(a)']);
    }

    public function testSearchBySpecifiedName(): void
    {
        $searchResult = Role::search('Professor');
        $expectedCategories = collect([$this->roles[0]]);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedCategories));
    }

    public function testSearchContainsSyllable(): void
    {
        $searchResult = Role::search('Ped');
        $expectedCategories = collect($this->roles);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedCategories)));
    }

    public function testSearchEmpty(): void
    {
        $searchResult = Role::search('');
        $expectedCategories = collect($this->roles);

        $this->assertEquals(3, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedCategories)));
    }
}
