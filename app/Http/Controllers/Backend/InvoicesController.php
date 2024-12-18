<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Services
use App\Services\InvoiceService;
use App\Services\CryptoService;

// Requests
use Illuminate\Http\Request;

use Dompdf\Dompdf;

class InvoicesController extends Controller
{
    /**
     * InvoiceService instance to use various functions of the InvoiceService.
     *
     * @var \App\Service\InvoiceService
     */
    protected $invoiceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->invoiceService = new InvoiceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = $this->invoiceService->getPaginatedListOfInvoices(20);
        
        return view('backend.admin.invoice.index', compact('invoices'));
    }

    /**
     * Load the corresponding view for invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        /**
         * Decrypt the invoice id and fetch invoice to show its details else show 404 page.
         */
        if ($invoiceId = (new CryptoService)->decryptValue($id)) {
            $invoice = $this->invoiceService->getFirstInvoiceById($invoiceId);
            
            return view('backend.admin.invoice.show', compact('invoice'));
        }
        else
            return abort(404);
    }

    /**
     * Download the invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        /**
         * Decrypt the invoice id and fetch invoice to show its details else show 404 page.
         */
        if ($invoiceId = (new CryptoService)->decryptValue($id)) {
            $invoice = $this->invoiceService->getFirstInvoiceById($invoiceId);
            
            $html = view('pdfs.invoice', ['invoice' => $invoice])->render();
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream();
        }
        else
            return abort(404);
    }
}
