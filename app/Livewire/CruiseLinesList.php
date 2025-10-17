<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CruiseLine;

class CruiseLinesList extends Component
{
    public $search = '';

    public function render()
    {
        $cruiseLines = CruiseLine::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        return view('livewire.cruise-lines-list', compact('cruiseLines'));
    }
}
