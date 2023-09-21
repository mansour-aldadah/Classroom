<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    /**
     * Create a new component instance.
     */

    protected $title;

    public function __construct($title, $class = '')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.main', [
            'title' => $this->title,
        ]);
    }
}
