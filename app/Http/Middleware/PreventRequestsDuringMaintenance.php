<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while the application is in maintenance mode.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
