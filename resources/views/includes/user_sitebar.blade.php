@php
    $user = Auth::user();
@endphp
<div class="col-lg-4">
    <aside class="user-info-wrapper">
      <div class="user-info">
        <div class="user-avatar">

          <img id="avater_photo_view" src="{{$user->photo ? asset('assets/images/'.$user->photo) : asset('assets/images/placeholder.png')}}" alt="User">
        </div>

        <div class="user-data">
          <h4 class="h5">{{$user->first_name}} {{$user->last_name}}</h4><span>{{__('Joined')}} {{$user->created_at->format('M D Y')}}</span>
        </div>
      </div>
      <nav class="list-group">
        <a class="list-group-item {{ request()->is('user/dashboard') ? 'active' : '' }}" href="{{route('user.dashboard')}}"><i class="icon-command"></i>{{__('Dashboard')}}</a>
        <a class="list-group-item {{ request()->is('user/profile') ? 'active' : '' }}" href="{{route('user.profile')}}"><i class="icon-user"></i>{{__('Profile')}}</a>
        <a class="list-group-item {{ request()->is('user/ticket') ? 'active' : '' }}" href="{{route('user.ticket')}}"><i class="icon-file-text"></i>{{__('Support Ticket')}}</a>
        <a class="list-group-item with-badge {{ request()->is('user/orders') ? 'active' : '' }}" href="{{route('user.order.index')}}"><i class="icon-shopping-bag"></i>{{__('Orders')}}<span class="badge badge-default badge-pill">{{$user->orders->count()}}</span></a>
        <a class="list-group-item {{ request()->is('user/addresses') ? 'active' : '' }}" href="{{route('user.address')}}"><i class="icon-map-pin"></i>{{__('Address')}}</a>
        <a class="list-group-item with-badge {{ request()->is('user/wishlists') ? 'active' : '' }}" href="{{route('user.wishlist.index')}}"><i class="icon-heart"></i>{{__('Wishlist')}}<span class="badge badge-default badge-pill">{{$user->wishlists->count()}}</span></a>
        <a class="list-group-item with-badge" href="{{route('user.logout')}}"><i class="icon-log-out"></i>{{__('Log out')}}</a>
      </nav>
    </aside>


  </div>
