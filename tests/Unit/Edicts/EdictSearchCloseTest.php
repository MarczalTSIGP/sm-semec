<?php

namespace Tests\Unit\Edicts;

use App\Models\Edict;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EdictSearchCloseTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @var array */
    protected $edicts;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/1 - Permuta',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/2 - Remoção',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/3 - Informativo',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/4 - Permuta',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2019/5 - Remoção',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/1 - Permuta',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/2 - Remoção',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/3- Permuta',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/4 - Permuta',
            'ended_at' => '10/11/2020 13:00']);
        $this->edicts[] = Edict::factory()->create(['title' => 'Edital 2020/5 - Permuta',
            'ended_at' => '10/11/2020 13:00']);
    }

    public function testSearchBySpecifiedName(): void
    {
        $searchResult = Edict::searchClose('Edital 2019/1 - Permuta');
        $expectedEdicts = collect([$this->edicts[0]]);

        $this->assertEquals(1, $searchResult->count());
        $this->assertEmpty($searchResult->diff($expectedEdicts));
    }

    public function testSearchContainsSyllable(): void
    {
        $searchResult = Edict::searchClose('ção');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(3, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchForYear(): void
    {
        $searchResult = Edict::searchClose('2019');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(5, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }

    public function testSearchEmpty(): void
    {
        $searchResult = Edict::searchClose('');
        $expectedEdicts = collect($this->edicts);

        $this->assertEquals(10, $searchResult->count());
        $this->assertEmpty($searchResult->diff(collect($expectedEdicts)));
    }
}
