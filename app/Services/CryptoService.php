<?php

namespace App\Services;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CryptoService extends BaseService
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
     * Get the plain text from an encrypted value.
     *
     * @param  string  $encryptedValue
     * @return string|boolean
     */
    public function decryptValue($encryptedValue)
    {
        try {
            return decrypt($encryptedValue);
        } catch (Exception $e) {
            Log::channel('crypto')->error("[CryptoService:decryptValue] Decryption failed because an exception occured: ");
            Log::channel('crypto')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the encrypted value from a plain value
     *
     * @param  string  $plainText
     * @return string|boolean
     */
    public function encryptValue($plainText)
    {
        try {
            return encrypt($plainText);
        } catch (Exception $e) {
            Log::channel('crypto')->error("[CryptoService:encryptValue] Encryption failed because an exception occured: ");
            Log::channel('crypto')->error($e->getMessage());

            return false;
        }
    }
}