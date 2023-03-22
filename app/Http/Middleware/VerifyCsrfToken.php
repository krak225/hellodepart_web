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
        //
		'https://hellodepart.com/notify',//CINETPAY
		'https://hellodepart.com/retour',//CINETPAY
		'https://hellodepart.com/pointventenotify',//CINETPAY
		'https://hellodepart.com/pointventeretour',//CINETPAY
    ];
}
