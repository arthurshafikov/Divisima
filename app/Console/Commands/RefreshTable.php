<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RefreshTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes table and seed it with {table}Seeder class if it exists';

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
     * @return int
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $table = $this->argument('table');
        if (!\Schema::hasTable($table)) {
            $this->error('Table ' . $table . ' does not exists!');
            return 0;
        }
        $this->info('Table ' . $table . ' was found...');
        $seederName = ucfirst($table) . 'TableSeeder';

        \DB::table($table)->truncate();
        $this->info('Table ' . $table . ' had been cleared...');
        $this->call('db:seed', ['--class' => $seederName]);
        return 0;
    }
}
