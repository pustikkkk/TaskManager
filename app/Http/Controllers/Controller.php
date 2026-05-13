<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests; // Added: Laravel 13 omits this by default; required for $this->authorize() in controllers
}
