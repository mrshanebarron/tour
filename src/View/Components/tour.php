<?php

namespace MrShaneBarron\Tour\View\Components;

use Illuminate\View\Component;

class Tour extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('sb-tour::components.tour');
    }
}
