<?php

namespace App\Services;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

// Guzzlehttp
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SmsService extends BaseService
{
	/**
	 * Variable to store various details related to SMS API.
	 *
	 * @var array
	 */
	protected $payload;

	/**
	 * Variable to store SMS API URL.
	 *
	 * @var array
	 */
	protected $smsApiUrl;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->smsApiUrl = 'http://m1.sarv.com/api/v2.0/sms_campaign.php?token='.config('sarv.sms_token').'&user_id='.config('sarv.sms_user_id').'&';
	}

	/**
	 * Send SMS to user by object.
	 *
	 * @return boolean
	 */
	public function sendSmsToUserByObject($user)
	{
		try {
			if ($user->otp) {
				$client = new Client();

				$message = "Your verification OTP is ".$user->otp->otp." - Aviation Bite";

				$this->payload['route'] = 'TR';
				$this->payload['template_id'] = '6730';
				$this->payload['sender_id'] = 'MYiMSG';
				$this->payload['language'] = 'EN';
				$this->payload['sender_id'] = 'MYiMSG';
				$this->payload['template'] = $message;
				$this->payload['contact_numbers'] = $user->phone_number;

				$url = $this->smsApiUrl.http_build_query($this->payload);

				$response = $client->get($url);

            	return true;
			}
		} catch (GuzzleException $e) {
			Log::channel('sms')->error('[SmsService:sendSmsToUserByObject] SMS not sent to user by object because an exception occurred: ');
			Log::channel('sms')->error($e->getMessage());

			return false;
		} catch (Exception $e) {
			Log::channel('sms')->error('[SmsService:sendSmsToUserByObject] SMS not sent to user by object because an exception occurred: ');
			Log::channel('sms')->error($e->getMessage());

			return false;
		}

		return true;
	}
}