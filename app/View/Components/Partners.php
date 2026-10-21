<?php

namespace App\View\Components;

use App\Models\Partner;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Os parceiros na página inicial: uma amostra ao acaso, para cada visita
 * dar a vez a outros, e o link para a lista completa em /parceiros.
 */
class Partners extends Component
{
    /** Enche a grelha: 4 linhas de 3 no telemóvel, 3 de 4 no tablet, 2 de 6 no desktop. */
    public const SAMPLE = 12;

    public $partners;

    public int $total;

    public function __construct()
    {
        // Só os visíveis: esconder um parceiro em /admin/parceiros tem de o
        // tirar também daqui.
        $this->partners = Partner::visible()->inRandomOrder()->take(self::SAMPLE)->get();
        $this->total = Partner::visible()->count();
    }

    public function render(): View|Closure|string
    {
        return view('components.partners', [
            'partners' => $this->partners,
            'total'    => $this->total,
        ]);
    }
}
