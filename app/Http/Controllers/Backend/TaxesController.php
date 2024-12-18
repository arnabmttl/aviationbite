<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Tax;

// Requests 
use Illuminate\Http\Request;
use App\Http\Requests\TaxEditRequest;

// Repositories
use App\Repositories\TaxRepository;

// Support Facades
use Illuminate\Support\Facades\Session;

class TaxesController extends Controller
{
    /**
     * TaxRepository instance to use various functions of TaxRepository.
     *
     * @var \App\Repositories\TaxRepository
     */
    protected $taxRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->taxRepository = new TaxRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxes = $this->taxRepository->getPaginatedListOfTaxes(5);

        if($taxes)
            return view('backend.admin.tax.index', compact('taxes'));
        else {
            Session::flash('failure', 'There is some problem in fetching taxes. Kindly try again after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        return view('backend.admin.tax.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaxEditRequest  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(TaxEditRequest $request, Tax $tax)
    {
        $update = $request->validated();

        $result = $this->taxRepository->updateTaxByObject($update, $tax);

        if ($result)
            Session::flash('success', 'The tax has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the tax.');

        return redirect(route('tax.index'));
    }
}
