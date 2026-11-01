<?php

namespace App\Http\Controllers;

use App\DTOs\AccountReceivablePaymentDTO;
use App\Http\Requests\AccountReceivablePaymentRequest;
use App\Models\Sale;
use App\Services\AccountReceivablePaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class AccountReceivablePaymentController extends Controller
{
    public function __construct(
        private AccountReceivablePaymentService $service
    ) {}

    public function index(int $id): View
    {
        $cuenta = Sale::with('customer')->findOrFail($id);

        $abonos = $this->service->getPayments($id, 15);

        return view(
            'accounts-receivable.payments.index',
            compact('cuenta', 'abonos')
        );
    }

    public function show(int $id, int $paymentId): View
    {
        $abono = $this->service->findPayment($id, $paymentId);

        return view(
            'accounts-receivable.payments.show',
            compact('abono')
        );
    }

    public function create(int $id): View
    {

        $cuenta = $this->service->findSale($id);

        abort_if((float) $cuenta->balance <= 0, 422, 'Esta cuenta no tiene saldo pendiente.');

        return view(
            'accounts-receivable.payments.create',
            compact('cuenta')
        );
    }

    public function edit(int $id, int $paymentId): View
    {
        $abono = $this->service->findPayment($id, $paymentId);
        $cuenta = $this->service->findSale($id);


        return view(
            'accounts-receivable.payments.edit',
            compact('abono', 'cuenta')
        );
    }

    public function update(AccountReceivablePaymentRequest $request, int $paymentId): RedirectResponse
    {
      
        try {
            $data = AccountReceivablePaymentDTO::fromRequest($request);

            $this->service->updatePayment($paymentId, $data);

            toastr()->success('Abono actualizado correctamente.');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Error al actualizar el abono: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput();
        }
    }


    public function store(AccountReceivablePaymentRequest $request, int $id): RedirectResponse
    {
        try {
            $data = AccountReceivablePaymentDTO::fromRequest($request);

            $this->service->registerPayment($id, $data, (int) $request->user()->id);

            toastr()->success('Abono registrado correctamente.');
            return redirect()->route('accounts-receivable.payments.index', $id);
        } catch (\Exception $e) {
            toastr()->error('Error al registrar el abono: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput();
        }
    }
    public function pdf2(int $id, int $paymentId)
    {
        $abono = $this->service->findPayment($id, $paymentId);

        $pdf = Pdf::loadView(
            'accounts-receivable.payments.pdf',
            compact('abono')
        )->setPaper('a4', 'portrait');

        return $pdf->download(
            'comprobante-abono-' . $abono->id . '.pdf'
        );
    }
    public function pdf(int $id, int $paymentId)
    {
        $abono = $this->service->findPayment($id, $paymentId);

        $pdf = Pdf::loadView(
            'accounts-receivable.payments.pdf',
            [
                'abono' => $abono,
                'empresa' => null,
            ]
        )->setPaper('a4', 'portrait');

        return $pdf->stream(
            'comprobante-abono-' . $abono->id . '.pdf'
        );
    }
}
