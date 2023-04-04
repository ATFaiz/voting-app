<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Models\Voter;
use App\Notifications\ConstituencyVoteNotification;

class SendConstituencyVoteNotification extends Command
{
    protected $signature = 'send:constituency-vote-notification';

    protected $description = 'Send a constituency vote notification to all registered voters.';

    public function handle()
    {
        // $voters = Voter::whereNotNull('user_id')->latest()->take(3)->get();

        $voters = Voter::all();
        foreach ($voters as $voter) {
            $user = $voter->user;
            $user->notify(new ConstituencyVoteNotification);
        }

        $this->info('Vote notification sent successfully!');
    }
}
