<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public array $menu = [];

    public function __construct(public ?string $title = null)
    {
        // the menu is defined once, here, and shown in the header and the footer
        $this->menu = [
            'home' => route('welcome'),
            'trips' => route('trips.index'),
            'categories' => route('categories.index'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site-layout');
    }
}
