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
        $qty=request()->qty ? request()->qty : 1;
        $total=0;
        $discounts=0;
        $this_discounts=0;
        if(!$cart) {
            $total=$product->price * $qty;
            $cart = [
                'total' => $total ,
                'items' =>  [
                    $id => [
                        "name" => $product->title,
                        "quantity" => 1,
                        "price" => $product->price,
                        "image" => $product->image
                    ]
                ],
                'discounts' =>  $discounts,
                'qty'   =>  $qty,
            ];
            session()->put('cart', $cart);
            return response()->json(['type' => "success"], 200);
        }

        if(isset($cart['items'][$id])) {
            $temp_categories=[];
            $discounts=$cart['discount'];
            $total_qty=0;
            if(count($cart['items']) > 0){
                foreach ($cart['items'] as $key => $value) {
                    if(isset($temp_categories[$value->category_id])){
                        $total=$total + ($value['price'] * $value['quantity']);
                        $total_qty=$total_qty + $value['quantity'];
                        $temp_categories[$value->category_id]=$temp_categories[$value->category_id]  +1;
                    }else{
                        $temp_categories[$value->category_id]=1;
                    }
                }
            }
            if($product->category()->first()->id ==1){ // define children books category id
                if($qty >= 5){
                    $this_discounts=$product->price * 10 / 100;
                }
            }
            if(isset($temp_categories[$product->category_id]) && $temp_categories[$product->category_id] >= 10){
                $discounts=$total - ($total * 10 / 100);
            }
            $cart['total']=$total + ($cart['items'][$id]['price'] * $cart['items'][$id]['quantity']);
            $cart['items'][$id]['quantity']++;
            $cart['items'][$id]['discount']=$this_discounts;
            $cart['qty']=$total_qty;
            $cart['discount']=$discounts;
            session()->put('cart', $cart);

            return response()->json(['type' => "success"], 200);
        }
        $cart['total']=$cart['total'] + ($cart['items'][$id]['price'] * $cart['items'][$id]['quantity']);
        $cart['qty']=$qty;
        $cart['discount']=$discounts;
        $cart['items'][$id] = [
            "name" => $product->title,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image,
            "discount"  =>  $this_discounts,
        ];

        session()->put('cart', $cart);

        return response()->json(['type' => "success"], 200);
    }

    public function cart(){
        return view('cart', ['title' => 'cart']);
    }

    public function updateCart(Request $request){
        $qty=$request->quantity;
        $total=0;
        $total_qty=0;
        if($request->id and $request->quantity) {
            $cart = session()->get('cart');
            if(isset($cart['items'][$request->id])){
                $temp_categories=[];
                $product=Product::find($request->id);
                $discounts=$cart['discount'];
                $this_discounts=0;
                if(count($cart['items']) > 0){
                    foreach ($cart['items'] as $key => $value) {
                        $total=$total + ($value['price'] * $value['quantity']);
                        $total_qty=$total_qty + $value['quantity'];
                        if(isset($temp_categories[$value->category_id])){
                            $temp_categories[$value->category_id]=$temp_categories[$value->category_id]  +1;
                        }else{
                            $temp_categories[$value->category_id]=1;
                        }
                    }
                }

                if($product->category()->first()->id ==1){ // define children books category id
                    if($qty >= 5){
                        $this_discounts=$product->price * 10 / 100;
                    }
                }
                
                
                if(isset($temp_categories[$product->category_id]) && $temp_categories[$product->category_id] >= 10){
                    $discounts=$total - ($total * 10 / 100);
                }
                $cart['discount']=$discounts;
                $cart['qty']=$total_qty;
                $cart['total']=$total + ($product->price * $request->quantity);
                $cart['items'][$request->id]["quantity"] = $request->quantity;
                $cart['items'][$request->id]["discount"]=$this_discounts;
                session()->put('cart', $cart);
                return response()->json(['type' => "success"], 200);
            }
            return response()->json(['type'=>'falied',403]);
        }
    }

    public function removeFromCart(Request $request){
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                $total=0;
                $temp_categories=[];
                $total_qty=0;
                $product=Product::find($request->id);
                $discounts=$cart['discount'];;
                unset($cart[$request->id]);
                
                if(count($cart['items']) > 0){
                    foreach ($cart['items'] as $key => $value) {
                        $total=$total + ($value['price'] * $value['quantity']);
                        $total_qty=$total_qty + $value['quantity'];
                        if(isset($temp_categories[$value->category_id])){
                            $temp_categories[$value->category_id]=$temp_categories[$value->category_id]  +1;
                        }else{
                            $temp_categories[$value->category_id]=1;
                        }
                    }
                }
                if(isset($temp_categories[$product->category_id]) && $temp_categories[$product->category_id] >= 10){
                    $discounts=$total - ($total * 10 / 100);
                }

                $cart['discount']=$discounts;
                $cart['total']=$total + ($product->price * $request->quantity);
                $cart['qty']=$total_qty;
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
                //Ok We have to call cart price for update
                if(isset(session('cart'))){

                    $cart=session('cart');
                    
                    $cop_d=session('cart')['total'] - (session('cart')['total'] * $data->discount / 100);
                    
                    $cart['copone_discount']=$cop_d;
                    if($cop_d > 0){
                        $cart['discount']=$cop_d;
                        $cart['sub_total']=$cart['total'];
                    }
                    session()->put('cart', $cart);
                    return response()->json(['type' => "success", 'message' => $data,'sub_total'=>number_format($cart['total'],2),'total' => number_format($cart['total'] - $cart['discount'],2),'qty'=>$cart['qty'],'discount'=>number_format($cart['discount'],2)], 200);
                }else{
                    return response()->json(['type' => "error"], 400);
                }
                
            }else{ 
               return response()->json(['type' => "error"], 400);
            }
        }else{
            return response()->json(['type' => "error"], 400);
        }
    }

}