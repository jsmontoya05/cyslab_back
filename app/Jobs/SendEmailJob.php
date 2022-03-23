<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emitter;
    protected $reciver;
    protected $emailConfig;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emitter,$reciver,$emailConfig)
    {
        $this->emitter      = $emitter;
        $this->reciver      = $reciver;
        $this->emailConfig  = $emailConfig;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::send('emails.demo',$this->emailConfig,function($message){ $message->from($this->emitter)->to($this->reciver)->subject('Confirmación de CYSLAB'); });
        } catch (\Exception $th) {
            Log::error($th);
        }
    }
}
