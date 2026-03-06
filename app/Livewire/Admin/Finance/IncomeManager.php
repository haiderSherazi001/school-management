<?php

namespace App\Livewire\Admin\Finance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Income;

#[Layout('layouts.app')]
class IncomeManager extends Component
{
    use WithPagination;

    public $title, $category, $amount, $income_date, $description;
    public $income_id = null;
    public $isEditing = false;
    public $search = '';

    public $categories = [
        'Donations & Grants', 
        'Property Rent (Canteen, Ground)', 
        'Scrap & Asset Sales', 
        'Bank Interest', 
        'Other'
    ];

    public function mount()
    {
        $this->income_date = date('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'income_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Income::updateOrCreate(
            ['id' => $this->income_id],
            [
                'title' => $this->title,
                'category' => $this->category,
                'amount' => $this->amount,
                'income_date' => $this->income_date,
                'description' => $this->description,
            ]
        );

        session()->flash('success', $this->isEditing ? 'Income record updated.' : 'Income logged successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $income = Income::findOrFail($id);
        $this->income_id = $income->id;
        $this->title = $income->title;
        $this->category = $income->category;
        $this->amount = $income->amount;
        $this->income_date = $income->income_date->format('Y-m-d');
        $this->description = $income->description;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        Income::findOrFail($id)->delete();
        session()->flash('success', 'Income record deleted.');
    }

    public function resetFields()
    {
        $this->reset(['title', 'category', 'amount', 'description', 'income_id']);
        $this->income_date = date('Y-m-d');
        $this->isEditing = false;
    }

    public function render()
    {
        $incomes = Income::where('title', 'like', '%' . $this->search . '%')
            ->orderBy('income_date', 'desc')
            ->paginate(10);

        return view('livewire.admin.finance.income-manager', [
            'incomes' => $incomes
        ]);
    }
}