<?php

namespace App\Interfaces;

use App\Models\Company;
use App\Models\Parameter;

interface ConfigurationRepositoryInterface
{
    public function getCompany(): ?Company;

    public function getParameters(): ?Parameter;

    public function saveCompany(array $data): Company;

    public function saveParameters(array $data): Parameter;
}
