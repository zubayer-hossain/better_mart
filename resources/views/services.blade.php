@extends('layouts.app')
@section('title', 'Services :: BetterMart')

@section('content')
    <style>
        .youtube-vid iframe {
            width: 100% !important;
            height: 315px !important;
        }
        @media (max-width: 450px) {
            .youtube-vid iframe {
                height: 250px !important;
            }
        }
    </style>
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">Services</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="about-us-area pt-120">
        <div class="container">
            @foreach($services as $service)
                <div class="row mb-5">
                    <div class="col-lg-6 col-md-6">
                        <div class="about-us-content">
                            <h3>{{ $service->title }}</h3>
                            <p> {{ $service->description }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 my-auto">
                        @if(isset($service->image))
                            <div class="about-us-logo mb-3">
                                <img style="width: 100%; height: auto;" src="{{ asset($service->image) }}"
                                     alt="{{ $service->title }}">
                            </div>
                        @endif

                        @if(isset($service->youtube_link))
                            <div class="youtube-vid">
                                {!! $service->youtube_link !!}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@section('scripts')

@stop

@endsection
