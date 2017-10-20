<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ThreadReceivedNewReply
{
    use Dispatchable, SerializesModels;

    public $reply;

    /**
     *
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }
}
