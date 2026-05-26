<?php
namespace App\Actions\Parameter;
use App\Models\Parameter;
use App\DTOs\ParameterDTO;
class UpdateParameterAction
{
    public function execute(Parameter  $parameter, ParameterDTO $parameterDTO): Parameter
    {
        $data = $parameterDTO->toArray();
        $parameter->update($data);
        return $parameter;
    }
}