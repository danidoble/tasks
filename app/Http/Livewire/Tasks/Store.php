<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Store extends Component
{
    public $idx;
    public $id_project;
    public $name;
    public $limit_date;
    public $priority;
    public $description;


    protected $rules = [
        'name' => 'required|min:4',
    ];

    public function render()
    {
        return view('livewire.tasks.store',[
            'id_project' => $this->idx,
        ]);
    }
    public function reload($idx){
        $this->idx = $idx;
        $this->id_project = $idx;
        $this->render();
    }


    public function submit($id)
    {
        $this->idx = $id;
        $this->id_project = $id;
        $this->validate();

        // Execution doesn't reach here if validation fails.

        Task::create([
            'name' => $this->name,
            'project_id' => $this->id_project,
            'user_id' => Auth::user()->getAuthIdentifier(),
            'updated_by' => Auth::user()->getAuthIdentifier(),
            'limit_date' => $this->limit_date,
            'priority' => $this->priority,
            'description' => $this->description,

        ]);
    }
}
