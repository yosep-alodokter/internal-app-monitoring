<?php

namespace App\Jobs;

use App\Mail\TestingMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $send_variables;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_variables)
    {
        $this->send_variables = $send_variables;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $send_variable = $this->send_variables;
        Mail::to($this->send_variables['email'])->send(new TestingMail($send_variable));
    }
}
