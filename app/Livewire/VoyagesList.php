<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Voyage;
use Livewire\WithPagination;

class VoyagesList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'departure_time';
    public $sortDirection = 'asc';
    public $minPrice = '';
    public $maxPrice = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'sortField' => ['except' => 'departure_time'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 
            'minPrice', 
            'maxPrice', 
            'dateFrom', 
            'dateTo',
            'sortField',
            'sortDirection'
        ]);
    }

    public function formatRemainingTime($departureTime)
    {
        $departureTime = $departureTime->copy()->timezone(config('app.timezone'));
        $closingTime = $departureTime->copy()->subDay();
        
        if ($closingTime->isPast()) {
            return ['text' => 'Closed', 'color' => 'text-red-600'];
        }
        
        $seconds = now()->diffInSeconds($closingTime, false);
        
        if ($seconds <= 0) {
            return ['text' => 'Closed', 'color' => 'text-red-600'];
        }
        
        $days = floor($seconds / (3600 * 24));
        $hours = floor(($seconds % (3600 * 24)) / 3600);
        
        return [
            'text' => trim(sprintf('%dd %dh', $days, $hours)),
            'color' => $days > 0 ? 'text-green-600' : 'text-yellow-600'
        ];
    }

    public function render()
    {
        $voyages = Voyage::with(['departurePort', 'arrivalPort', 'vessel'])
            ->active()
            ->when($this->search, function($query) {
                $query->where('voyage_number', 'like', '%'.$this->search.'%')
                      ->orWhereHas('departurePort', function($q) {
                          $q->where('name', 'like', '%'.$this->search.'%');
                      })
                      ->orWhereHas('arrivalPort', function($q) {
                          $q->where('name', 'like', '%'.$this->search.'%');
                      });
            })
            ->when($this->minPrice, function($query) {
                $query->where('price_per_seat', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function($query) {
                $query->where('price_per_seat', '<=', $this->maxPrice);
            })
            ->when($this->dateFrom, function($query) {
                $query->where('departure_time', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($query) {
                $query->where('departure_time', '<=', $this->dateTo);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.voyages-list', [
            'voyages' => $voyages
        ]);
    }
}