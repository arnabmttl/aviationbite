<?php

namespace App\Services;

// Services
use App\Services\AuthService;

// Respositories
use App\Repositories\InvoiceRepository;

class InvoiceService extends BaseService
{
	/**
     * InvoiceRepository instance to use various functions of the InvoiceRepository.
     *
     * @var \App\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * AuthService instance to use various functions of the AuthService.
     *
     * @var \App\Repositories\AuthService
     */
    protected $authService;

    /**
     * Create a new service instance.
     *
     * @return void
     */
	public function __construct()
	{
		parent::__construct();
        $this->invoiceRepository = new InvoiceRepository;
        $this->authService = new AuthService;
	}

	/**
     * Get the paginated list of invoices.
     *
     * @param  int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
     */
    public function getPaginatedListOfInvoices($perPage)
    {
        $roleLabel = $this->authService->getRoleLabelOfCurrentlyLoggedInUser();

        switch ($roleLabel) {
            case 'admin':
                return $this->invoiceRepository->getPaginatedListOfInvoices($perPage);

            case 'student': 
                return $this->invoiceRepository->getPaginatedListOfInvoicesByUserId($this->authService->getIdOfCurrentlyLoggedInUser(), $perPage);
            
            default: 
                /**
                 * User id is provided as -1 so that nothing is returned but still
                 * Illuminate\Pagination\LengthAwarePaginator object is returned.
                 */
                return $this->invoiceRepository->getPaginatedListOfInvoicesByUserId(-1, $perPage);
        }
    }

    /**
     * Get the first invoice based on the id.
     *
     * @param  int  $id
     * @return \App\Models\Invoice|boolean
     */
    public function getFirstInvoiceById($id)
    {
        return $this->invoiceRepository->getFirstInvoiceById($id);
    }
}