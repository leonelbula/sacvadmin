<?php

namespace App\Http\Controllers;

use App\Services\AccountsReceivableService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountsReceivableController extends Controller
{
    public function __construct(
        private AccountsReceivableService $service
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'fecha_desde' => ['nullable', 'date'],
            'fecha_hasta' => [
                'nullable',
                'date',
                'after_or_equal:fecha_desde',
            ],
        ]);

        $data = $this->service->getAccountsReceivable(
            $filters,
            15
        );

        return view('accounts-receivable.index', $data);
    }

    public function show(int $id): View
    {
        $cuenta = $this->service->findAccount($id);

        return view('accounts-receivable.show', compact('cuenta'));
    }
}
