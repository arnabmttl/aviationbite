<?php

namespace App\Listeners;

use App\Events\OtpGenerated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Services
use App\Services\SmsService;

class SendOtpSmsToUser
{
    /**
     * SmsService instance to use various functions of the SmsService.
     *
     * @var \App\Services\SmsService
     */
    protected $smsService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->smsService = new SmsService;
    }

    /**
     * Handle the event.
     *
     * @param  OtpGenerated  $event
     * @return void
     */
    public function handle(OtpGenerated $event)
    {
        // if(!$this->smsService->sendSmsToUserByObject($event->user))
        //     $this->failed($event, new Exception('Sending of SMS to user failed.', 1));
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OtpGenerated  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(OtpGenerated $event, $exception)
    {
        Log::channel('listener')->error("[OtpGenerated:SendOtpSmsToUser] Sending of SMS to user failed because an exception occured: ");
        Log::channel('listener')->error("[OtpGenerated:SendOtpSmsToUser] User Id: ".$event->user->id);
        Log::channel('listener')->error($exception->getMessage());
    }
}
