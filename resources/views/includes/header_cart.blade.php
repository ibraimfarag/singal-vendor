@php
    $total = 0;
    $qty = 0;
    $option_price = 0;
@endphp
@if (Session::has('cart'))
@foreach (Session::get('cart') as $key => $cart)
@php
    $total += $cart['main_price'] * $cart['qty'];
    $option_price += $cart['attribute_price'];
    $grandSubtotal = $total + $option_price;

@endphp
<div class="entry">
  <div class="entry-thumb"><a href="{{route('front.product',$cart['slug'])}}"><img src="{{asset('assets/images/'.$cart['photo'])}}" alt="Product"></a></div>
  <div class="entry-content">
    <h4 class="entry-title"><a href="{{route('front.product',$cart['slug'])}}">
        {{ strlen(strip_tags($cart['name'])) > 35 ? substr(strip_tags($cart['name']), 0, 35) . '...' : strip_tags($cart['name']) }}
    </a></h4>
    <span class="entry-meta">{{$cart['qty']}} x {{PriceHelper::setCurrencyPrice($cart['main_price'])}}</span>
    {{-- @foreach ($cart['attribute']['option_name'] as $optionkey => $option_name)
    <span class="entry-meta"><b>{{$option_name}}
    </b> : {{PriceHelper::setCurrencyPrice($cart['attribute']['option_price'][$optionkey])}}</span>
    @endforeach --}}
 </div>
  <div class="entry-delete"><a href="{{route('front.cart.destroy',$key)}}"><i class="icon-x"></i></a></div>
</div>
@endforeach
<div class="text-right">
<p class="text-gray-dark py-2 mb-0"><span class="text-muted">{{__('Subtotal')}}:</span> {{PriceHelper::setCurrencyPrice($grandSubtotal)}}</p>
</div>
<div class="d-flex justify-content-between">
<div class="w-50 d-block"><a class="btn btn-secondary btn-sm  mb-0" href="{{route('front.cart')}}">{{__('Go to Cart')}}</a></div>
<div class="w-50 d-block text-end"><a class="btn btn-primary btn-sm  mb-0" href="{{route('front.checkout.billing')}}">{{__('Checkout')}}</a></div>
@else
{{__('Cart empty')}}
  @endif
</div>
