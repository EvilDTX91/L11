<?php

namespace App\Console\Commands;

use App\Http\Controllers\RickAndMorty\RickAndMortyController;
use Exception;
use Illuminate\Console\Command;

class RickAndMortyInitData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-data-ram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init RickAndMorty database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $RickAndMortyController = new RickAndMortyController;
            $RickAndMortyController->InitDataCommand();

            $this->info(sprintf('Rick and Morty database initialize was succesfull'));
        } catch (Exception $exception) {
            $this->error(sprintf('Failed to initialize Rick and Morty database: %s', $exception->getMessage()));
        }
    }
}
