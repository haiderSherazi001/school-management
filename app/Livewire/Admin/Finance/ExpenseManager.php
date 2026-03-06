<?php

namespace App\Livewire\Admin\Finance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Expense;

#[Layout('layouts.app')]
class ExpenseManager extends Component
{
    use WithPagination;

    public $title, $category, $amount, $expense_date, $description;
    public $expense_id = null;
    public $isEditing = false;
    public $search = '';

    public $categories = [
        'Utilities',
        'Maintenance',
        'Supplies',
        'Events',
        'Other'
    ];

    public function mount()
    {
        $this->expense_date = date('Y-m-d');
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
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Expense::updateOrCreate(
            ['id' => $this->expense_id],
            [
                'title' => $this->title,
                'category' => $this->category,
                'amount' => $this->amount,
                'expense_date' => $this->expense_date,
                'description' => $this->description,
            ]
        );

        session()->flash('success', $this->isEditing ? 'Expense updated successfully.' : 'Expense logged successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $this->expense_id = $expense->id;
        $this->title = $expense->title;
        $this->category = $expense->category;
        $this->amount = $expense->amount;
        $this->expense_date = $expense->expense_date->format('Y-m-d');
        $this->description = $expense->description;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        Expense::findOrFail($id)->delete();
        session()->flash('success', 'Expense record deleted.');
    }

    public function resetFields()
    {
        $this->reset(['title', 'category', 'amount', 'description', 'expense_id']);
        $this->expense_date = date('Y-m-d');
        $this->isEditing = false;
    }

    public function render()
    {
        $expenses = Expense::where('title', 'like', '%' . $this->search . '%')
            ->orderBy('expense_date', 'desc')
            ->paginate(10);

        return view('livewire.admin.finance.expense-manager', [
            'expenses' => $expenses
        ]);
    }
}