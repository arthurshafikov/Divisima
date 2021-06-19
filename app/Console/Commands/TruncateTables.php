<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TruncateTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear {--table= : Table in this option will be truncate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates all the tables in database or truncate one table in option (except migration)';

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
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if ($this->option('table') && \Schema::hasTable($this->option('table'))) {
            \DB::table($this->option('table'))->truncate();
            $this->info('Successfully truncated table ' . $this->option('table'));
            return 0;
        } elseif ($this->option('table')) {
            $this->error('Table ' . $this->option('table') . ' does not exists!');
            return 0;
        }

        $tables = \DB::select('SHOW TABLES');

        $bar = $this->output->createProgressBar(count($tables));

        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');

        foreach ($tables as $table) {
            $bar->advance();
            if ($table->Tables_in_divisima === 'migrations') {
                continue;
            }
            \DB::table($table->Tables_in_divisima)->truncate();
        }
        $bar->finish();
        $this->info(PHP_EOL . 'All tables truncated!');
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return 0;
    }
}
