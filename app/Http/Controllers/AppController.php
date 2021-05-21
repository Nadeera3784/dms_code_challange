<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Category;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Coupon;

class AppController extends Controller{


	public function __construct(){
       
    }

    public function index(){

    	$categories = Category::all();

    	$products = Product::orderBy('id')->simplePaginate(12);

        return view('home', ['categories' => $categories, 'products' => $products]);
    }

    public function category($slug){

        $categories = Category::all();

        $found_category = Category::where('slug', $slug)->first();

        $products = Product::where('category_id', $found_category->id)->orderBy('id')->simplePaginate(12);

        return view('category', ['categories' => $categories, 'products' => $products, 'title' => $slug]);
    }

    public function addToCart($id){

        $product = Product::find($id);

        if(!$product) {
           return response()->json(['type' => "error"], 400);
        }

        $cart = session()->get('cart');

        if(!$cart) {
            $cart = [
                    $id => [
                        "name" => $product->title,
                        "quantity" => 1,
                        "price" => $product->price,
                        "image" => $product->image
                    ]
            ];
            session()->put('cart', $cart);
            return response()->json(['type' => "success"], 200);
        }

        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return response()->json(['type' => "success"], 200);
        }

        $cart[$id] = [
            "name" => $product->title,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image
        ];

        session()->put('cart', $cart);

        return response()->json(['type' => "success"], 200);
    }

    public function cart(){
        return view('cart', ['title' => 'cart']);
    }

    public function updateCart(Request $request){
        if($request->id and $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['type' => "success"], 200);
        }
    }

    public function removeFromCart(Request $request){
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['type' => "success"], 200);
        }
    }

    public function checkout(){
        return view('checkout', ['title' => 'checkout']);
    }

    public function payment(Request $request){

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255'],
            'address'    => ['required', 'string'],
            'country'    => ['required'],
            'state'      => ['required'],
            'zip'        => ['required'],
        ]);

        $invoice_number = time().'-'.mt_rand();

        $invoice = new Invoice();

        $invoice->invoice_no = $invoice_number;

        $invoice->first_name = $request->first_name;

        $invoice->last_name  = $request->last_name;

        $invoice->email      = $request->email;

        $invoice->address    = $request->address;

        $invoice->country    = $request->country;

        $invoice->state      = $request->state;

        $invoice->zip        = $request->zip;

        $invoice->sub_total  = $request->sub_total;

        $invoice->total      = $request->total;

        if(!empty($request->address2) && $request->has('address2')){
            $invoice->address2 = $request->address2;
        }

        $invoice->save();

        $total = 0;

        foreach(session('cart') as $id => $details){
            $total += $details['price'] * $details['quantity'];
               
            $invoice_item = new InvoiceItem();  
            
            $invoice_item->price  =  $details['price'];

            $invoice_item->quantity  =  $details['quantity'];

            $invoice_item->product_id  =  $id;

            $invoice_item->total  =  $total;

            $invoice_item->invoice_id  =  $invoice->id;

            $invoice_item->save();
        }

        $request->session()->flush();
        $invoice_view = Invoice::find($invoice->id)->with('items.product')->first();
        return view('invoice', ['invoice' => $invoice_view, 'title' => 'invoice']);

    }

    public function checkCoupon(Request $request){
        if($request->get('code')){
            $code = $request->get('code');
            $data = Coupon::where('code', $code)->first();
            if($data){
                return response()->json(['type' => "success", 'message' => $data], 200);
            }else{ 
               return response()->json(['type' => "error"], 400);
            }
        }else{
            return response()->json(['type' => "error"], 400);
        }
    }

}