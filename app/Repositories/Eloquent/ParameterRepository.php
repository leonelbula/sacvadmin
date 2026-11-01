<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\parameterRepositoryInterface;
use App\Models\Parameter;

class ParameterRepository implements parameterRepositoryInterface
{
    public function getAllParameters()
    {
        return Parameter::all();
    }

    public function getParameterById(int $id)
    {
        return Parameter::findOrFail($id);
    }

    public function createParameter(array $data)
    {
        return Parameter::create($data);
    }

    public function updateParameter(int $id, array $data)
    {
        $parameter = Parameter::findOrFail($id);
        $parameter->update($data);
        return $parameter;
    }

    public function deleteParameter(int $id): bool
    {
        $parameter = Parameter::findOrFail($id);
        return $parameter->delete();
    }
}
