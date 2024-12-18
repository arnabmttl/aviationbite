<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Invoice;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class InvoiceRepository extends BaseRepository
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
     * Create a new invoice for an order by object.
     *
     * @param  \App\Models\Order  $order
     * @return \App\Models\Invoice|boolean
     */
    public function createInvoiceByOrderObject($order)
    {
        try {
            $newInvoice = new Invoice;
            $newInvoice->user_id = $order->user_id;
            $newInvoice->user_details = $order->user_details;
            $newInvoice->order_details = $order;
            $newInvoice->order_item_details = $order->items;

            return $order->invoice()->save($newInvoice);
        } catch (Exception $e) {
            Log::channel('order')->error("[InvoiceRepository:createInvoiceByOrderObject] Order's invoice not created by object because an exception occured: ");
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the paginated list of invoices.
     *
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
     */
    public function getPaginatedListOfInvoices($perPage)
    {
        try {
            return Invoice::paginate($perPage);
        } catch (Exception $e) {
            Log::channel('order')->error('[InvoiceRepository:getPaginatedListOfInvoices] Paginated list of invoices not fetched because an exception occurred: ');
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the paginated list of invoices by user id.
     *
     * @param  int  $userId
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
     */
    public function getPaginatedListOfInvoicesByUserId($userId, $perPage)
    {
        try {
            return Invoice::whereUserId($userId)->paginate($perPage);
        } catch (Exception $e) {
            Log::channel('order')->error('[InvoiceRepository:getPaginatedListOfInvoicesByUserId] Paginated list of invoices by user id not fetched because an exception occurred: ');
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the first invoice by the id.
     *
     * @param  int  $id
     * @return \App\Models\Invoice|boolean
     */
    public function getFirstInvoiceById($id)
    {
        try {
            return Invoice::whereId($id)->first();
        } catch (Exception $e) {
            Log::channel('order')->error("[InvoiceRepository:getFirstInvoiceById] First invoice by id not fetched because an exception occured: ");
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }
}