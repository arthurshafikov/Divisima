<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelloCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello';

    protected $adminname = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simple Hello Command';

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
        if($this->adminname === ''){
            $this->adminname = $this->ask('What is your name?','Admin');
            $this->info('Hello '. $this->adminname);
        } else {
            $this->info('Hello '. $this->adminname);
        }
        return 0;
    }
}
