<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\CruiseLine;
use Livewire\Attributes\Url;

class CruiseSearch extends Component
{
    #[Url] 
    public $search = '';

    public function render()
    {
        return view('livewire.admin.cruise-search', [
            'cruises' => CruiseLine::when($this->search, function($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                })
                ->paginate(10)
        ]);
    }
}