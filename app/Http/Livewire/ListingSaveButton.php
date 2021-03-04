<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListingSaveButton extends Component
{
    public $listingId;

    public function render()
    {
        return view('livewire.listing-save-button');
    }

    public function saveListing()
    {
        auth()->user()->savedListings()->attach($this->listingId);
    }
}
