<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Store extends Component
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|min:4',
        'description' => 'sometimes|string|min:6',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveProject()
    {
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::user()->getAuthIdentifier();

        Project::create($validatedData);
    }

    public function render()
    {
        return view('livewire.projects.store');
    }
}
