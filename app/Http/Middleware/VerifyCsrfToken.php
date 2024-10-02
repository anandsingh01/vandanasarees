<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'otp_for_cod',
        'verify-codotp',
        'addToCart',
        'updateCart',
        'checkCoupon',
        'apply-coupon',
        'calculate-tax',
        'return-product',
        'update/request',
        'payment/callback',
        'payment-successsss'
    ];
}
