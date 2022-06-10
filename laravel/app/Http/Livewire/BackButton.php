<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BackButton extends Component
{
    public $url;
    public $name;

    public function render()
    {
        return view('livewire.back-button');
    }
}
