@extends(backpack_view('blank'))

{{--@php--}}
{{--    $widgets['before_content'][] = [--}}
{{--        'type'          => 'progress_white',--}}
{{--        'class'         => 'card mb-2 text-center',--}}
{{--        'value'         => '11',--}}
{{--        'description'   => 'Total Customers',--}}
{{--    ];--}}
{{--    $widgets['before_content'][] = [--}}
{{--        'type'          => 'progress_white',--}}
{{--        'class'         => 'card mb-2 text-center',--}}
{{--        'value'         => '11',--}}
{{--        'description'   => 'Total Sell',--}}
{{--    ];--}}
{{--@endphp--}}

@section('content')
    <div class="row container-fluid animated fadeIn">
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-2 text-center">
                <div class="card-body">
                    <div class="text-value">{{ \App\Models\User::whereNull('role_id')->count() }}</div>
                    <div>Total Customers</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-2 text-center">
                <div class="card-body">
                    <div class="text-value">{{ \App\Models\Order::sum('total_price') }} Tk</div>
                    <div>Total Sell</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-2 text-center">
                <div class="card-body">
                    <div class="text-value">{{ \App\Models\Order::count() }}</div>
                    <div>Total Orders</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-2 text-center">
                <div class="card-body">
                    <div class="text-value">{{ \App\Models\Product::count() }}</div>
                    <div>Total Products</div>
                </div>
            </div>
        </div>
    </div>
@endsection
