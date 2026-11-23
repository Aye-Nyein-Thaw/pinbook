<?php

namespace App\View\Components;

use App\Models\Trip;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TripCommentForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Trip $trip)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.trip-comment-form');
    }
}
