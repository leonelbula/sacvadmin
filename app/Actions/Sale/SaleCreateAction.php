<?php
namespace App\Actions\Sale;

use App\DTOs\SaleDTO;
use App\Repositories\SaleRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Actions\SaleDetail\SaleDetailCreateAction;

class SaleCreateAction
{

    public function __construct(
    protected SaleRepository $saleRepository,
    protected SaleDetailCreateAction $saleDetailCreateAction
    )
    {}
}