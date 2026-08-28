<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('order_number', 'asc')->get();
        $company = CompanyProfile::first();

        return view('public.display', compact('currencies', 'company'));
    }
}