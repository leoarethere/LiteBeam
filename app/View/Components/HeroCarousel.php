<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class HeroCarousel extends Component
{
    public array $slides;

    public function __construct($slides = [])
    {
        $this->slides = $slides;
    }

    public function render(): View|Closure|string
    {
        return view('components.hero-carousel');
    }
}