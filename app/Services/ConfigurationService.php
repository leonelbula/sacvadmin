<?php

namespace App\Services;

use App\Interfaces\ConfigurationRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConfigurationService
{
    public function __construct(
        private readonly ConfigurationRepositoryInterface $repository
    ) {}

    public function getConfiguration(): array
    {
        return [
            'company' => $this->repository->getCompany(),
            'parameters' => $this->repository->getParameters(),
        ];
    }

    public function updateConfiguration(
        array $companyData,
        array $parameterData,
        ?UploadedFile $logo = null
    ): void {
        $oldLogo = $this->repository->getCompany()?->logo;
        $newLogo = null;

        if ($logo) {
            $newLogo = $logo->store('companies', 'public');
            $companyData['logo'] = $newLogo;
        }

        try {
            DB::transaction(function () use (
                $companyData,
                $parameterData
            ) {
                $this->repository->saveCompany($companyData);
                $this->repository->saveParameters($parameterData);
            });
        } catch (\Throwable $exception) {
            if ($newLogo) {
                Storage::disk('public')->delete($newLogo);
            }

            throw $exception;
        }

        if ($newLogo && $oldLogo && $oldLogo !== $newLogo) {
            Storage::disk('public')->delete($oldLogo);
        }
    }
}
