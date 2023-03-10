<?php

namespace App\Http\Livewire;

use App\Models\Building;
use Livewire\Component;

class TabletSetupForm extends Component
{
    public $rooms;
    public $buildings;

    public $selectedBuilding;

    public function render()
    {
        return view('livewire.tablet-setup-form');
    }
}
