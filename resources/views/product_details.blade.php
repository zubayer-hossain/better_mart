@extends('layouts.app')
@section('title', 'Product Details :: BetterMart')

@section('content')
    <style>
        .product-details-content .product-details-meta ul li span {
            width: 25%;
        }
        .mfp-bottom-bar {
            display: none;
        }
        .product-details-content .pro-details-action-wrap .pro-details-add-to-cart button {
            display: inline-block;
            font-size: 16px;
            font-weight: 500;
            color: #fff;
            line-height: 1;
            background-color: #000000;
            padding: 18px 50px 17px;
        }

        .product-details-content .pro-details-action-wrap .pro-details-add-to-cart button:hover {
            background-color: #ff2f2f;
            border: solid 2px #ff2f2f;
        }
    </style>
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">Product Details </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-details-area pt-120 pb-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">
                        <div class="pro-dec-big-img-slider">
                            @forelse($product->images as $image)
                                <div class="easyzoom-style">
                                    <div class="easyzoom easyzoom--overlay">
                                        <a href="{{ asset($image) }}">
                                            <img width="1200" height="550" src="{{ asset($image) }}" alt="">
                                        </a>
                                    </div>
                                    <a class="easyzoom-pop-up img-popup" href="{{ asset($image) }}"><i class="icon-size-fullscreen"></i></a>
                                </div>
                            @empty
                                <div class="easyzoom-style">
                                    <div class="easyzoom easyzoom--overlay">
                                        <a href="{{ asset('images/product-details/b-large-1.jpg') }}">
                                            <img src="{{ asset('images/product-details/b-large-1.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <a class="easyzoom-pop-up img-popup" href="{{ asset('images/product-details/b-large-1.jpg') }}"><i class="icon-size-fullscreen"></i></a>
                                </div>
                            @endforelse
                        </div>
                        <div class="product-dec-slider-small product-dec-small-style1">
                            @forelse($product->images as $image)
                                <div class="product-dec-small">
                                    <img height="100" width="100" src="{{ asset($image) }}" alt="">
                                </div>
                            @empty
                                <div class="product-dec-small active">
                                    <img src="{{ asset('images/product-details/small-1.jpg') }}" alt="">
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-content pro-details-content-mrg">
                        <h2>{{ $product->name  ?? '' }}</h2>
                        <p class="mt-3">{!! $product->description  ?? '' !!}</p>
                        <div class="pro-details-price">
                            <span class="new-price">৳  {{ $product->selling_price  ?? '' }} Tk</span>
                        </div>
                        <div class="product-details-meta">
                            <ul>
                                <li><span>Product Code:</span> {{ $product->product_code  ?? '' }} </li>
                                <li><span>Category:</span> {{ $product->category->name  ?? '' }}</li>
                                <li><span>Brand: </span> {{ $product->brand->name  ?? '' }}</li>
                                <li><span>Model: </span> {{ $product->productModel->name  ?? '' }}</li>
                            </ul>
                        </div>
                        <div class="pro-details-action-wrap">
                            <div class="pro-details-add-to-cart">
                                <button onclick="addToCart({{ $product->id }})" title="Add to Cart" >Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')

@stop

@endsection
