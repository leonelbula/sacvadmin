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
    public function search($query)
    {
        return $this->kardexRepository->search($query);
    }

    public function allId($id)
    {
        return $this->kardexRepository->allId($id);
    }
    public function getId($id) {
         return $this->kardexRepository->getId($id);
    }
    public function countRegistro()
    {
        return $this->kardexRepository->countRegister();
    }
}
