<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\TaxRepository;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any tax(es) exist or not. If no tax exist then only create tax.
         */
        $numberOfTaxes = (new TaxRepository)->getTotalTaxes();

        if ($numberOfTaxes == 0) {
        	(new TaxRepository)->createTax([
        		'label' => 'gst',
        		'name' => 'Goods & Services Tax',
        		'tax_percentage' => 18
        	]);
        }
    }
}
