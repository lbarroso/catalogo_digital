<?php

namespace App\Service;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shoppingcart;
use App\Models\UserAddress;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderService{
    public function order(Request $request){
        try {
            //sacar el domicilio
            $address = UserAddress::findOrFail($request->address_id);
            //crear pedido
            $order = new Order();

            $order->invoice         = (string) Str::uuid();;
            $order->street          = $address->street;
            $order->postal_code     = $address->postal_code;
            $order->exterior        = $address->exterior;
            $order->inside          = $address->inside;
            $order->references      = $address->references;
            $order->name            = $address->name;
            $order->lastname        = $address->lastname;
            $order->tax             = 0;
            $order->discounts       = 0;
            $order->subtotal        = 0;
            $order->total           = 0;
            $order->payment_methods = '';
            $order->user_id         = auth()->user()->id;
            $order->statu_id        = 1;
            $order->save();

            //obtener datos del carrrito
            $carts = Shoppingcart::where('user_id',auth()->user()->id)->with(['product' => function($q){
                $q->select('*',DB::raw('0 as discount_current'));
            }])->get();

            //sacar valores de total, subtotal, descuento, tax, crear detalle de orden;

            $subtotal = 0;
            $total = 0;
            $tax = 0;
            $discount = 0;

            foreach ($carts as $cart) {
                $price_current = $cart->product->price * (1-($cart->product->discount_current/100));

                $detail = new OrderDetail();
                $detail->name        = $cart->product->name;
                $detail->description = $cart->product->description;
                $detail->sku         = $cart->product->sku;
                $detail->price       = $price_current;
                $detail->quantity    = $cart->quantity;
                $detail->order_id    = $order->id;
                $detail->save();


                $total +=  $cart->quantity * $price_current;
                $discount += ($cart->product->price - $price_current) * $cart->quantity;
                $subtotal += $cart->product->price * $cart->quantity;
                
            }

            $order->subtotal = $subtotal;
            $order->discounts = $discount;
            $order->total = $total;
            $order->save();

            Shoppingcart::where('user_id',auth()->user()->id)->delete();

            return ['order' => $order];


        } catch (\Throwable $th) {
            return ['error' => true,'message' => $th->getMessage()];

        }
    }

    public function total(){
        $total = 0;

        $carts = Shoppingcart::where('user_id',auth()->user()->id)->with(['product' => function($q){
            $q->select('*',DB::raw('0 as discount_current'));
        }])->get();

        foreach($carts as $cart){
            $price_current = $cart->product->price * (1-($cart->product->discount_current/100));
            $total +=  $cart->quantity * $price_current;
        }

        return $total;
    }
}