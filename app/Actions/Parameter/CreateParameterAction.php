<?php
namespace App\Actions\Parameter;
use App\Models\Parameter;
use App\DTOs\ParameterDTO;

class CreateParameterAction
{
    public function execute(ParameterDTO $parameterDTO): Parameter
    {
        $data = $parameterDTO->toArray();
        return Parameter::create($data);
    }
}