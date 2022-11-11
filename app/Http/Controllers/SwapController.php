<?php

namespace App\Http\Controllers;

use App\Services\LightningService;
use Illuminate\Http\Request;

class SwapController extends Controller
{
    public function __construct (private LightningService $lightningService)
    {
    }
    
    public function initLnToBtcSwap(Request $request)
    {
        $swap = $this->lightningService->initLnToBtcSwap(
            amount: $request->amount,
            addr: $request->addr,
        );

        return $swap;
    }

    public function checkLnToBtcSwapStatus(string $swapUuid)
    {
        $txid = $this->lightningService->checkInvoiceStatus(swapUuid: $swapUuid);

        return $txid;
    }
}
