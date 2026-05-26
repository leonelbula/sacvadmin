<?php
namespace App\Services;
use App\DTOs\ParameterDTO;
use App\Repositories\ParameterRepository;
use App\Actions\Parameter\CreateParameterAction;
use App\Actions\Parameter\UpdateParameterAction;

class ParameterService
{
    public function __construct(
        protected ParameterRepository $parameterRepository,
        protected CreateParameterAction $createParameterAction,
        protected UpdateParameterAction $updateParameterAction
    )
    {}

    public function createParameter(ParameterDTO $parameterDTO)
    {
        return $this->createParameterAction->execute($parameterDTO);
    }

    public function updateParameter(int $id, ParameterDTO $parameterDTO)
    {
        $parameter = $this->parameterRepository->getParameterById($id);
        return $this->updateParameterAction->execute($parameter, $parameterDTO);
    }
    public function getAllParameters()
    {
        return $this->parameterRepository->getAllParameters();
    }
    public function getParameterByCompanyId(int $companyId){
        return $this->parameterRepository->getParameterById($companyId);
    }
}