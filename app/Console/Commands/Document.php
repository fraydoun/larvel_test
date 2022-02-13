<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Document extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate document api.';

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
        exec('apidoc -i app/Http/ -o public/apidoc');
    }
}
