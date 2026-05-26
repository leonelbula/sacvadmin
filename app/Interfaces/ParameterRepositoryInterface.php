<?php
namespace App\Interfaces;
interface ParameterRepositoryInterface
{
    public function getAllParameters();
    public function getParameterById(int $id);
    public function createParameter(array $data);
    public function updateParameter(int $id, array $data);
    public function deleteParameter(int $id): bool;
}