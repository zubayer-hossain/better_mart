@extends('layouts.app')
@section('title', 'My Account :: BetterMart')

@section('content')
    <style>
        .required {
            color: red;
        }

        .badge {
            font-size: 95% !important;
        }

        .modal-dialog .modal-body {
            padding: 20px 15px;
        }

        #message-input textarea {
            resize: vertical;
            background: #f7f9ff;
            border: 2px solid #d4d5d9;
            padding: 10px;
            width: 100%;
            font-size: 14px;
            color: #737373;
            margin-right: 15px;
        }

        #message-input button {
            margin-right: 5px;
        }

        /*FeedBack Chatbox*/
        #frame {
            width: 100%;
            height: 65vh;
            min-height: 300px;
            max-height: 500px;
            background: #E6EAEA;
        }

        @media screen and (max-width: 360px) {
            #frame {
                width: 100%;
                height: 100vh;
            }
        }

        #frame .content {
            float: right;
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        @media screen and (max-width: 735px) {
            #frame .content {
                width: 100%;
                min-width: 300px !important;
            }
        }

        @media screen and (min-width: 900px) {
            #frame .content {
                width: 100%;
            }
        }

        #frame .content .contact-profile {
            width: 100%;
            height: 60px;
            line-height: 60px;
            background: #f5f5f5;
        }

        #frame .content .contact-profile img {
            width: 40px;
            border-radius: 50%;
            float: left;
            margin: 9px 12px 0 9px;
        }

        #frame .content .contact-profile p {
            float: left;
        }

        #frame .content .contact-profile .social-media {
            float: right;
        }

        #frame .content .contact-profile .social-media i {
            margin-left: 14px;
            cursor: pointer;
        }

        #frame .content .contact-profile .social-media i:nth-last-child(1) {
            margin-right: 20px;
        }

        #frame .content .contact-profile .social-media i:hover {
            color: #435f7a;
        }

        #frame .content .messages {
            height: auto;
            min-height: calc(100% - 93px);
            max-height: calc(100% - 93px);
            overflow-y: scroll;
            overflow-x: hidden;
        }

        @media screen and (max-width: 735px) {
            #frame .content .messages {
                max-height: calc(100% - 105px);
            }
        }

        #frame .content .messages::-webkit-scrollbar {
            width: 8px;
            background: transparent;
        }

        #frame .content .messages::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.3);
        }

        #frame .content .messages ul li {
            display: inline-block;
            clear: both;
            float: left;
            margin: 15px 15px 5px 15px;
            width: calc(100% - 25px);
            font-size: 0.9em;
        }

        #frame .content .messages ul li:nth-last-child(1) {
            margin-bottom: 20px;
        }

        #frame .content .messages ul li.sent img {
            margin: 6px 8px 0 0;
        }

        #frame .content .messages ul li.sent p {
            background: #f5f5f5;
        }

        #frame .content .messages ul li.replies img {
            float: right;
            margin: 6px 0 0 8px;
        }

        #frame .content .messages ul li.replies p {
            background: #435f7a;
            color: #f5f5f5;
            float: right;
        }

        #frame .content .messages ul li img {
            width: 22px;
            border-radius: 50%;
            float: left;
        }

        #frame .content .messages ul li p {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 20px;
            line-height: 130%;
        }

        @media screen and (min-width: 735px) {
            #frame .content .messages ul li p {
                max-width: 75%;
            }
        }

        #frame .content .message-input {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 99;
        }

        #frame .content .message-input .wrap {
            position: relative;
        }

        #frame .content .message-input .wrap button {
            float: right;
            border: none;
            width: 50px;
            padding: 12px 0;
            cursor: pointer;
            background: #32465a;
            color: #f5f5f5;
        }

        @media screen and (max-width: 735px) {
            #frame .content .message-input .wrap button {
                padding: 16px 0;
            }
        }

        #frame .content .message-input .wrap button:hover {
            background: #435f7a;
        }

        #frame .content .message-input .wrap button:focus {
            outline: none;
        }
    </style>
    <div class="breadcrumb-area bg-gray">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">My Account</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="my-account-wrapper pt-80 pb-80">
        <div class="container" style="max-width: 1400px">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="active" data-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Dashboard</a>
                                    <a href="#orders" id="a_orders" data-toggle="tab"><i
                                            class="fa fa-cart-arrow-down"></i> Orders</a>
                                    <a href="#account-info" id="a_account_info" data-toggle="tab"><i
                                            class="fa fa-user"></i> Account Details</a>
                                    <a href="#change-password" id="a_change_password" data-toggle="tab"><i
                                            class="fa fa-user"></i> Change
                                        Password</a>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong>{{ auth()->user()->name }}!</strong>
                                            </div>

                                            <p class="mb-0">From your account dashboard. you can easily check & view
                                                your recent orders, edit your password and account details.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>Invoice No</th>
                                                        <th>Order Date</th>
                                                        <th>Products</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($orders as $key => $order)
                                                        <tr>
                                                            <td>{{ $order->invoice_no }}</td>
                                                            <td>{{ date('d-m-Y h:i A', strtotime($order->order_date)) }}</td>
                                                            <td>
                                                                @foreach($order->orderDetails as $orderDetail)
                                                                    <span>
                                                                    {{ $orderDetail->product->name }}
                                                                </span>
                                                                    <span>(<strong>{{ $orderDetail->quantity }}</strong> X ৳ <strong>{{ $orderDetail->selling_price }}</strong>)</span>
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @if($order->status === 'Pending')
                                                                    <span
                                                                        class="badge badge-pill badge-secondary">{{ $order->status }}</span>
                                                                @elseif($order->status === 'Confirmed' || $order->status === 'Processing')
                                                                    <span
                                                                        class="badge badge-pill badge-info">{{ $order->status }}</span>
                                                                @elseif($order->status === 'Delivered')
                                                                    <span
                                                                        class="badge badge-pill badge-success">{{ $order->status }}</span>
                                                                @elseif($order->status === 'Cancelled')
                                                                    <span
                                                                        class="badge badge-pill badge-danger">{{ $order->status }}</span>
                                                                @endif
                                                            </td>
                                                            <td>৳ <strong>{{ $order->total_price }}</strong> Tk</td>
                                                            <td>
                                                                <button title="View Feedbacks" type="button"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="openOrderFeedbackModal({{ $order->id }})">
                                                                    Feedbacks
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center" colspan="6">No order found</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Account Details</h3>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="account-details-form">
                                                <form method="post" action="{{ route('update.account.details') }}">
                                                    @csrf
                                                    <div class="single-input-item">
                                                        <label>Name <span class="required">*</span></label>
                                                        <input value="{{ old('name', auth()->user()->name) }}"
                                                               type="text" name="name"
                                                               placeholder="Enter your full name">
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label>Mobile </label>
                                                        <input value="{{ old('mobile', auth()->user()->mobile) }}"
                                                               type="text"
                                                               placeholder="Enter your mobile no, Ex: 018XXXXXXXX"
                                                               name="mobile">
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label>Email </label>
                                                        <input disabled
                                                               value="{{ old('email', auth()->user()->email) }}"
                                                               type="email" placeholder="Enter your email" name="email">
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label>Full Address </label>
                                                        <textarea placeholder="Enter your full address "
                                                                  name="full_address">{{ old('address', auth()->user()->address) }}</textarea>
                                                    </div>
                                                    <div class="single-input-item">
                                                        <button type="submit" class="check-btn sqr-btn ">Save Changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="change-password" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Change Password</h3>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="account-details-form">
                                                <form method="post" action="{{ route('update.password') }}">
                                                    @csrf
                                                    <div class="single-input-item">
                                                        <label>Current Password <span class="required">*</span></label>
                                                        <input type="password" name="current_password"
                                                               placeholder="Current password">
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label>New Password <span class="required">*</span></label>
                                                        <input type="password" name="new_password"
                                                               placeholder="New password">
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label>Confirm Password <span class="required">*</span></label>
                                                        <input type="password" name="password_confirmation"
                                                               placeholder="Confirm Password ">
                                                    </div>
                                                    <div class="single-input-item">
                                                        <button type="submit" class="check-btn sqr-btn ">Change
                                                            Password
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderFeedbackModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Order Feedbacks</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12 pr-4 pl-4">
                            <div class="mb-2" style="width: 100%; text-align: end;">
                                <button title="View Feedbacks" type="button"
                                        class="btn btn-sm btn-primary"
                                        onclick="openOrderFeedbackModal(null, 'refresh')">
                                    Refresh
                                </button>
                            </div>
                            <div id="frame" class="rounded">
                                <div class="content">
                                    <div class="messages" id="messages_div"></div>
                                    <div id="message-input" class="message-input">
                                        <div class="d-flex justify-content-center">
                                            <textarea id="message_text" class="rounded"
                                                      placeholder="Write your message here..."
                                                      name="message_text"></textarea>
                                            <input type="hidden" id="order_id_in_feedback">
                                            <button class="btn btn-primary btn-lg" onclick="sendFeedbackMessage()"
                                                    type="button">Send
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
        function openOrderFeedbackModal(order_id = null, actionFrom = null) {
            let orderId = '';
            if (actionFrom === 'refresh') {
                orderId = $('#order_id_in_feedback').val();
            } else {
                $('#order_id_in_feedback').val(order_id);
                orderId = order_id;
            }

            $.ajax({
                type   : "GET",
                url    : "{{url('order-feedbacks/')}}/" + orderId,
                success: function (data) {
                    let user_id = parseInt("{{ auth()->id() }}");
                    let html    = '';
                    if (data.length > 0) {
                        html += '<ul>';
                        data.forEach(message => {
                            if (user_id === message.user_id) {
                                html += '<li class="replies"><p>'
                                        + message.feedback
                                        + '<br><br><small><span><span>'
                                        + message.user.name + '</span> &nbsp; <span>'
                                        + message.feedback_time + '</span></span><span class="float-right">'
                                        + message.read_status + '</span></small></p></li>';
                            } else {
                                html += '<li class="sent"><p>'
                                        + message.feedback
                                        + '<br><br><small><span><span>'
                                        + message.user.name + '</span> &nbsp; <span>'
                                        + message.feedback_time + '</span></span></small></p></li>';
                            }
                        });
                        html += '</ul>';
                    } else {
                        html
                            += '<div class="row"><div class="col-md-12 text-center my-5">No feedbacks found</div></div>';
                    }

                    $('#messages_div').html(html);
                    if (actionFrom !== 'refresh') {
                        $('#orderFeedbackModal').modal('show');
                    }
                },
                error  : function (error) {
                    console.log(error);
                    toastr.error("Something went wrong.");
                }
            });
        }

        function sendFeedbackMessage() {
            let order_id = $('#order_id_in_feedback').val();
            let feedback = $('#message_text').val();

            if (feedback.trim() === '') {
                toastr.error("Please write your message first.");
                return;
            }

            if (feedback.trim().length < 35) {
                toastr.error("Feedback message must contain at least 35 characters.");
                return;
            }

            $.ajax({
                url    : '{{ route('send.feedback') }}',
                method : "post",
                data   : {
                    _token  : '{{ csrf_token() }}',
                    order_id: order_id,
                    feedback: feedback.trim(),
                },
                success: function (response) {
                    let user_id = parseInt("{{ auth()->id() }}");
                    let html    = '';
                    if (response.success) {
                        $('#messages_div').html('');
                        if (response.data.length > 0) {
                            html += '<ul>';
                            response.data.forEach(message => {
                                if (user_id === message.user_id) {
                                    html += '<li class="replies"><p>'
                                            + message.feedback
                                            + '<br><br><small><span><span>'
                                            + message.user.name + '</span> &nbsp; <span>'
                                            + message.feedback_time + '</span></span><span class="float-right">'
                                            + message.read_status + '</span></small></p></li>';
                                } else {
                                    html += '<li class="sent"><p>'
                                            + message.feedback
                                            + '<br><br><small><span><span>'
                                            + message.user.name + '</span> &nbsp; <span>'
                                            + message.feedback_time + '</span></span></small></p></li>';
                                }
                            });
                            html += '</ul>';
                        } else {
                            html
                                += '<div class="row"><div class="col-md-12 text-center my-5">No feedbacks found</div></div>';
                        }

                        $('#messages_div').html(html);
                        $('#message_text').val('');
                        toastr.success('Feedback has been sent successfully!');
                    } else {
                        toastr.error("Can not send message");
                    }

                },
                error  : function (error) {
                    console.log(error);
                    toastr.error("Something went wrong.");
                }
            });
        }
    </script>
@stop

@endsection
