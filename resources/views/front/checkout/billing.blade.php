@extends('master.front')

@section('title')
    {{__('Billing')}}
@endsection

@section('content')
    <!-- Page Title-->
<div class="page-title">
    <div class="container">
      <div class="column">
        <ul class="breadcrumbs">
          <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
          <li class="separator"></li>
          <li>{{__('Billing address')}}</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Page Content-->
  <div class="container padding-bottom-3x mb-1 checkut-page">
    <div class="row">
      <!-- Billing Adress-->
      <div class="col-xl-9 col-lg-8">
        <div class="steps flex-sm-nowrap mb-5"><a class="step active" href="{{route('front.checkout.billing')}}">
          <h4 class="step-title">1. {{__('Billing Address')}}:</h4>
          </a><a class="step" href="{{route('front.checkout.shipping')}}">
          <h4 class="step-title">2. {{__('Shipping Address')}}:</h4>
          </a><a class="step" href="{{route('front.checkout.payment')}}">
          <h4 class="step-title">3. {{__('Review and pay')}}</h4>
          </a>
        </div>
        <div class="card">
            <div class="card-body">
                <h6>{{__('Billing Address')}}</h6>

          <form id="checkoutBilling" action="{{route('front.checkout.store')}}" method="POST">
            @csrf
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-fn">{{__('First Name')}}</label>
              <input class="form-control" name="bill_first_name" type="text" required id="checkout-fn" value="{{$user->first_name}}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-ln">{{__('Last Name')}}</label>
              <input class="form-control" name="bill_last_name" type="text" required id="checkout-ln" value="{{$user->last_name}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-email">{{__('E-mail Address')}}</label>
              <input class="form-control" name="bill_email"  type="email" required id="checkout-email" value="{{$user->email}}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-phone">{{__('Phone Number')}}</label>
              <input class="form-control" name="bill_phone" type="text" id="checkout-phone" required value="{{$user->phone}}">
            </div>
          </div>
        </div>
        @if (PriceHelper::CheckDigital())
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="checkout-company">{{__('Company')}}</label>
              <input class="form-control" name="bill_company" type="text" id="checkout-company" value="{{$user->bill_company}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-address1">{{__('Address')}} 1</label>
              <input class="form-control" name="bill_address1" required type="text" id="checkout-address1" value="{{$user->bill_address1}}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-address2">{{__('Address')}} 2</label>
              <input class="form-control" name="bill_address2" type="text" id="checkout-address2" value="{{$user->bill_address2}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-zip">{{__('Zip Code')}}</label>
              <input class="form-control" name="bill_zip" type="text" id="checkout-zip" value="{{$user->bill_zip}}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-city">{{__('City')}}</label>
              <input class="form-control" name="bill_city" type="text" required id="checkout-city" value="{{$user->bill_city}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="checkout-country">{{ __('Country') }}</label>
              <select class="form-control" required name="bill_country" id="billing-country">
                <option selected>{{__('Choose Country')}}</option>
                @foreach (DB::table('countries')->get() as $country)
                      <option value="{{$country->name}}" {{$user->bill_country == $country->name ? 'selected' :''}} >{{$country->name}}</option>
                  @endforeach
               </select>
            </div>
          </div>
        </div>
        @endif




        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="same_address" name="same_ship_address" {{Session::has('shipping_address') ? 'checked' : ''}} >
            <label class="custom-control-label" for="same_address">{{__('Same as billing address')}}</label>
          </div>
        </div>

        <div class="d-flex justify-content-between paddin-top-1x mt-4">
            <a class="btn btn-outline-secondary btn-sm" href="{{route('front.cart')}}"><i class="icon-arrow-left"></i><span class="hidden-xs-down">{{__('Back To Cart')}}</span></a><button class="btn btn-primary  btn-sm" type="submit"><span class="hidden-xs-down">{{__('Continue')}}</span><i class="icon-arrow-right"></i></button></div>
        </form>
            </div>
        </div>
      </div>
      <!-- Sidebar          -->
      @include('includes.checkout_sitebar',$cart)
    </div>
  </div>
@endsection
