<?php

namespace App\Console\Commands\Populate;

use Illuminate\Console\Command;
use DB;
use App\Models\Edict;
use App\Models\Unit;
use App\Models\Pdf;
use App\Models\EdictUnit;

class Edicts extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
    protected $signature = 'populate:edicts';

  /**
   * The console command description.
   *
   * @var string
   */
    protected $description = 'Populate edicts';

  /**
   * Create a new command instance.
   *
   * @return void
   */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (\App::environment('production')) {
            $this->info('This task can not be run in production because it will erase de database');
            return;
        }

        $this->info('Populate edicts');
        DB::table('edicts')->delete();

        $currentDay = now()->day;
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $nextDay = now()->addDays()->day;

        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;
            $startedAt = "{$currentDay}/{$currentMonth}/{$year} 00:00";
            $endedAt = "{$nextDay}/{$currentMonth}/{$year} 23:59";

            $edict = Edict::factory()->create(['started_at' => $startedAt, 'ended_at' => $endedAt]);

            $edict->pdfs()->save(Pdf::factory()->make(['edict_id' => $edict->id]));
            $edict->pdfs()->save(Pdf::factory()->make(['edict_id' => $edict->id]));

            Unit::inRandomOrder()->limit(rand(1, 5))->get()->each(function ($unit) use ($edict) {
                EdictUnit::create(['edict_id' => $edict->id,
                                   'unit_id' => $unit->id,
                                   'number_vacancies' => rand(1, 20),
                                   'type_of_vacancy' => 'registered']);
            });
        }
    }
}
