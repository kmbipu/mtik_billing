<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function adminHome()
    {
        return 'Admin home';
    }

    public function resellerHome()
    {
        return 'Reseller home';
    }

    public function customerHome()
    {
        return 'Customer home';
    }
}
