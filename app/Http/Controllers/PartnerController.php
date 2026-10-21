<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnerController extends Controller
{
    /**
     * /parceiros: todos os visíveis numa só página, por ordem alfabética.
     * São poucas dezenas de logótipos — páginas só obrigavam a clicar.
     */
    public function index()
    {
        $partners = Partner::visible()->orderBy('name')->get();

        return view('partners.index', compact('partners'));
    }
}
