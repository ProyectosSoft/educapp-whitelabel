<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AuthorLayout extends Component
{
    public $course;
    /**
     * Create a new component instance.
     */
    public function __construct($course)
    {
        $this->course=$course;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.author');
    }
}
