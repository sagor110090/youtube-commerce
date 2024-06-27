<?php

namespace App\Livewire\Products;

use Carbon\Carbon;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class Table extends DataTableComponent
{
    use LivewireAlert;

    protected $listeners = [
        'productsCreated' => '$refresh',
        'productsUpdated' => '$refresh',
        'productsDeleted' => '$refresh',
        'confirmed',
        'cancelled',
    ];

    protected $model = Product::class;

    public $deleteId = null;

    public function configure(): void
    {
        $this->setSearchLazy();
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable(),

            Column::make('Name', 'name')->searchable()->sortable(),
            Column::make('Description', 'description')->searchable()->sortable(),
            // Column::make('Image', 'image')->searchable()->sortable(),
            Column::make('Image', 'image')
                ->format(function ($value, $row, Column $column) {
                    $image = asset('storage/' . $value);
                    return "<img src='$image' class='w-10 h-10'>";
                })->html()
                ->searchable()
                ->sortable(),
            Column::make('Price', 'price')->searchable()->sortable(),
            Column::make('Category', 'category_id')
                ->format(function ($value, $row, Column $column) {
                    return $row->category->name;
                })
                ->searchable()->sortable(),
            Column::make('Updated at', 'updated_at')
                ->format(function ($value, $row, Column $column) {
                    return Carbon::parse($value)->diffForHumans();
                })
                ->sortable(),

            Column::make('Actions')
                ->label(
                    function ($row, Column $column) {
                        $delete = '<button class="rounded-lg bg-red-500 px-4 py-2 text-white mr-2" wire:click="triggerConfirm(' . $row->id . ')">Delete</button>';
                        $edit = '<button class="rounded-lg bg-blue-500 px-4 py-2 text-white mr-2" wire:click="edit(' . $row->id . ')">Edit</button>';

                        // return  $delete;
                        return $edit . $delete;
                    }
                )->html(),

        ];
    }

    // edit
    public function edit($id)
    {
        $this->dispatch('openModal', component: 'products.edit', arguments: ['id' => $id]);
    }

    public function triggerConfirm($id)
    {
        $this->deleteId = $id;
        $this->confirm('Do you want to delete?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'confirmed',
            'onCancelled' => 'cancelled',
        ]);
    }

    public function confirmed()
    {
        $this->destroy();
        $this->alert('success', 'Deleted successfully.');
    }

    public function cancelled()
    {
        $this->alert('info', 'Understood');
    }

    public function destroy()
    {
        if ($this->deleteId) {
            $record = Product::where('id', $this->deleteId);
            $record->delete();
            $this->dispatch('productsDeleted');
        }
    }

    // approve
    public function approve($id)
    {
        $record = Product::find($id);
        $record->update([
            'is_active' => !$record->is_active,
        ]);
        $this->dispatch('productsUpdated');
    }
}
