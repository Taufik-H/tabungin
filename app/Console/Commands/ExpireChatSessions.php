<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChatSession;

class ExpireChatSessions extends Command
{
    protected $signature = 'chat:expire';
    protected $description = 'Delete chat sessions older than 1 day';

    public function handle()
    {
        $count = ChatSession::expired()->delete();
        $this->info("Deleted {$count} expired chat sessions.");
    }
} 