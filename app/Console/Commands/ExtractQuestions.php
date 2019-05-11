<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ExtractQuestions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract questions from pastpapers on queue';

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
        return $this->call('queue:work', [
            '--stop-when-empty' => null,
        ]);
    }
}
