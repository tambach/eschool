<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class yearlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'year:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update student data once a year';

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
        $status = User::select('users.id', 'users.name', DB::raw('round(AVG(rating.grade), 1) as average'))
            ->where('role_id', '=', 2)
            ->where('class_id', '<', 12)
            ->join('rating', 'rating.user_id', '=', 'users.id')
            ->groupBy('user_id')
            ->where('average', '>', '5.5')
            ->increment('class_id', 1);

        echo $status;
    }
}
