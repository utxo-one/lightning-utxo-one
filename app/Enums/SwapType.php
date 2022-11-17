<?php

namespace App\Enums;

use UtxoOne\LndPhp\Traits\EnumHelper;

enum SwapType: string
{
    use EnumHelper;
    
    case LN_TO_BTC = 'ln_to_btc';
    case BTC_TO_LN = 'btc_to_ln';
}