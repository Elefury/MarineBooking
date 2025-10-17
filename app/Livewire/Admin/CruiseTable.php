<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class CruiseTable extends Component {
    public function render() {
        return view('livewire.admin.cruise-table', [
            'cruises' => CruiseLine::paginate(10)
        ]);
    }
}
