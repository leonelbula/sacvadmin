<?php

namespace App\Services;

use App\Interfaces\KardexRepositoryInterface;

class KardexService
{


    public function __construct(protected KardexRepositoryInterface $kardexRepository) {}

    // Service methods for Kardex operations
    public function all()
    {
        return $this->kardexRepository->all();
    }
    public function find($id)
    {
        return $this->kardexRepository->find($id);
    }
}
