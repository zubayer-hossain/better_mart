<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderFeedback;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Review;
use App\Models\Service;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('lockscreen');
    }

    public function index()
    {
        if (trim(request()->search_category) !== '' || trim(request()->search) !== '') {
            $search          = trim(request()->search);
            $search_category = trim(request()->search_category);
            $products        = Product::query();

            if ($search != '') {
                $product_ids_based_on_category = $product_ids_based_on_brand = $product_ids_based_on_model = [];
                if (count(Category::where('name', 'like', '%' . $search . '%')->pluck('id')) > 0) {
                    $product_ids_based_on_category = Product::where('category_id', (Category::where('name', 'like', '%' . $search . '%')->pluck('id')))
                        ->pluck('id')
                        ->toArray();
                }
                if (count(Brand::where('name', 'like', '%' . $search . '%')->pluck('id')) > 0) {
                    $product_ids_based_on_brand = Product::where('brand_id', (Brand::where('name', 'like', '%' . $search . '%')->pluck('id')))
                        ->pluck('id')
                        ->toArray();
                }
                if (count(ProductModel::where('name', 'like', '%' . $search . '%')->pluck('id')) > 0) {
                    $product_ids_based_on_model = Product::where('product_model_id', (ProductModel::where('name', 'like', '%' . $search . '%')->pluck('id')))
                        ->pluck('id')
                        ->toArray();
                }

                $product_ids = array_merge($product_ids_based_on_category, $product_ids_based_on_brand, $product_ids_based_on_model);

                $products = $products->where('name', 'like', '%' . $search . '%')
                    ->orWhere('product_code', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereIn('id', $product_ids);
            }
            if ($search_category != '') {
                $products = $products->where('category_id', $search_category);
            }

            $products = $products->with('category')->get();
        } else {
            $products = Product::with('category')->get();
        }

        $featured_products = Product::with('category')->take(3)->get();

        return view('home', compact('products', 'featured_products'));
    }

    public function about_us()
    {
        $teams   = Team::all();
        $reviews = Review::all();

        return view('about_us', compact('teams', 'reviews'));
    }

    public function services()
    {
        $services = Service::all();

        return view('services', compact('services'));
    }

    public function contact_us()
    {
        return view('contact_us');
    }

    public function login_register()
    {
        return view('login_register');
    }

    public function product_details($slug)
    {
        $product = Product::with('category', 'brand', 'productModel')->where('product_code', $slug)->firstOrFail();

        if (!isset($product->images) || count($product->images) === 0) {
            $product->images = NULL;
        }

        return view('product_details', compact('product'));
    }

    public function my_account()
    {
        if (auth()->check()) {
            $orders = Order::with('orderDetails.product')
                ->where('user_id', auth()->id())
                ->get()
                ->sortByDesc("created_at");

            return view('my_account', compact('orders'));
        }

        return redirect()->route('login')->with('warning', 'Please login first');
    }

    public function cart()
    {
        if (auth()->check()) {
            $user = auth()->user();
            return view('cart', compact('user'));
        }

        return redirect()->route('login')->with('warning', 'Please login first');
    }

    /**
     * Write code on Method
     *
     * @return response|\Illuminate\Http\JsonResponse
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id"           => $product->id,
                "product_code" => $product->product_code,
                "name"         => $product->name,
                "quantity"     => 1,
                "price"        => $product->selling_price,
                "image"        => isset($product->images) && count($product->images) > 0
                    ? asset($product->images[0])
                    : asset('uploads/no-photo.jpg')
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart successfully!'
        ]);
    }

    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\JsonResponse()
     */
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart                           = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            return response()->json([
                'message' => 'Cart updated successfully'
            ]);
        }
    }

    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\JsonResponse()
     */
    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            return response()->json([
                'message' => 'Product removed successfully'
            ]);
        }
    }

    public function booking(BookingRequest $request)
    {
        $customer_name    = $request->name;
        $customer_email   = $request->email;
        $customer_contact = $request->mobile;
        $customer_address = $request->full_address;
        $cart             = json_decode($request->cart);

        $total_price = 0;
        foreach ($cart as $product) {
            $total_price += (Product::whereId($product->id)->first()->selling_price * (int)$product->quantity);
        }

        DB::beginTransaction();
        try {
            $order                   = new Order();
            $order->order_date       = now();
            $order->invoice_no       = $this->generateInvoiceNumber();
            $order->user_id          = auth()->id();
            $order->customer_name    = $customer_name;
            $order->customer_email   = $customer_email;
            $order->customer_contact = $customer_contact;
            $order->customer_address = $customer_address;
            $order->total_price      = $total_price;
            $order->status           = 'Pending';
            $order->save();

            foreach ($cart as $product) {
                $selling_price = Product::whereId($product->id)->first()->selling_price;
                OrderDetail::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'selling_price' => $selling_price,
                    'quantity'      => $product->quantity,
                ]);
            }

            DB::commit();
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $exception->getMessage()]);
        }

        session()->forget('cart');
        return redirect()->route('my_account', 'orders')->with(['message' => 'Order has been placed successfully!']);
    }

    private function generateInvoiceNumber()
    {
        $orderCount = Order::all()->count() + 1;

        return 'INV-' . str_pad($orderCount, 6, '0', STR_PAD_LEFT);
        exit;
    }

    public function updateAccountDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required', 'string', 'max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('my_account', 'account-info')
                ->withErrors($validator);
        }

        User::whereId(auth()->id())->update([
            'name'    => $request->name,
            'mobile'  => $request->mobile,
            'address' => $request->full_address,
        ]);
        return redirect()->route('my_account', 'account-info')->with(['message' => 'Account details has been updated successfully!']);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'      => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'new_password'          => ['required', 'string', 'min:6'],
            'password_confirmation' => ['same:new_password'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('my_account', 'change-password')
                ->withErrors($validator);
        }

        User::whereId(auth()->id())->update([
            'password' => Hash::make($request->new_password),
        ]);
        return redirect()->route('my_account', 'change-password')->with(['message' => 'Password has been changed successfully!']);
    }

    public function productDetailsQUickView($product_id)
    {
        $product = Product::with('category', 'brand', 'productModel')->whereId($product_id)->firstOrFail();

        return response()->json($product);
    }

    public function orderFeedbacks($order_id)
    {
        $order_feedbacks = OrderFeedback::with('order', 'user')->where('order_id', $order_id)->get();
        foreach ($order_feedbacks as $order_feedback) {
            $order_feedback->feedback_time = Carbon::parse($order_feedback->created_at)->diffForhumans();
            $order_feedback->read_status   = $order_feedback->read == 0
                ? 'Sent'
                : 'Seen';
        }

        return response()->json($order_feedbacks);
    }

    public function sendFeedback(Request $request)
    {
        $order_id = (int)$request->order_id;
        OrderFeedback::where('order_id', $order_id)
            ->update([
                'read' => '1'
            ]);

        $orderFeedback           = new OrderFeedback();
        $orderFeedback->order_id = $order_id;
        $orderFeedback->feedback = $request->feedback;
        $orderFeedback->user_id  = auth()->id();

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
}
