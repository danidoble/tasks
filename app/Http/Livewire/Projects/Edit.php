<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Edit extends Component
{
    public $search;
    public $project_name;
    public $description;
    public $id_project;

    public function render()
    {
        $project = Project::find($this->id_project);
        return view('livewire.projects.edit',[
            "project"=>$project,
        ]);
    }

    public function updateProject($id,$param,$value){
        if($id !== null){
            //dd($id,$param,$value);
            $project = Project::find($id);
            if(!empty($project)){
                $project->{$param} = $value;
                $project->save();
            }
        }
        //$this->render();
    }

    public function reload($id){
        $this->id_project = $id;
        $this->render();
    }
}
