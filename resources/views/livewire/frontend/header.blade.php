<?php

use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {
    public $categoriesHeader = [];
    public $search = '';

    public function mount()
    {
        $this->categoriesHeader = Category::select('name')->get();
    }

    public function productSearch(){
        $this->dispatch('search',$this->search);
    }
}; ?>

<div class="banner_bg_main" style="margin-bottom: 50px;">
    <!-- header top section start -->
    <div class="container">
        <div class="header_section_top">
            <div class="row">
                <div class="col-sm-12">
                    <div class="custom_menu">
                        <ul>
                            <li><a href="#">Best Sellers</a></li>
                            <li><a href="#">Gift Ideas</a></li>
                            <li><a href="#">New Releases</a></li>
                            <li><a href="#">Today's Deals</a></li>
                            <li><a href="#">Customer Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header top section start -->
    <!-- logo section start -->
    <div class="logo_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="logo"><a href="{{ url('/') }}"><img
                                src="{{ asset('frontend/images/logo.png') }}"></a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- logo section end -->
    <!-- header section start -->
    <div class="header_section" style="    margin-bottom: 46px;">
        <div class="container">
            <div class="containt_main">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="index.html">Home</a>
                    <a href="fashion.html">Fashion</a>
                    <a href="electronic.html">Electronic</a>
                    <a href="jewellery.html">Jewellery</a>
                </div>
                <span class="toggle_icon" onclick="openNav()"><img
                        src="{{ asset('frontend/images/toggle-icon.png') }}"></span>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Category
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach ($categoriesHeader as $categoryss)
                            <a class="dropdown-item" href="#{{ Str::slug($categoryss->name) }}">{{ $categoryss->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="main">
                    <form wire:submit='productSearch'>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search products" wire:model='search'>
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit"
                                style="background-color: #f26522; border-color:#f26522 ">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                </div>
                <div class="header_box">
                    <div class="login_menu">
                        <ul>
                            <li><a href="#">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span class="padding_10">Cart</span></a>
                            </li>
                            <li><a href="#">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="padding_10">user</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header section end -->

</div>
