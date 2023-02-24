<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteTokenDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:clear_token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Token Daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Clear Token Daily Start');
        try {
            Log::channel('debug')->info('Clear Token Daily Start');
            $this->info('Clear Token Daily End Successfully');
            Log::channel('debug')->info('Clear Token Daily End Successfully');
        } catch (\Exception $e) {
            Log::channel('debug')->info('Clear Token Daily End Failed');
            $this->error('Clear Token Daily End Failed');
            $this->error($e->getMessage());
        }
        return Command::SUCCESS;
    }
}
