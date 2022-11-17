<?php

namespace App\Http\Controllers;

use App\Enums\SwapType;
use App\Http\Requests\CreateSwapRequest;
use App\Models\Swap;
use App\Services\LightningService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SwapController extends Controller
{
    public function __construct(private LightningService $lightningService)
    {
    }

    public function create(CreateSwapRequest $request)
    {
        $swap = $this->lightningService->initLnToBtcSwap(
            amount: $request->amount,
            addr: $request->address,
        );

        return Inertia::render('Swap/CreateSwap', [
            'paymentRequest' => $swap->payment_request,
            'swapUuid' => $swap->uuid,
            'fee' => $swap->fee,
            'amount' => $swap->amount,
            'address' => $swap->address,
        ]);
    }

    public function show(string $swapUuid)
    {
        $swap = Swap::where('uuid', $swapUuid)->firstOrFail();

        return Inertia::render('Swap/ShowSwap', [
            'swap' => $swap,
        ]);
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
