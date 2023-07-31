<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table = $this->ask('Which table you want to truncate?');
        $this->info('Truncating table ' . $table);
        DB::table($table)->truncate();
        $this->info('Table ' . $table . ' has been truncated');
        return Command::SUCCESS;
    }
}
