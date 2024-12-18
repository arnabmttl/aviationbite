<?php

namespace App\Services;

class MiscService extends BaseService
{
	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Generate alpha-numeric code of a specific length.
	 * 
	 * @param  int $length
	 * @return string
	 */
	public function generateAlphaNumericCode($length)
    {
    	try {
	        $code = '';
	        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	        for ($i = 0; $i < $length; $i++) 
	        {
	            $code .= $characters[mt_rand(0, strlen($characters) - 1)];
	        }

	        return $code;
	    } catch (Exception $e) {
			Log::channel('misc')->error('[MiscService:generateAlphaNumericCode] Alphanumeric code not generated because an exception occurred: ');
			Log::channel('misc')->error($e->getMessage());

			return false;
		}
    }

    /**
	 * Generate numeric code of a specific length.
	 * 
	 * @param  int $length
	 * @return int
	 */
	public function generateNumericCode($length)
    {
    	try {
        	return rand(pow(10, $length-1), pow(10, $length)-1);
    	} catch (Exception $e) {
			Log::channel('misc')->error('[MiscService:generateNumericCode] Numeric code not generated because an exception occurred: ');
			Log::channel('misc')->error($e->getMessage());

			return false;
		}
    }
}