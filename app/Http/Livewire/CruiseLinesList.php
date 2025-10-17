<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CruiseLine;
use Livewire\WithPagination;
use App\Models\Vessel;

class CruiseLinesList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'departure_time';
    public $sortDirection = 'asc';
    public $minPrice = '';
    public $maxPrice = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $vesselType = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'dateFrom' => ['except' => '', 'as' => 'from'], 
        'dateTo' => ['except' => '', 'as' => 'to'],
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

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function formatRemainingTime($departureTime)
    {
        $departureTime = $departureTime->copy()->timezone(config('app.timezone'));
        $closingTime = $departureTime->copy()->subDay(); // круиз закрывается за 24 часа до departure
        
        if ($closingTime->isPast()) {
            return ['text' => 'Closed', 'color' => 'text-red-600'];
        }
        
        $seconds = now()->diffInSeconds($closingTime, false); // false - чтобы получить отрицательное значение если прошло
        
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

    public function onImageError($cruiseId)
    {
        $this->dispatch('imageError', $cruiseId);
    }

    public function render()
    {
        $cruiseLines = CruiseLine::query()
            ->active()
            ->with('vessel') 
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->vesselType, function ($query) {
                $query->whereHas('vessel', function($q) {
                    $q->where('type', $this->vesselType);
                });
            })
            ->when($this->minPrice, function ($query) {
                $query->where('price_per_seat', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function ($query) {
                $query->where('price_per_seat', '<=', $this->maxPrice);
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('departure_time', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('departure_time', '<=', $this->dateTo);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $vesselTypes = Vessel::distinct('type')->pluck('type');

        return view('livewire.cruise-lines-list', [
            'cruiseLines' => $cruiseLines,
            'vesselTypes' => $vesselTypes
        ]);
    }


}