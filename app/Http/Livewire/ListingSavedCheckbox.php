<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListingSavedCheckbox extends Component
{
    public function render()
    {
        $savedAmount = auth()->user()->savedListings()->count();
        return view('livewire.listing-saved-checkbox', compact('savedAmount'));
    }
}
