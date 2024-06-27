<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends ModalComponent
{

    use LivewireAlert, WithFileUploads;

    public $name, $description, $image, $price, $category_id;

    public $categories;


    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.products.create');
    }





    public function store()
    {
        $this->validate([

            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        $this->image = $this->image->store('products', 'public');

        // dd($this->image, $this->name, $this->description, $this->price, $this->category_id);

        Product::create([

            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'category_id' => $this->category_id
        ]);

        $this->alert('success', 'Product Created Successfully', [
            'position' =>  'top-end',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false
        ]);

        $this->closeModalWithEvents(['productsCreated']);
    }
}
