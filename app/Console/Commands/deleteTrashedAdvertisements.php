<?php

namespace App\Console\Commands;

use App\Advertisement;
use Illuminate\Console\Command;


class deleteTrashedAdvertisements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteTrashedAdvertisements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Advertisements That User Didnt renew';

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
        $trashed_advertisements =Advertisement::onlyTrashed()->get();
        foreach ($trashed_advertisements as $trashed_advertisement)
        {
            if (now() > $trashed_advertisement->force_deleted_at) {
                $trashed_advertisement->forceDelete();
            }
        }
    }
}
