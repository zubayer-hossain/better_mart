@extends('layouts.app')
@section('title', 'About Us :: BetterMart')

@section('content')
    <style>
        .download-vcard a {
            display: inline-block;
            font-size: 16px;
            font-weight: 500;
            color: #fff;
            line-height: 1;
            background-color: #ff2f2f;
            border: solid 2px #ff2f2f;
            padding: 18px 50px 17px;
            width: 100%;
        }

        .download-vcard a:hover {
            background-color:  #000000;
            border: solid 2px #000000;
        }
    </style>
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">about us</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="about-us-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="about-us-logo">
                        <a href="#"><img style="margin: 5px 0 0;width: 225px; height: 100px;"
                                         src="{{ asset('uploads/logo.png') }}" alt="logo"></a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="about-us-content">
                        <h3>Introduction</h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book. It has survived not only five
                            centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                            passages, and more recently with desktop publishing software like Aldus PageMaker including
                            versions of Lorem Ipsum.
                        </p>
                        <div class="signature">
                            <h2>Md. Rejaul Islam</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="service-area pb-120">
        <div class="container">
            <div class="service-wrap-border service-wrap-padding-3">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 service-border-1">
                        <div class="single-service-wrap-2 mb-30">
                            <div class="service-icon-2 icon-red">
                                <i class="icon-cursor"></i>
                            </div>
                            <div class="service-content-2">
                                <h3>Free Shipping</h3>
                                <p>Oders over $99</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 service-border-1 service-border-1-none-md">
                        <div class="single-service-wrap-2 mb-30">
                            <div class="service-icon-2 icon-red">
                                <i class="icon-refresh "></i>
                            </div>
                            <div class="service-content-2">
                                <h3>90 Days Return</h3>
                                <p>For any problems</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 service-border-1">
                        <div class="single-service-wrap-2 mb-30">
                            <div class="service-icon-2 icon-red">
                                <i class="icon-credit-card "></i>
                            </div>
                            <div class="service-content-2">
                                <h3>Secure Payment</h3>
                                <p>100% Guarantee</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="single-service-wrap-2 mb-30">
                            <div class="service-icon-2 icon-red">
                                <i class="icon-earphones "></i>
                            </div>
                            <div class="service-content-2">
                                <h3>24h Support</h3>
                                <p>Dedicated support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="team-area pb-90">
        <div class="container">
            <div class="section-title mb-45 text-center">
                <h2>Team Members</h2>
            </div>
            <div class="row">
                @foreach($teams as $team)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="team-wrapper mb-30">
                            <div class="team-img">
                                <img style="height: 400px"
                                     src="{{ isset($team->image) ? asset($team->image) :  asset('uploads/no-photo.jpg')}}"
                                     alt="Team member image">
{{--                                <div class="team-action">--}}
{{--                                    <a class="facebook" href="#">--}}
{{--                                        <i class="social_facebook"></i>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>
                            <div class="team-content text-center">
                                <h4>{{ $team->name  ?? '' }}</h4>
                                <span>{{ $team->designation  ?? '' }}</span>
                                <span>({{ $team->department  ?? '' }})</span><br>
                                <span> Mobile: {{ $team->mobile  ?? '' }} <br> Email: {{ $team->email  ?? '' }}</span>
                                @if (isset($team->vcard))
                                    <div class="text-center download-vcard mt-4">
                                        <a href="{{ asset($team->vcard) }}" download="{{ $team->name }}_visiting_card.jpeg">Download Visiting Card</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="testimonial-area bg-gray-3 pt-115 pb-115">
        <div class="container">
            <div class="section-title mb-45 text-center">
                <h2>Reviews</h2>
            </div>
            <div class="testimonial-active-2 dot-style-2 dot-style-2-position-static">
                @foreach($reviews as $review)
                    <div class="single-testimonial-2 text-center">
                        <div class="testimonial-img">
                            <img class="rounded-circle" alt="" style="height: 200px;"
                                 src="{{ isset($review->image) ? asset($review->image) :  asset('uploads/no-photo.jpg')}}">
                        </div>
                        <p>{{ $review->comment  ?? '' }}</p>
                        <div class="client-info">
                            <h5>{{ $review->name  ?? '' }}</h5>
                            <div class="d-flex justify-content-center mt-3">
                                <img src="{{ asset('uploads/review_star/'.$review->rating.'.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@section('scripts')

@stop

@endsection
