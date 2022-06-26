<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderFeedback;
use App\Models\Product;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use FetchOperation;
    use ListOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('invoice_no');
        CRUD::addColumn([
            'name'  => 'order_date',
            'label' => 'Order Date',
            'type'     => 'closure',
            'function' => function ($model) {
                return date('d-m-Y h:i A', strtotime($model->order_date));
            }
        ]);
        CRUD::addColumn([
            'name'  => 'user_id',
            'label' => 'Order by'
        ]);
        CRUD::column('customer_name');
        CRUD::column('customer_contact');
        CRUD::column('total_price');
        CRUD::addColumn([
            'name'     => 'status',
            'label'    => 'Status',
            'type'     => 'closure',
            'function' => function ($model) {
                if ($model->status === 'Pending') {
                    return '<span style="font-size: 90%;" class="badge badge-pill badge-secondary">' . $model->status
                           . '</span>';
                }

                if ($model->status === 'Confirmed' || $model->status === 'Processing') {
                    return '<span style="font-size: 90%;" class="badge badge-pill badge-info">' . $model->status
                           . '</span>';
                }

                if ($model->status === 'Delivered') {
                    return '<span style="font-size: 90%;" class="badge badge-pill badge-success">' . $model->status
                           . '</span>';
                }

                if ($model->status === 'Cancelled') {
                    return '<span style="font-size: 90%;" class="badge badge-pill badge-danger">' . $model->status
                           . '</span>';
                }
            }
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrderRequest::class);
        $this->data['all_customer'] = User::whereNull('role_id')->get();
        $this->data['all_product']  = Product::all();
        $this->data['all_status']   = Order::ORDER_STATUS;
        $this->crud->setCreateView('custom.pages.orders');

        CRUD::field('order_date');
        CRUD::field('invoice_no');
        CRUD::field('user_id');
        CRUD::field('customer_name');
        CRUD::field('customer_email');
        CRUD::field('customer_contact');
        CRUD::field('customer_address');
        CRUD::field('total_price');
        CRUD::field('status');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $orderData = Order::with('orderDetails.product', 'user')->find($this->crud->getCurrentEntry()->id);
        $orderData->order_date = date('d-m-Y h:i A', strtotime($orderData->order_date));

        $this->data['order_data'] = $orderData;
        $this->data['module_action_type'] = 'edit';

        $this->crud->setUpdateView('custom.pages.orders');
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $orderData = Order::with('orderDetails.product', 'user', 'orderFeedbacks.user')->find($this->crud->getCurrentEntry()->id);

        $orderData->order_date = date('d-m-Y h:i A', strtotime($orderData->order_date));

        if (count($orderData->orderFeedbacks) > 0) {
            foreach ($orderData->orderFeedbacks as $order_feedback) {
                $order_feedback->feedback_time = Carbon::parse($order_feedback->created_at)->diffForhumans();
                $order_feedback->read_status   = $order_feedback->read == 0
                    ? 'Sent'
                    : 'Seen';
            }
        }
        $this->data['all_customer'] = User::whereNull('role_id')->get();
        $this->data['all_product']  = Product::all();
        $this->data['all_status']   = Order::ORDER_STATUS;
        $this->data['order_data'] = $orderData;
        $this->data['module_action_type'] = 'show';

        $this->crud->setShowView('custom.pages.orders');
    }

    /**
     * @param OrderRequest $request
     * @return RedirectResponse
     */
    public function store(OrderRequest $request)
    {
        $orderDetails = json_decode($request->order_details);
        $request->merge([
            'order_details' => NULL,
            'order_date'    => now(),
            'invoice_no'    => $this->generateInvoiceNumber(),
        ]);

        $response = $this->traitStore($request);

        foreach ($orderDetails as $orderDetail) {
            OrderDetail::create([
                'order_id'      => $response['data']->id,
                'product_id'    => $orderDetail->product->id,
                'selling_price' => $orderDetail->selling_price,
                'quantity'      => $orderDetail->quantity,
            ]);
        }

        return $response;
    }

    public function update(OrderRequest $request)
    {
        $orderDetails = json_decode($request->order_details);
        $request->merge([
            'order_details' => NULL
        ]);

        $response = $this->traitUpdate($request);

        foreach ($orderDetails as $orderDetail) {
            if (!isset($orderDetail->id)) {
                OrderDetail::create([
                    'order_id'      => $response['data']->id,
                    'product_id'    => $orderDetail->product->id,
                    'selling_price' => $orderDetail->selling_price,
                    'quantity'      => $orderDetail->quantity,
                ]);
            } else {
                OrderDetail::whereId($orderDetail->id)->update([
                    'order_id'      => $orderDetail->order_id,
                    'product_id'    => $orderDetail->product_id,
                    'selling_price' => $orderDetail->selling_price,
                    'quantity'      => $orderDetail->quantity,
                ]);
            }
        }

        return $response;
    }

    private function generateInvoiceNumber(): string
    {
        $orderCount = Order::all()->count() + 1;

        return 'INV-' . str_pad($orderCount, 6, '0', STR_PAD_LEFT);
        exit;
    }

    public function sendFeedback(){
        $order_id                = request()->order_id;
        OrderFeedback::where('order_id', $order_id)
            ->update([
                'read' => '1'
            ]);

        $orderFeedback           = new OrderFeedback();
        $orderFeedback->order_id = $order_id;
        $orderFeedback->feedback = request()->feedback;
        $orderFeedback->user_id  = backpack_auth()->id();

        if ($orderFeedback->save()) {
            $order_feedbacks_data = OrderFeedback::with('order', 'user')->where('order_id', $order_id)->get();
            foreach ($order_feedbacks_data as $feedback) {
                $feedback->feedback_time = Carbon::parse($feedback->created_at)->diffForhumans();
                $feedback->read_status   = $feedback->read == 0
                    ? 'Sent'
                    : 'Seen';
            }

            return response()->json([
                'success' => true,
                'data'    => $order_feedbacks_data
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    public function fetchFeedbacks(){
        $order_feedbacks_data = OrderFeedback::with('order', 'user')
            ->where('order_id', request()->order_id)
            ->get();

        foreach ($order_feedbacks_data as $feedback) {
            $feedback->feedback_time = Carbon::parse($feedback->created_at)->diffForhumans();
            $feedback->read_status   = $feedback->read == 0
                ? 'Sent'
                : 'Seen';
        }

        return response()->json([
            'success' => true,
            'data'    => $order_feedbacks_data
        ]);
    }
}
