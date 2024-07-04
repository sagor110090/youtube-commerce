<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title,On};
use App\Models\Category; 
use Jantinnerezo\LivewireAlert\LivewireAlert;


new #[Layout('layouts.frontend')] #[Title('Home')] class extends Component {

    use LivewireAlert;
    #[On('search')]
    public function search($value){
        $this->searchProduct = $value;
    }

    public $searchProduct = '';
 

    
    
    
    

    public function with()
    {
        $categories = Category::when($this->searchProduct,function($q1){

            $q1->with('products',function ($q) {
                $q->where('name' , 'like', '%%'.$this->searchProduct.'%%');
            });

        })->get();

        return [
            'categories' => $categories
        ];

    }

    public function addToCart($product_id,$product_name,$product_price){
        Cart::add($product_id, $product_name, 1, $product_price);
        $this->alert('success', 'Product added to cart');          
    }



}; ?>

<div>

    

    @foreach ($categories as $category)

    @if ($category->products->count()>0)
    <!-- fashion section start -->
    <div class="fashion_section" id="{{ Str::slug($category->name) }}">
        <div id="main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <h1 class="fashion_taital">{{ $category->name }} </h1>
                        <div class="fashion_section_2">
                            <div class="row">
                                @foreach ($category->products as $product)
                                <div class="col-lg-4 col-sm-4">
                                    <div class="box_main">
                                        <h4 class="shirt_text">{{ $product->name }}</h4>
                                        <p class="price_text">Price <span style="color: #262626;">$
                                                {{ $product->price }}</span></p>
                                        <div class="tshirt_img"><img src="{{ Storage::url($product->image) }}">
                                        </div>
                                        <div class="btn_main">
                                            <div class="buy_bt"><a href="#"
                                                    wire:click='addToCart("{{$product->id}}" , "{{$product->name}}" , "{{$product->price}}")'>Add to cart</a></div>
                                            <div class="seemore_bt"><a href="#">See More</a></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- fashion section end -->
    @endif

    @endforeach

    


</div>
