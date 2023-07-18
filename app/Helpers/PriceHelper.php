<?php

namespace App\Helpers;

use App\Models\Currency;
use App\Models\Item;
use App\Models\PaymentSetting;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;

class PriceHelper
{


    public static function setPrice($price) {
       $curr = Currency::where('is_default',1)->first();
       return round($price*$curr->value,2);
    }

    public static function adminCurrencyPrice($price) {
       $curr = Currency::where('is_default',1)->first();
       $setting = Setting::first();
       if($setting->currency_direction == 1){
        return $curr->sign . round($price*$curr->value,2);
       }else{
        return  round($price*$curr->value,2).$curr->sign;
       }
       
    }

    public static function adminCurrency() {
       $curr = Currency::where('is_default',1)->first();
       return $curr->sign;
    }

    public static function storePrice($price) {
       $curr = Currency::where('is_default',1)->first();
       return round($price*$curr->value,2);
    }


    public static function setCurrencyPrice($price) {

        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }

        $setting = Setting::first();
        if($setting->currency_direction == 1){
         return $curr->sign . round($price*$curr->value,2);
        }else{
         return  round($price*$curr->value,2).$curr->sign;
        }
    }

    public static function setPreviousPrice($price) {

        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
        if($price != 0){
            $setting = Setting::first();
            if($setting->currency_direction == 1){
                $price = $curr->sign . round($price*$curr->value,2);
            }else{
                $price = round($price*$curr->value,2).$curr->sign;
            }
        }else{
            $price = '';
        }
       
       return html_entity_decode($price);
    }

    public static function setConvertPrice($price) {
        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
       return round($price*$curr->value,2);
    }

    public static function convertPrice($price) {
        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
       return round($price/$curr->value,2);
    }


    public static function setCurrencySign() {
        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
       return $curr->sign;
    }

    public static function setCurrencyValue() {
        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
       return $curr->value;
    }

    public static function setCurrencyName() {
        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
       return $curr->name;
    }

    public static function grandCurrencyPrice($item)
    {
        $option_price = 0;
        if(count($item->attributes) > 0){
            foreach($item->attributes as $attr){
                if(isset($attr->options[0])){
                    $option_price += $attr->options[0]->price;
                }
            }
        }

        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
        $price = $item->discount_price + $option_price;
        
        $setting = Setting::first();
        if($setting->currency_direction == 1){
         return $curr->sign . round($price*$curr->value,2);
        }else{
         return  round($price*$curr->value,2).$curr->sign;
        }

    }

    public static function grandPrice($item)
    {
        $option_price = 0;
        if(count($item->attributes) > 0){
            foreach($item->attributes as $attr){
                $option_price += PriceHelper::convertPrice($attr->options[0]->price);
            }

        }


        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
        $price = ($item->discount_price + $option_price);

       return round($price*$curr->value,2);

    }


    public static function Discount($discount)
    {
        if($discount){
            $discount = json_decode($discount,true);
        }else{
            $discount = 0;
        }
        return $discount;
    }


    public static function OrderTotal($order)
    {
        $cart = json_decode($order->cart,true);

        $total_tax = 0;
        $cart_total = 0;
        $total = 0;
        $option_price = 0;
        foreach($cart as $key => $item){
            $total += $item['main_price'] * $item['qty'];
            $option_price += $item['attribute_price'];
            $cart_total = $total + $option_price;
            if(Item::where('id',$key)->exists()){
                $item = Item::findOrFail($key);
                if(isset($item)){
                    if($item && $item->tax){
                        $total_tax += $item::taxCalculate($item);
                    }
                }
            }
        }

        $shipping = [];
        if(json_decode($order->shipping)){
            $shipping = json_decode($order->shipping,true);
        }
        $discount = [];
        if(json_decode($order->discount)){
            $discount = json_decode($order->discount,true);
        }

        $grand_total = ($cart_total + ($shipping?$shipping['price']:0)) + $total_tax;
        $grand_total = $grand_total - ($discount ? $discount['discount'] : 0);

        $total_amount = round($grand_total * $order->currency_value,2);

        return $total_amount;
    }
    public static function OrderTotalChart($order)
    {
        $cart = json_decode($order->cart,true);

        $total_tax = 0;
        $cart_total = 0;
        $total = 0;
        $option_price = 0;
        foreach($cart as $key => $item){
            $total += $item['main_price'] * $item['qty'];
            $option_price += $item['attribute_price'];
            $cart_total = $total + $option_price;
            if(Item::where('id',$key)->exists()){
                $item = Item::findOrFail($key);
                if(isset($item)){
                    if($item && $item->tax){
                        $total_tax += $item::taxCalculate($item);
                    }
                }
            }
        }

        $shipping = [];
        if(json_decode($order->shipping)){
            $shipping = json_decode($order->shipping,true);
        }
        $discount = [];
        if(json_decode($order->discount)){
            $discount = json_decode($order->discount,true);
        }

        $grand_total = ($cart_total + ($shipping?$shipping['price']:0)) + $total_tax;
        $grand_total = $grand_total - ($discount ? $discount['discount'] : 0);
        $curr = Currency::where('is_default',1)->first();
        $total_amount = round($grand_total * $curr->value,2);

        return $total_amount;
    }


    

    public static function cartTotal($cart)
    {
        $total = 0;

        foreach ($cart as $key => $product) {
            $total += $product['price'] * $product['qty'];
            $total += + $product['attribute_price'];
        }
        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }
        return $total / $curr->value;
    }


    public static function CheckDigital()
    {
        $cart = Session::get('cart');
        $check_digital = false;
        foreach ($cart as $key => $item) {
            if($item['item_type'] == 'normal'){
              $check_digital = true;
            }
        }

        return $check_digital;
    }

    public static function CheckDigitalPaymentGateway()
    {
        $cart = Session::get('cart');
        $check_digital = true;
        foreach ($cart as $key => $item) {
            if($item['item_type'] == 'normal'){
              $check_digital = false;
            }
        }
        return $check_digital;
    }





    public static function Transaction($order_id,$txn_id,$user_email,$amount)
    {

        if(Session::has('currency')){
            $curr = Currency::findOrFail(Session::get('currency'));
        }else{
            $curr = Currency::where('is_default',1)->first();
        }

        $transaction = New Transaction();
        $transaction->order_id = $order_id;
        $transaction->txn_id = $txn_id;
        $transaction->user_email = $user_email;
        $transaction->amount = round($amount/$curr->value);
        $transaction->currency_sign = $curr->sign;
        $transaction->currency_value = $curr->value;
        $transaction->save();
    }



    public static function GatewayText($keyword)
    {
        return PaymentSetting::where('unique_keyword',$keyword)->first()->text;
    }


    public static function DiscountPercentage($item)
    {
        if($item->previous_price && $item->previous_price !=0){
            $discount_price = $item->previous_price - $item->discount_price;
            $percentage = round($discount_price / $item->previous_price * 100);
            return $percentage.'%';
        }
    }


    public static function GetItemId($cart_id)
    {
        $item_id = explode('-',$cart_id);
        return $item_id[0];
    }


    public static function LicenseQtyDecrese($cart)
    {
        foreach($cart as $item_id => $item){
            if($item['item_type'] == 'license'){
               $item = Item::findOrFail(PriceHelper::GetItemId($item_id));
               $license_key_new = json_decode($item->license_key,true);
               $last_key = array_key_last($license_key_new);
                unset($license_key_new[$last_key]);
               $license_name_new = json_decode($item->license_key,true);
               unset($license_name_new[$last_key]);
               $item->license_name = json_encode($license_name_new,true);
               $item->license_key = json_encode($license_key_new,true);
               $item->update();
            }
            
        }
    }


}
