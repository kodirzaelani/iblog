<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Management;

use App\Models\Employe;
use App\Models\Pergub;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Management;
use App\Models\Structuroganization;
use Illuminate\Support\Facades\Auth;

class Managementcreate extends Component
{
    public $employe_id;
    public $structuroganization_id;
    public $startdate;
    public $enddate;
    public $sortm;



    public function store()
    {
        $validateData = [
            'employe_id' => 'required',
            'structuroganization_id'     => 'required',
            'startdate'     => 'required',
            'enddate'     => 'required',
            'sortm'     => 'required',
        ];

        $this->validate($validateData);

        $data = [];

        $data = [
            'employe_id'     => $this->employe_id,
            'structuroganization_id'     => $this->structuroganization_id,
            'startdate'     => $this->startdate,
            'enddate'     => $this->enddate,
            'sortm'     => $this->sortm,
            'author_id'     => Auth::id(),
        ];

        $management = Management::create($data);

        $this->emit('managementStored', $management);
        $this->cleanVars();

    }


    private function cleanVars()
    {
        $this->employe_id = null;
        $this->structuroganization_id = null;
        $this->startdate = null;
        $this->enddate = null;
        $this->sortm = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.management.managementcreate',[
            'employes' => Employe::orderBy('name', 'asc')->get(),
            'structuroganization' => Structuroganization::where('status', 1)->orderBy('department', 'asc')->get(),
        ]);
    }
}
