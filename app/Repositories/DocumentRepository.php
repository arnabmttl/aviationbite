<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Document;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class DocumentRepository extends BaseRepository
{
	/**
	 * Create a new repository instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Create a new document by documentable object.
	 *
	 * @param  array  $input
	 * @param  mixed  $documentableObject
	 * @return \App\Models\Document|boolean
	 */
	public function createDocumentByDocumentableObject($input, $documentableObject)
	{
		try {
			$newDocument = new Document($input);

			return $documentableObject->documents()->save($newDocument);
		} catch (Exception $e) {
			Log::channel('document')->error('[DocumentRepository:createDocumentByDocumentableObject] New document not created by documentable object because an exception occurred: ');
			Log::channel('document')->error($e->getMessage());

			return false;
		}
	}
}