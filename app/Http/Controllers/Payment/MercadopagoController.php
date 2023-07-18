<?php

namespace App\Http\Controllers\Payment;

use App\Helpers\EmailHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Notification;
use App\Models\PaymentSetting;
use App\Models\PromoCode;
use App\Models\Setting;
use App\Models\ShippingService;
use App\Models\TrackOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MercadopagoController extends Controller
{
    public function store(Request $request)
    {

        $input = $request->all();
        
        if(Session::has('currency')){
            $currency = Currency::findOrFail(Session::get('currency'));
        }else{
            $currency = Currency::where('is_default',1)->first();
        }

        $supported = ['USD','NGN','BRL'];
        if(!in_array($currency->name,$supported)){
            Session::flash('error',__('Currency Not Supported'));
            return redirect()->back();
        }

        $data = PaymentSetting::whereUniqueKeyword('mercadopago')->first();
        $paydata = $data->convertJsonData();
        

        $user = Auth::user();
        $setting = Setting::first();
        $cart = Session::get('cart');

        $total_tax = 0;
        $cart_total = 0;
        $total = 0;
        $option_price = 0;
        foreach($cart as $key => $item){

            $total += $item['main_price'] * $item['qty'];
            $option_price += $item['attribute_price'];
            $cart_total = $total + $option_price;
            $item = Item::findOrFail($key);
            if($item->tax){
                $total_tax += $item::taxCalculate($item);
            }
        }
        $shipping = [];
        if(ShippingService::whereStatus(1)->exists()){
            $shipping = ShippingService::whereStatus(1)->first();
        }
        $discount = [];
        if(Session::has('coupon')){
            $discount = Session::get('coupon');
        }
        
        $grand_total = ($cart_total + ($shipping?$shipping->price:0)) + $total_tax;
        $grand_total = $grand_total - ($discount ? $discount['discount'] : 0);
        $total_amount = PriceHelper::setConvertPrice($grand_total);
       
        $item_name = $setting->title." Order";
    
        $success_url = route('front.checkout.success');

        MercadoPago\SDK::setAccessToken($paydata['token']);
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = (string)$total_amount;
        $payment->token = $input['token'];
        $payment->description = $item_name;
        $payment->installments = 1;
        $payment->payer = array(
          "email" => $user->email
        );
        $payment->save();

        if ($payment->status == 'approved') {
            
            $orderData['cart'] = json_encode($cart,true);
            $orderData['discount'] = json_encode($discount,true);
            $orderData['shipping'] = json_encode($shipping,true);
            $orderData['tax'] = $total_tax;
            $orderData['shipping_info'] = json_encode(Session::get('shipping_address'),true);
            $orderData['billing_info'] = json_encode(Session::get('billing_address'),true);
            $orderData['payment_method'] = 'Mercadopago';
            $orderData['txnid'] = $payment->id;
            $orderData['user_id'] = $user->id;
            $orderData['payment_status'] = 'Paid';
            $orderData['order_status'] = 'Pending';
            $orderData['transaction_number'] = Str::random(10);
            $orderData['currency_sign'] = PriceHelper::setCurrencySign();
            $orderData['currency_value'] = PriceHelper::setCurrencyValue();
            $order = $user->orders()->create($orderData);

            PriceHelper::Transaction($order->id,$order->transaction_number,$user->email,PriceHelper::OrderTotal($order));
            PriceHelper::LicenseQtyDecrese($cart);
            
                if(Session::has('copon')){
                    $code = PromoCode::find(Session::get('copon')['code']['id']);
                    $code->no_of_times--;
                    $code->update();
                }
                TrackOrder::create([
                    'title' => 'Pending',
                    'order_id' => $order->id,
                ]);
    
                
                Notification::create([
                    'order_id' => $order->id
                ]);


                $emailData = [
                    'to' => $user->email,
                    'type' => "Order",
                    'user_name' => $user->displayName(),
                    'order_cost' => $total_amount,
                    'transaction_number' => $order->transaction_number,
                    'site_title' => Setting::first()->title,
                ];

                $email = new EmailHelper();
                $email->sendTemplateMail($emailData);

                foreach(json_decode($order->cart,true) as $id => $product){
                    $vendor_id[] = $user = Item::findOrFail($id)->user->id;
                }

                if($discount){
                    $coupon_id = $discount['code']['id'];
                    $get_coupon = PromoCode::findOrFail($coupon_id);
                    $get_coupon->no_of_times -= 1;
                    $get_coupon->update();
                }
        
                Session::put('order_id',$order->id);
                Session::forget('cart');
                Session::forget('discount');
                return redirect($success_url);

        } 

        

    }

}