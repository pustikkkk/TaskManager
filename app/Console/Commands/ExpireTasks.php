<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:expire-tasks')]
#[Description('Command description')]
class ExpireTasks extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        Task::where('status'=='pending')->whereDate('due_date','<', Carbon::today())->update(['status'=>'expired']);
    }
}
