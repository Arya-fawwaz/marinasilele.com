<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

#[Signature('app:migrate-local-to-supabase')]
#[Description('Migrate local MySQL data to Supabase PostgreSQL')]
class MigrateLocalToSupabase extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Configure the local MySQL database dynamically
        $mysqlConfig = [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'marina_lele_db',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ];
        config(['database.connections.mysql_local' => $mysqlConfig]);

        $tables = [
            'users',
            'categories',
            'products',
            'testimonials',
            'carts',
            'cart_items',
            'orders',
            'order_items',
            'payments'
        ];

        // 2. Disable constraints on PostgreSQL
        $this->info('Disabling foreign key constraints on PostgreSQL...');
        DB::statement("SET session_replication_role = 'replica';");

        try {
            foreach ($tables as $table) {
                $this->info("Migrating table: {$table}");
                
                // Get all rows from local mysql
                $rows = DB::connection('mysql_local')->table($table)->get();
                $this->info("Found " . $rows->count() . " rows in local {$table}");
                
                // Clear target table in pgsql first to prevent duplicates (using delete to bypass DDL locks)
                DB::table($table)->delete();
                
                // Insert in chunks to avoid memory or SQL limits
                $chunks = array_chunk($rows->map(function($row) {
                    return (array) $row;
                })->toArray(), 100);

                foreach ($chunks as $chunk) {
                    DB::table($table)->insert($chunk);
                }
                
                $this->info("Successfully migrated table: {$table}");

                // Reset PostgreSQL serial sequence for auto-incrementing IDs
                if (Schema::hasColumn($table, 'id')) {
                    $hasRows = DB::table($table)->exists();
                    if ($hasRows) {
                        DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), COALESCE(MAX(id), 1)) FROM \"{$table}\"");
                        $this->info("Reset sequence for {$table} to current MAX(id)");
                    }
                }
            }
            $this->info('Migration completed successfully!');
        } catch (\Exception $e) {
            $this->error('Migration failed: ' . $e->getMessage());
        } finally {
            // 3. Re-enable constraints on PostgreSQL
            $this->info('Re-enabling foreign key constraints on PostgreSQL...');
            DB::statement("SET session_replication_role = 'origin';");
        }
    }
}

