<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends ModalComponent
{
    use LivewireAlert, WithFileUploads;

    public $name, $description, $image, $price, $category_id;
    public $id;
    public $categories;

    public function mount($id)
    {
        $this->id = $id;
        $record = Product::find($id);

        $this->name = $record->name;
        $this->description = $record->description;
        $this->image = $record->image;
        $this->price = $record->price;
        $this->category_id = $record->category_id;

        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.products.edit');
    }




    //update
    public function update()
    {

        $this->validate([

            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        if (!is_string($this->image)) {
            $this->image = $this->image->store('products', 'public');
        }

        $record = Product::find($this->id);
        $record->update([

            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'category_id' => $this->category_id
        ]);

        $this->closeModalWithEvents(['productsUpdated']);
        // $this->reset();
    }
}
