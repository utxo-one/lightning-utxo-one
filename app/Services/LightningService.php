<?php

namespace App\Services;

use App\Models\Swap;
use UtxoOne\LndPhp\Models\Lightning\Invoice;
use UtxoOne\LndPhp\Services\LightningService as Lnd;
use UtxoOne\LndPhp\Responses\Lightning\AddInvoiceResponse;
use UtxoOne\LndPhp\Responses\Lightning\SendCoinsResponse;

class LightningService
{
    private Lnd $lnd;

    public function __construct()
    {
        $this->lnd = new Lnd(
            host: env('LND_HOST'),
            port: env('LND_PORT'),
            macaroonPath: env('LND_MACAROON_PATH'),
            tlsCertificatePath: env('LND_TLS_CERT_PATH'),
            useSsl: true,
        );
    }

    public function initLnToBtcSwap(int $amount, string $addr): Swap
    {
        $fee = $amount * 0.01;

        $invoice = $this->addInvoice(
            amount: $amount + $fee,
            memo: $addr,
        );

        return Swap::create([
            'uuid' => hash('sha256', $invoice->getRHash()),
            'type' => 'ln_to_btc',
            'status' => 'pending',
            'amount' => $amount,
            'fee' => $fee,
            'r_hash' => $invoice->getRHash(),
            'payment_request' => $invoice->getPaymentRequest(),
            'address' => $addr,
        ]);
    }

    public function checkInvoiceStatus(string $swapUuid): ?string
    {
        $swap = Swap::where('uuid', $swapUuid)->firstOrFail();

        if ($swap->status === 'completed') {
            return $swap->txid;
        }

        $invoice = $this->lnd->lookupInvoice(rHash: $swap->r_hash);

        if($invoice->isSettled()) {
            $txid = $this->sendCoins(
                address: $swap->address,
                amount: $swap->amount,
            )->getTxid();

            $swap->update([
                'status' => 'completed',
                'txid' => $txid,
                'completed_at' => now(),
            ]);

            return $txid;
        }

        return null;
    }

    private function addInvoice(int $amount, string $memo = null): AddInvoiceResponse
    {
        $invoice = $this->lnd->addInvoice(
            value: $amount,
            memo: $memo,
            expiry: 3600,
        );

        return $invoice;
    }

    private function lookupInvoice(string $rHash): Invoice
    {
        $invoice = $this->lnd->lookupInvoice(
            rHash: $rHash,
        );

        return $invoice;
    }

    private function sendCoins(string $address, int $amount): SendCoinsResponse
    {
        return $this->lnd->sendCoins(
            addr: $address,
            amount: $amount,
            satPerVbyte: 1,
        );
    }
}