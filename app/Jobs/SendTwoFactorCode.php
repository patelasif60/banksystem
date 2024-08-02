<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail; 
use App\Mail\TwoFactorMail;

class SendTwoFactorCode implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $twoFactorCode;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $twoFactorCode)
    {
        $this->user = $user;
        $this->twoFactorCode = $twoFactorCode;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new TwoFactorMail($this->user, $this->twoFactorCode));
    }
}
