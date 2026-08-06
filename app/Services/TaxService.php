<?php

namespace App\Services;

use App\Models\Tax;
use App\Repositories\TaxRepository;

class TaxService
{

    public function __construct(
        protected TaxRepository $taxRepository
    ) {
        // Constructor logic if needed
    }

    public function getAllTaxes()
    {
        return $this->taxRepository->all();
    }
}
