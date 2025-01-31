<?php

namespace App\Http\Controllers;

use App\Models\Need;
use Illuminate\Http\Request;

class NeedController extends Controller
{
    public function index()
    {
        $essential = Need::where('priority', 'essential')->with('product')->get();
        $nice_to_have = Need::where('priority', 'nice_to_have')->get();
        $dont_want = Need::where('priority', 'dont_want')->get();

        return view('needs.index', compact(['essential', 'nice_to_have', 'dont_want']));
    }
}
