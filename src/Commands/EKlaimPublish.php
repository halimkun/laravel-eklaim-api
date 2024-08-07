<?php

namespace Halim\EKlaim\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EKlaimPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eklaim:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes the EKlaim configuration and routes, and instructs the user to include routes in their routes file.';

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
        // Paths to the files in the package
        $files = [
            'Configuration file' => [
                'source' => base_path('vendor/halim/laravel-eklaim-api/src/Config/eklaim.php'),
                'destination' => config_path('eklaim.php')
            ],
            'Routes file' => [
                'source' => base_path('vendor/halim/laravel-eklaim-api/src/Routes/api.php'),
                'destination' => base_path('routes/eklaim-api.php')
            ]
        ];

        foreach ($files as $type => $paths) {
            $this->publishFile($type, $paths['source'], $paths['destination']);
        }

        // Inform the user about the need to include the routes
        $this->info('Please ensure you include the routes from eklaim-api.php in your routes/api.php or routes/web.php');
        $this->warn("example : require_once __DIR__ . '/eklaim-api.php';");

        return 0; // Status code 0 indicates success
    }

    /**
     * Publish a file to the application.
     *
     * @param string $type
     * @param string $source
     * @param string $destination
     * @return void
     */
    protected function publishFile($type, $source, $destination)
    {
        if (File::exists($destination)) {
            $replace = $this->confirm("$type already exists. Do you want to replace it?", true);
            if ($replace) {
                if (File::copy($source, $destination)) {
                    $this->info("$type replaced successfully.");
                } else {
                    $this->error("Failed to replace $type.");
                }
            } else {
                $this->info("$type was not replaced.");
            }
        } else {
            if (File::copy($source, $destination)) {
                $this->info("$type published successfully.");
            } else {
                $this->error("Failed to publish $type.");
            }
        }
    }
}
