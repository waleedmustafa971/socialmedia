<?php

namespace App\Livewire;

use Livewire\Component;

class CommunityCreate extends Component
{
    public $name;
    public $description;

    public function createCommunity()
    {
        $this->validate([
            'name' => 'required|unique:communities',
            'description' => 'nullable|string',
        ]);

        Community::create([
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Community created successfully!');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.community-create');
    }
}

