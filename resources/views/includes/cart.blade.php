
@php
    $cart = Session::has('cart') ? Session::get('cart') : [];
    $cotal =0;
    $option_price = 0;
@endphp

<div class="card">
    <div class="card-body">
        <div class="table-responsive shopping-cart">
            <table class="table table-bordered">

              <thead>
                <tr>
                  <th>{{__('Product Name')}}</th>
                  <th>{{__('Product Price')}}</th>
                  <th class="text-center">{{__('Quantity')}}</th>
                  <th class="text-center">{{__('Subtotal')}}</th>
                  <th class="text-center"><a class="btn btn-sm btn-outline-danger" href="{{route('front.cart.clear')}}">{{__('Clear Cart')}}</a></th>
                </tr>
              </thead>

              <tbody id="cart_view_load" data-target="{{route('cart.get.load')}}">
                @php
                      //  dd($cart);
                @endphp
                @foreach ($cart as $key => $item)
                @php
                    $cotal += $item['main_price'] * $item['qty'];
                    $option_price += $item['attribute_price'];
                    $cartTotal = $cotal + $option_price;
                @endphp
                <tr>
                    <td>
                      <div class="product-item"><a class="product-thumb" href="{{route('front.product',$item['slug'])}}"><img src="{{asset('assets/images/'.$item['photo'])}}" alt="Product"></a>
                        <div class="product-info">
                          <h4 class="product-title"><a href="{{route('front.product',$item['slug'])}}">
                            {{ strlen(strip_tags($item['name'])) > 45 ? substr(strip_tags($item['name']), 0, 45) . '...' : strip_tags($item['name']) }}

                        </a></h4>

                          @foreach ($item['attribute']['option_name'] as $optionkey => $option_name)
                          <span><em>{{$item['attribute']['names'][$optionkey]}}:</em> {{$option_name}} ({{PriceHelper::setCurrencyPrice($item['attribute']['option_price'][$optionkey])}})</span>

                          @endforeach
                        </div>
                      </div>
                    </td>
                    <td class="text-center text-lg">{{PriceHelper::setCurrencyPrice($item['main_price'])}}</td>

                    <td class="text-center">
                     @if ($item['item_type'] != 'digital')
                     <div class="count-input">
                      <select class="form-control update_cart_qty" data-target="{{PriceHelper::GetItemId($key)}}" data-id="{{$key}}" >
                        <option {{$item['qty'] == 1 ? 'selected' : ''}}>{{ __('1') }}</option>
                        <option {{$item['qty'] == 2 ? 'selected' : ''}}>{{ __('2') }}</option>
                        <option {{$item['qty'] == 3 ? 'selected' : ''}}>{{ __('3') }}</option>
                        <option {{$item['qty'] == 4 ? 'selected' : ''}}>{{ __('4') }}</option>
                        <option {{$item['qty'] == 5 ? 'selected' : ''}}>{{ __('5') }}</option>
                        <option {{$item['qty'] == 6 ? 'selected' : ''}}>{{ __('6') }}</option>
                        <option {{$item['qty'] == 7 ? 'selected' : ''}}>{{ __('7') }}</option>
                        <option {{$item['qty'] == 8 ? 'selected' : ''}}>{{ __('8') }}</option>
                        <option {{$item['qty'] == 9 ? 'selected' : ''}}>{{ __('9') }}</option>
                        <option {{$item['qty'] == 10 ? 'selected' : ''}}>{{ __('10') }}</option>

                      </select>
                    </div>
                     @endif

                    </td>
                    <td class="text-center text-lg">{{PriceHelper::setCurrencyPrice($item['main_price'] * $item['qty'])}}</td>

                    <td class="text-center"><a class="remove-from-cart" href="{{route('front.cart.destroy',$key)}}" data-toggle="tooltip" title="Remove item"><i class="icon-x"></i></a></td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>
    </div>
</div>


  <div class="card mt-4">
      <div class="card-body">
        <div class="shopping-cart-footer">
            <div class="column">
                <form class="coupon-form" method="post" id="coupon_form" action="{{route('front.promo.submit')}}">
                @csrf
                <input class="form-control form-control-sm" name="code" type="text" placeholder="{{__('Coupon code')}}" required>
                <button class="btn btn-outline-primary btn-sm" type="submit">{{__('Apply Coupon')}}</button>
                </form>
            </div>

            <div class="text-right text-lg column {{Session::has('coupon') ? '' : 'd-none'}}"><span class="text-muted">{{__('Discount')}} ({{Session::has('coupon') ? Session::get('coupon')['code']['title'] : ''}}) : </span><span class="text-gray-dark">{{PriceHelper::setCurrencyPrice(Session::has('coupon') ? round(Session::get('coupon')['discount'],2) : 0)}}</span></div>

            <div class="text-right column text-lg"><span class="text-muted">{{__('Subtotal')}}: </span><span class="text-gray-dark">{{PriceHelper::setCurrencyPrice($cartTotal - (Session::has('coupon') ? round(Session::get('coupon')['discount'],2) : 0))}}</span></div>


        </div>
        <div class="shopping-cart-footer">
            <div class="column"><a class="btn btn-secondary btn-sm" href="{{route('front.catalog')}}"><i class="icon-arrow-left"></i>{{__('Back to Shopping')}}</a></div>
            <div class="column"><a class="btn btn-primary btn-sm" href="{{route('front.checkout.billing')}}">{{__('Checkout')}}</a></div>
        </div>
      </div>
  </div>
</div>


