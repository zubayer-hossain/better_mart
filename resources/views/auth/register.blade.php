@extends('layouts.app')
@section('title', 'Register :: Laravel Ecommerce')

@section('content')
    <style>
        .required{
            color: red;
        }
    </style>
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">register </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-register-area pt-80 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#register">
                                <h4> register </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="register" class="tab-pane active">
                                <div class="login-form-container">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div>
                                                <label>Name <span class="required">*</span></label>
                                                <input value="{{ old('name', '') }}" type="text" name="name" placeholder="Enter your full name" >
                                            </div>
                                            <div >
                                                <label>Mobile </label>
                                                <input value="{{ old('mobile', '') }}" type="text"  placeholder="Enter your mobile no, Ex: 018XXXXXXXX" name="mobile">
                                            </div>
                                            <div>
                                                <label>Email  <span class="required">*</span></label>
                                                <input value="{{ old('email', '') }}" type="email" placeholder="Enter your email" name="email">
                                            </div>
                                            <div>
                                                <label>Password <span class="required">*</span></label>
                                                <input type="password" placeholder="Enter your password" name="password">
                                            </div>
                                            <div>
                                                <label>Confirm Password <span class="required">*</span></label>
                                                <input type="password" placeholder="Confirm Password" name="password_confirmation">
                                            </div>
                                            <div class="button-box">
                                                <button type="submit">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
