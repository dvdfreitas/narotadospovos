<?php

namespace App\View\Components;

use App\Models\Story;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stories extends Component
{
    public $stories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->stories = Story::orderBy('date', 'desc')->take(5)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stories', [
            'stories' => $this->stories
        ]);
    }
}
