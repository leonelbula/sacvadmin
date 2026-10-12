<?php

namespace App\Repositories;

use App\Interfaces\ConfigurationRepositoryInterface;
use App\Models\Company;
use App\Models\Parameter;

class ConfigurationRepository implements ConfigurationRepositoryInterface
{
    public function getCompany(): ?Company
    {
        return Company::query()->first();
    }

    public function getParameters(): ?Parameter
    {
        return Parameter::query()->first();
    }

    public function saveCompany(array $data): Company
    {
        $company = Company::query()->first();

        if (!$company) {
            $company = new Company();
        }

        $company->fill($data);
        $company->save();

        return $company;
    }

    public function saveParameters(array $data): Parameter
    {
        $parameters = Parameter::query()->first();

        if (!$parameters) {
            $parameters = new Parameter();
        }

        $parameters->fill($data);
        $parameters->save();

        return $parameters;
    }
}
