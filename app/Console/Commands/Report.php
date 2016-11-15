<?php

namespace App\Console\Commands;

use App\Repository\UserRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send report staff last visit';

    /**
     * Staff
     */
    protected $staff;

    /**
     * Create a new command instance.
     *
     * @param $staff
     *
     * @return void
     */
    public function __construct(UserRepository $staff)
    {
        parent::__construct();

        $this->staff = $staff;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $staff = \App\Models\Report::lastVisit();

        Mail::to(User::getAdminEmails())->send(new \App\Mail\Report($staff));

        return true;
    }
}
