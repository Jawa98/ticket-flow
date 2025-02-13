<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponser;
use App\Traits\GroupAll;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests, GroupAll, ApiResponser;
}
