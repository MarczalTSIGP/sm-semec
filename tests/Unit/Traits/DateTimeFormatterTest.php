<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Edict;

class DateTimeFormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $edict = Edict::factory()->make();

        $edict->started_at = '13/08/2020 01:54';
        $edict->ended_at = '07/08/2020 01:54';
        $edict->save();

        $edict->refresh();

        $this->assertEquals($edict->started_at->format('d/m/Y H:i'), '13/08/2020 01:54');
        $this->assertEquals($edict->ended_at->format('d/m/Y H:i'), '07/08/2020 01:54');
    }
}
