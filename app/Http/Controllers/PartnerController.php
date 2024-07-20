<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::where('visible', true)->latest()->paginate(8);
        return view('partners.index', compact('partners'));
    }

    public function create()
    {
    }
}
