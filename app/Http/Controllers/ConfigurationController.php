<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfigurationController extends Controller
{
    public function __construct(
        private readonly ConfigurationService $service
    ) {}

    public function index(): View
    {
        return view(
            'configuration.index',
            $this->service->getConfiguration()
        );
    }

    public function update(Request $request): RedirectResponse
    {
        $companyData = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'identification_card' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50'],
            'address' => ['required', 'string', 'max:50'],
            'departament' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $parameterData = $request->validate([
            'sale_code' => ['required', 'integer', 'min:0'],
            'product_code' => ['required', 'integer', 'min:0'],
            'automatic_product' => ['nullable', 'boolean'],
        ]);

        $logo = $request->file('logo');

        unset($companyData['logo']);

        $parameterData['automatic_product'] =
            $request->boolean('automatic_product');

        $this->service->updateConfiguration(
            $companyData,
            $parameterData,
            $logo
        );
        toastr()->success('Registro guardado');
        return redirect()
            ->route('configuration.index');
    }
}
