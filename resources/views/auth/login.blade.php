@extends('layouts.app')
@section('title', 'Login :: Laravel Ecommerce')

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
                    <li class="active">login</li>
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
                            <a class="active" data-toggle="tab" href="#login">
                                <h4> login </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="login" class="tab-pane active">
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
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <input type="hidden" name="user_type" value="customer">
                                            <div>
                                                <label>Email  <span class="required">*</span></label>
                                                <input value="{{ old('email', '') }}" type="email" placeholder="Enter your email" name="email">
                                            </div>
                                            <div>
                                                <label>Password <span class="required">*</span></label>
                                                <input value="{{ old('email', '') }}" type="password" placeholder="Enter your password" name="password">
                                            </div>
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input type="checkbox"  {{ old('remember') ? 'checked' : '' }}>
                                                    <label>Remember me</label>
{{--                                                    @if (Route::has('password.request'))--}}
{{--                                                        <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                                            Forgot Password?--}}
{{--                                                        </a>--}}
{{--                                                    @endif--}}
                                                </div>
                                                <button type="submit">Login</button>
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
