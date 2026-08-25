<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\Car;
use Livewire\Component as LivewireComponent;
use Livewire\WithPagination;

class CarList extends LivewireComponent
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; // all, available, rented, maintenance, hidden
    public $selectedCars = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function resetSelection()
    {
        $this->selectedCars = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCars = $this->getCarsQuery()
                ->pluck('id')
                ->map(fn($id) => (string)$id)
                ->toArray();
        } else {
            $this->selectedCars = [];
        }
    }

    public function toggleStatus(Car $car)
    {
        // Cycle status: available -> maintenance -> hidden -> available
        $current = $car->status;
        $next = 'available';

        if ($current === 'available') {
            $next = 'maintenance';
        } elseif ($current === 'maintenance') {
            $next = 'hidden';
        } elseif ($current === 'hidden') {
            $next = 'available';
        } else {
            // If rented, let it stay or go to available
            $next = 'available';
        }

        $car->update(['status' => $next]);
        session()->flash('success', "{$car->name} status changed to " . ucfirst($next) . ".");
    }

    public function deleteCar(Car $car)
    {
        $car->delete(); // Soft delete
        session()->flash('success', "Vehicle {$car->name} deleted successfully.");
        $this->resetSelection();
    }

    // Bulk Actions
    public function bulkMarkAvailable()
    {
        if (empty($this->selectedCars)) return;

        Car::whereIn('id', $this->selectedCars)->update(['status' => 'available']);
        session()->flash('success', count($this->selectedCars) . ' vehicle(s) set to Available.');
        $this->resetSelection();
    }

    public function bulkMarkHidden()
    {
        if (empty($this->selectedCars)) return;

        Car::whereIn('id', $this->selectedCars)->update(['status' => 'hidden']);
        session()->flash('success', count($this->selectedCars) . ' vehicle(s) set to Hidden.');
        $this->resetSelection();
    }

    public function bulkDelete()
    {
        if (empty($this->selectedCars)) return;

        Car::whereIn('id', $this->selectedCars)->delete();
        session()->flash('success', count($this->selectedCars) . ' vehicle(s) deleted successfully.');
        $this->resetSelection();
    }

    private function getCarsQuery()
    {
        $query = Car::query();

        // Search Filter
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('plate_number', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%');
            });
        }

        // Tab Filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return $query->latest();
    }

    public function render()
    {
        $cars = $this->getCarsQuery()->paginate(15);

        return view('livewire.admin.car-list', [
            'cars' => $cars,
        ]);
    }
}
