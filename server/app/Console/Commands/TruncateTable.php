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
        $tables = $this->ask('Which table you want to truncate?');
        $tables = explode(',', $tables);
        foreach ($tables as $table) {
            $this->truncateTable($table);
        }
        $this->info('All tables have been truncated');
        return Command::SUCCESS;
    }

    private function truncateTable($table)
    {
        try {
            $this->info('Truncating table ' . $table);
            DB::table($table)->truncate();
            $this->info('Table ' . $table . ' has been truncated');
        } catch (\Throwable $th) {
            $this->error('Error truncating table ' . $table);
            $this->error($th->getMessage());
        }
    }
}
