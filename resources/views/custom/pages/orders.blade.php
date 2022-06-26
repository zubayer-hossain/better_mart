@extends(backpack_view('blank'))

@php
    $module_action_type = $module_action_type ?? 'create';
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Orders' => backpack_url('order'),
        Route::is('order.edit') ? 'Edit' : ( $module_action_type === 'show' ? 'Preview' : 'Create' ) => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? ($module_action_type === 'show' ? 'Preview' : trans('backpack::crud.'.(Route::is('order.edit') ? 'edit' : 'add'))) .' '.$crud->entity_name !!}
                .</small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div id="app">
        <order-create
            url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
            axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
            method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
            user_id="{{ backpack_auth()->id() }}"
            order_data="{{json_encode($order_data ?? new \stdClass())}}"
            all_customer="{{json_encode($all_customer ?? new \stdClass())}}"
            all_product="{{json_encode($all_product ?? new \stdClass())}}"
            all_status="{{json_encode($all_status ?? new \stdClass())}}"
            module_action_type="{{ $module_action_type ?? 'create' }}"
        ></order-create>
    </div>
@endsection

@section('after_scripts')
    <script src="{{  mix('js/app.js') }}"></script>
@endsection
