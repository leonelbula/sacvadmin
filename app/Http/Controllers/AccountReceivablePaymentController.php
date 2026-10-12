<?php

namespace App\Http\Controllers;

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

    public function create(int $id): View
    {
        $cuenta = $this->service->findSale($id);

        abort_if(
            (float) $cuenta->balance <= 0,
            422,
            'Esta cuenta no tiene saldo pendiente.'
        );

        return view(
            'accounts-receivable.payments.create',
            compact('cuenta')
        );
    }

    public function index(int $id): View
    {
        $cuenta = Sale::with('customer')->findOrFail($id);

        $abonos = $this->service->getPayments($id, 15);

        return view(
            'accounts-receivable.payments.index',
            compact('cuenta', 'abonos')
        );
    }

    public function store(
        Request $request,
        int $id
    ): RedirectResponse {
        $data = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
            ],
            'payment_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'payment_method' => [
                'required',
                'in:cash,transfer,debit_card,credit_card,other',
            ],
            'reference' => [
                'nullable',
                'string',
                'max:100',
            ],
            'observation' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $this->service->registerPayment(
            $id,
            $data,
            (int) $request->user()->id
        );

        toastr()->success('Abono registrado correctamente.');
        return redirect()
            ->route('accounts-receivable.payments.index', $id);
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
