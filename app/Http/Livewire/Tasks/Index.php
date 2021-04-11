<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $idx;
    public $name;
    public $limit_date;
    public $priority;
    public $description;


    protected $rules = [
        'name' => 'required|min:4',
    ];


    public function render()
    {
        $tasks = Task::whereNull('completed_at')
            ->where('project_id',$this->idx)->paginate(50);
        return view('livewire.tasks.index',[
            'tasks'=>$tasks
        ]);
    }

    public function updateTask($id,$param,$value){
        if($id !== null){
            //dd($id,$param,$value);
            $task = Task::find($id);
            if(!empty($task)){
                if($param !== 'name' and trim($value) === ''){
                    $value = null;
                }
                $task->{$param} = $value;
                $task->updated_by = Auth::user()->getAuthIdentifier();
                $task->save();
            }
        }
        //$this->render();
    }
    public function reload(){
        $this->render();
    }


    public function submit()
    {
        $this->validate();

        // Execution doesn't reach here if validation fails.

        Task::create([
            'name' => $this->name,
            'project_id' => $this->id_project,
            'user_id' => Auth::user()->getAuthIdentifier(),
            'limit_date' => $this->limit_date,
            'priority' => $this->priority,
            'description' => $this->description,

        ]);
    }

    public function complete($id){
        $this->id_project = $id;
        $project = Task::find($id);
        $project->completed_at = date('Y-m-d H:i:s');
        $project->completed_by = Auth::user()->getAuthIdentifier();
        $project->save();
    }

    public function delete($id){
        $this->id_project = $id;
        $project = Task::find($id);
        $project->delete();
    }


}
