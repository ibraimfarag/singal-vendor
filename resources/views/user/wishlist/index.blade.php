@extends('master.front')
@section('title')
    {{__('Wishlist')}}
@endsection

@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
                    <li class="separator"></li>
                    <li>{{__('Wishlist')}}</li>
                  </ul>
            </div>
        </div>
    </div>
  </div>
  <!-- Page Content-->
  <div class="container padding-bottom-3x mb-1">
  <div class="row">
         @include('includes.user_sitebar')
          <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="padding-top-2x mt-2 hidden-lg-up"></div>
            <!-- Wishlist Table-->
            <div class="table-responsive wishlist-table mb-0">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th>{{__('Wishlist Product')}}</th>
                    @if ($wishlist_items->count() > 0)
                    <th class="text-center"><a class="btn btn-sm btn-primary" href="{{route('user.wishlist.delete.all')}}">{{__('Clear Wishlist')}}</a></th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                @if ($wishlist_items->count() > 0)
                @foreach ($wishlist_items as $product)
                <tr>
                    <td>
                      <div class="product-item"><a class="product-thumb" href="{{route('front.product',$product->slug)}}"><img src="{{asset('assets/images/'.$product->photo)}}" alt="Product"></a>
                        <div class="product-info">
                          <h4 class="product-title"><a href="{{route('front.product',$product->slug)}}">{{$product->name}}</a></h4>
                          <div class="text-lg mb-1">{{PriceHelper::grandCurrencyPrice($product)}}</div>
                          <div class="text-sm">{{__('Availability')}}:
                            <div class="d-inline text-{{$product->stock == 0 ? 'danger' : 'success'}}">{{$product->stock == 0 ? __('Out of stock') : __('In Stock')}}</div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-center"><a class="remove-from-cart" href="{{route('user.wishlist.delete',$product->getWishlistItemId())}}" data-toggle="tooltip" title="Remove item"><i class="icon-x"></i></a></td>
                  </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="3">{{__('No Product Found')}}</td>
                </tr>
                @endif
                </tbody>
              </table>
            </div>
            <hr class="mb-4">
                </div>
            </div>

          </div>
        </div>
  </div>
@endsection
