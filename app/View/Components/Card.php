<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     */

    public $title;
    public $subTitle;
    public $jumlah;

    public function __construct($title, $subTitle, $jumlah)
    {
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->jumlah = $jumlah;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}