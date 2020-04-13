<?php

namespace App\Console\Commands;

use App\Advertisement;
use Illuminate\Console\Command;

class TrashAdvertisements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TrashAdvertisements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trash advertisements that ended after month';

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
        $advertisements =Advertisement::withoutTrashed()->get();
        foreach ($advertisements as $advertisement)
        {
            if (now() > $advertisement->trashed_at) {
                $advertisement->Delete();
            }
        }
    }
}
