<?php

namespace App\Console\Commands\Populate;

use Illuminate\Console\Command;
use DB;
use App\Models\Role;

class Roles extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:roles
    {--json} populate from a json file locate at database/data/roles.json
    {--clear} erase servants and relationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate roles';

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
        if ($this->option('clear')) {
            DB::table('roles')->delete();
        }

        if ($this->option('json')) {
            $this->populateFromJSON();
            return;
        }

        $this->populateFromFaker();
    }

    private function populateFromFaker(): void
    {
        if (\App::environment('production')) {
            $this->info('This task can not be run in production because it will erase de database');
            return;
        }

        $this->info('Populate roles');
        DB::table('roles')->delete();

        Role::factory()->count(4)->create();
    }

    private function populateFromJSON(): void
    {
        $this->info('Populate roles from ./database/data/roles.json');
        $jsonPath = base_path('./database/data/roles.json');
        $jsonString = file_get_contents($jsonPath);

        if ($jsonString === false) {
            $this->info('File roles.json not found');
            $this->info('You need to create roles.json file in database/data folder');
            return;
        }

        $jsonDecoded = json_decode($jsonString);
        $roles = $jsonDecoded->roles;

        foreach ($roles as $data) {
            Role::updateOrCreate([
              'name' => $data->name
            ]);
        }
    }
}
