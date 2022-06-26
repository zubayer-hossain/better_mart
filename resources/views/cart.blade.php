@extends('layouts.app')
@section('title', 'Cart :: BetterMart')

@section('content')
    <style>
        .cart-plus-minus-box{
            width: 50px!important;
        }
        .cart-table-content table tbody>tr td.product-quantity {
            width: 150px;
        }
        .grand-totall button {
            display: inline-block;
            font-size: 16px;
            font-weight: 500;
            color: #fff;
            line-height: 1;
            background-color: #000000;
            padding: 18px 50px 17px;
            width: 100%;
        }
        .grand-totall button:hover {
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
                    <li class="active">Cart</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-115 pb-120">
        <div class="container">
            <h3 class="cart-page-title">Your cart items</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12" >
                    <div class="table-content table-responsive cart-table-content" id="cart_table">
                            <table style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $total = 0 @endphp
                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr id="product_tr_{{ $id }}">
                                            <td class="product-thumbnail">
                                                <a  href="/product-details/{{ $details['product_code']  ?? '' }}"><img height="65" width="85" src="{{ asset($details['image']) }}"  alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="/product-details/{{ $details['product_code']  ?? '' }}">{{ $details['name']  ?? '' }}</a></td>
                                            <td class="product-price-cart"><span class="amount">৳ {{ $details['price']  ?? '' }}</span></td>
                                            <td class="product-quantity pro-details-quality mx-auto">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="updateCart({{ $id }}, '-')">-</button>
                                                    </div>
                                                    <div>
                                                        <input class="cart-plus-minus-box text-center" type="text" id="qtyButton_{{ $id }}" onchange="updateCart({{ $id }}, '')"
                                                               value="{{ $details['quantity']  ?? '' }}">
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="updateCart({{ $id }}, '+')">+</button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">{{ $details['quantity']  ?? '' }} × ৳ {{ $details['price']  ?? '' }}</td>
                                            <td class="product-remove my-auto">
                                                <button class="btn btn-danger btn-sm" style="height: fit-content!important;"
                                                        type="button" onclick="removeFromCart({{ $id }}, 'cart')">×
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">No products in the cart</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    <form method="POST" action="{{ route('place.booking') }}">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-lg-8 col-md-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-clear">
                                        <a href="/#products_block">Continue Shopping</a>
                                    </div>
                                </div>
                                <div class="billing-info-wrap mr-50">
                                    <h3>Billing Details</h3>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="billing-info mb-20">
                                                <label>Name <abbr class="required" title="required">*</abbr></label>
                                                <input value="{{ old('name', $user->name) }}" type="text" name="name" placeholder="Enter your full name" >
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="billing-info mb-20">
                                                <label>Mobile <abbr class="required" title="required">*</abbr></label>
                                                <input value="{{ old('mobile', $user->mobile) }}" type="text"  placeholder="Enter your mobile no, Ex: 018XXXXXXXX" name="mobile">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="billing-info mb-20">
                                                <label>Email</label>
                                                <input value="{{ old('email', $user->email) }}" type="email" placeholder="Enter your email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="billing-info mb-20">
                                                <label>Full Address <abbr class="required" title="required">*</abbr></label>
                                                <textarea  placeholder="Enter your full address " name="full_address">{{ old('address', $user->address) }}</textarea>
                                            </div>
                                        </div>

                                        <input type="hidden" name="cart" value="{{ json_encode(session('cart')) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12 mt-4" >
                                <div class="grand-totall">
                                    <div class="title-wrap mb-4">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                    </div>
                                    <h4 class="grand-totall-title" id="cart_table_total">Grand Total <span>৳ {{ $total }} Tk</span></h4>
                                    @if(session('cart'))
                                        <button type="submit">Place Order</button>
                                    @else
                                        <a href="#">Place Order</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@section('scripts')

@stop

@endsection
