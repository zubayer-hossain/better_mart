@extends('layouts.app')
@section('title', 'Home :: BetterMart')
@section('content')
    <style>
        .single-product-wrap {
            border: solid #8080802b 1px;
        }

        .product-content-wrap-3 {
            padding: 0px 10px 15px 10px;
        }

        .product-content-wrap-3 {
            padding: 10px 10px 15px 10px !important;
        }

        .section-title-6 h2 {
            text-transform: none !important;
        }

        .product-details-content .product-details-meta ul li span {
            width: 25%;
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
        @media (max-width: 450px) {
            .hm9-hero-slider-img img {
                height: 250px !important;
            }
            .slick-arrow{
                margin-top: 115px;
            }
        }
    </style>
    <!-- mini cart start -->
    {{--    @php dump(session()->get('cart', [])) @endphp--}}
    <div class="slider-area bg-gray-8">
        <div class="container">
            <div class="hero-slider-active-2 nav-style-1 nav-style-1-modify-2 nav-style-1-blue">
                @foreach($featured_products as $product)
                    <div class="single-hero-slider single-hero-slider-hm9 single-animation-wrap">
                        <div class="row slider-animated-1">
                            <div class="col-lg-5 col-md-5 col-12 col-sm-6">
                                <div class="hero-slider-content-6 slider-content-hm9">
                                    <h5 class="animated mb-1">Featured Product</h5>
                                    <h2 class="animated font-weight-bold">{{ $product->name ?? ''  }}</h2>
                                    <p class="animated">{!! $product->description !!}</p>
                                    <div class="btn-style-1">
                                        <a class="animated btn-1-padding-4 btn-1-blue btn-1-font-14" href="/product-details/{{ $product->product_code ?? '' }}">Explore
                                            Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-12 col-sm-6">
                                <div class="hm9-hero-slider-img">
                                    <img class="animated" style="height: 500px" src="{{ isset($product->images) && count($product->images) > 0 ? asset($product->images[0]) :  asset('uploads/no-photo.jpg')}}"
                                         alt="{{ $product->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="service-area">
        <div class="container">
            <div class="service-wrap service-wrap-hm9">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="single-service-wrap mb-30">
                            <div class="service-icon service-icon-blue">
                                <i class="icon-cursor"></i>
                            </div>
                            <div class="service-content">
                                <h3>Free Shipping</h3>
                                <span>Orders over $100</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="single-service-wrap mb-30">
                            <div class="service-icon service-icon-blue">
                                <i class="icon-reload"></i>
                            </div>
                            <div class="service-content">
                                <h3>Free Returns</h3>
                                <span>Within 30 days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="single-service-wrap mb-30">
                            <div class="service-icon service-icon-blue">
                                <i class="icon-lock"></i>
                            </div>
                            <div class="service-content">
                                <h3>100% Secure</h3>
                                <span>Payment Online</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="single-service-wrap mb-30">
                            <div class="service-icon service-icon-blue">
                                <i class="icon-tag"></i>
                            </div>
                            <div class="service-content">
                                <h3>Best Price</h3>
                                <span>Guaranteed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="about-us-area pt-60 pb-60 bg-gray-8">-->
    <!--    <div class="container">-->
    <!--        <div class="about-us-content-3 text-center">-->
    <!--            <h3>Welcome To <span>Proactive Technical Service Center</span></h3>-->
    <!--            <p>Your one stop solution for all electronics need </p>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="products_block" class="product-area pt-115 pb-120">
        <div class="container">
            <div class="section-title-6 section-title-6-xs mb-60 text-center">
                <h2>All Products <small id="categoryName"></small></h2>
            </div>
            <div class="row">
                @forelse($products as $product)
                    <div class="custom-col-5">
                        <div class="single-product-wrap mb-60">
                            <div class="product-img product-img-zoom mb-15">
                                <a href="/product-details/{{ $product->product_code ?? '' }}">
                                    <img height="200"
                                         src="{{ isset($product->images) && count($product->images) > 0 ? asset($product->images[0]) :  asset('uploads/no-photo.jpg')}}"
                                         alt="{{ $product->name }}">
                                </a>
                                <div class="product-action-2 tooltip-style-2">
                                    <button type="button" title="Quick View"
                                            onclick="openQuickViewModal({{ $product->id }})"><i
                                            class="icon-size-fullscreen icons"></i></button>
                                </div>
                            </div>
                            <div class="product-content-wrap-3">
                                <h3 class="mrg-none"><a class="blue"
                                                        href="/product-details/{{ $product->product_code ?? '' }}">{{ $product->name ?? ''  }}</a>
                                </h3>
                                <div class="product-price-4 mt-2">
                                    <span>৳  {{ $product->selling_price ?? ''  }} Tk</span>
                                </div>
                            </div>
                            <div class="product-content-wrap-3 product-content-position-2 pro-position-2-padding-dec">
                                <h3 class="mrg-none"><a class="blue"
                                                        href="/product-details/{{ $product->product_code ?? ''  }}">{{ $product->name ?? ''  }}</a>
                                </h3>
                                <div class="product-price-4 mt-2">
                                    <span>৳  {{ $product->selling_price ?? ''  }} Tk</span>
                                </div>
                                <div class="pro-add-to-cart-2">
                                    <button onclick="addToCart({{ $product->id ?? '' }})" title="Add to Cart">Add To
                                        Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="custom-col-12 text-center" style="width: 100%">
                        <img style="width: 500px" src="{{ asset('uploads/no-product.png') }}" alt="">
                    </div>
                @endforelse
            </div>
            <div class="d-none more-product-btn text-center">
                <a href="#">More Product</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Product Quick View</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-12 col-sm-12">
                            <div class="tab-content quickview-big-img">
                                <div id="qv_ifProductImage" class="tab-pane fade active">
                                    <img height="440" width="367" src="" alt="Product Image">
                                </div>
                                <div id="qv_ifNoImage" class="tab-pane fade active">
                                    <img height="440" width="367" src="{{ asset('uploads/no-photo.jpg') }}"
                                         alt="Product Image">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 col-12 col-sm-12">
                            <div class="product-details-content quickview-content">
                                <h2 id="qv_name"></h2>
                                <p id="qv_description" class="mt-3"></p>
                                <div class="pro-details-price">
                                    <span id="qv_price" class="new-price"></span>
                                    {{--                                    <span class="old-price">$95.72</span>--}}
                                </div>
                                <div class="product-details-meta">
                                    <ul>
                                        <li class="d-flex">
                                            <span>Product Code: </span><h5 id="qv_product_code"></h5>
                                        </li>
                                        <li class="d-flex">
                                            <span>Categories: </span> <h5 id="qv_category"></h5>
                                        </li>
                                        <li class="d-flex">
                                            <span>Brand: </span> <h5 id="qv_brand"></h5>
                                        </li>
                                        <li class="d-flex">
                                            <span>Model: </span> <h5 id="qv_model"></h5>
                                        </li>
                                    </ul>
                                </div>
                                {{--                                <div class="pro-details-action-wrap mt-3">--}}
                                {{--                                    <div class="pro-details-add-to-cart">--}}
                                {{--                                        <a title="Add to Cart" href="#">Add To Cart </a>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@section('scripts')
    <script>
        function openQuickViewModal(productId) {
            $.ajax({
                type   : "GET",
                url    : "{{url('quick-view-product-details/')}}/" + productId,
                success: function (data) {
                    $('#qv_name').html(data.name);
                    $('#qv_description').html(data.description);
                    $('#qv_price').html('৳ ' + data.selling_price + ' Tk');
                    $('#qv_product_code').html(data.product_code);
                    $('#qv_category').html(data.category.name);
                    $('#qv_brand').html(data.brand.name);
                    $('#qv_model').html(data.product_model.name);
                    $('#quickViewModal').modal('show');
                    if (data.images === null || data.images.length === 0) {
                        $('#qv_ifProductImage').hide();
                        $('#qv_ifNoImage').addClass('show').show();
                    } else {
                        $('#qv_ifProductImage img').attr('src', data.images[0]);
                        $('#qv_ifProductImage').addClass('show').show();
                        $('#qv_ifNoImage').hide();
                    }

                },
                error  : function (data) {
                    console.log(data);
                    toastr.error("Something went wrong.");
                }
            });
        }
    </script>
@stop

@endsection
