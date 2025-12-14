<?php

namespace MrShaneBarron\tour\View\Components;

use Illuminate\View\Component;

class tour extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('ld-tour::components.tour');
    }
}
