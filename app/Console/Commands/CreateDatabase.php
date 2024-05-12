<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputArgument;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:database {dbname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $database = $this->argument('dbname') ?: config("database.connections.mysql.database");
            $charset = config("database.connections.mysql.charset", 'utf8mb4');
            $collation = config("database.connections.mysql.collation", 'utf8mb4_unicode_ci');

            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
            $db = DB::select($query, [$database]);
            if (empty($db)) {
                DB::statement("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET $charset COLLATE $collation;");


                $path = base_path('.env');

                if (file_exists($path)) {
                    file_put_contents($path, str_replace(
                        'DB_DATABASE=',
                        'DB_DATABASE=' . $database,
                        file_get_contents($path)
                    ));
                }

                $this->info(sprintf('Successfully created %s database', $database));
            } else {
                throw new Exception("Database already exists");
            }
        } catch (\Exception $exception) {
            $this->error(sprintf('Failed to create %s database: %s', $database, $exception->getMessage()));
        }
    }
}
