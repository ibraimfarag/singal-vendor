@extends('master.front')
@section('title')
    {{__('Login')}}
@endsection
@section('content')

    <!-- Page Title-->
<div class="page-title">
    <div class="container">
      <div class="row">
          <div class="col-lg-12">
            <ul class="breadcrumbs">
                <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
                <li class="separator"></li>
                <li>{{__('Login/Register')}}</li>
              </ul>
          </div>
      </div>
    </div>
  </div>
  <!-- Page Content-->
  <div class="container padding-bottom-3x mb-1">
  <div class="row">
          <div class="col-md-6">
            <form class="card" method="post" action="{{route('user.login.submit')}}">
                @csrf
              <div class="card-body ">
                <h4 class="margin-bottom-1x text-center">{{__('Login')}}</h4>

                <div class="form-group input-group">
                  <input class="form-control" type="email" name="login_email" placeholder="{{ __('Email') }}" value="{{old('login_email')}}"><span class="input-group-addon"><i class="icon-mail"></i></span>
                </div>
                @error('login_email')
                  <p class="text-danger">{{$message}}</p>
                  @enderror

                <div class="form-group input-group">
                  <input class="form-control" type="password" name="login_password" placeholder="{{ __('Password') }}" ><span class="input-group-addon"><i class="icon-lock"></i></span>
                </div>
                @error('login_password')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <div class="d-flex flex-wrap justify-content-between padding-bottom-1x">
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="remember_me">
                    <label class="custom-control-label" for="remember_me">{{__('Remember me')}}</label>
                  </div><a class="navi-link" href="{{route('user.forgot')}}">{{__('Forgot password?')}}</a>
                </div>
                <div class="text-center">
                  <button class="btn btn-primary margin-bottom-none btn-sm" type="submit">{{ __('Login') }}</button>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center mt-3">
                    @if($setting->facebook_check == 1)
                    <a class="btn btn-sm facebook-btn" href="{{route('social.provider','facebook')}}"><i class="socicon-facebook"></i>{{ __('Facebook login') }}
                    </a>
                    @endif
                    @if($setting->google_check == 1)
                    <a class="btn btn-sm google-btn" href="{{route('social.provider','google')}}"><i class="socicon-google"></i> {{ __('Google login') }}
                    </a>
                    @endif
                  </div>
                  </div>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <div class="card register-area">
                <div class="card-body ">
                    <div class="padding-top-3x hidden-md-up"></div>
            <h3 class="margin-bottom-1x text-center">{{__('Register')}}</h3>
            <form class="row" action="{{route('user.register.submit')}}" method="POST">
                @csrf
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="reg-fn">{{__('First Name')}}</label>
                  <input class="form-control" type="text" name="first_name" placeholder="{{__('First Name')}}" id="reg-fn" value="{{old('first_name')}}">
                @error('first_name')
                <p class="text-danger">{{$message}}</p>
                @endif
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="reg-ln">{{__('Last Name')}}</label>
                  <input class="form-control" type="text" name="last_name" placeholder="{{__('Last Name')}}" id="reg-ln" value="{{old('last_name')}}">
                  @error('last_name')
                <p class="text-danger">{{$message}}</p>
                @endif
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="reg-email">{{__('E-mail Address')}}</label>
                  <input class="form-control" type="email" name="email" placeholder="{{__('E-mail Address')}}" id="reg-email" value="{{old('email')}}">
                  @error('email')
                  <p class="text-danger">{{$message}}</p>
                  @endif
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="reg-phone">{{__('Phone Number')}}</label>
                  <input class="form-control" name="phone" type="text" placeholder="{{__('Phone Number')}}" id="reg-phone" value="{{old('phone')}}">
                  @error('phone')
                  <p class="text-danger">{{$message}}</p>
                  @endif
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="reg-pass">{{__('Password')}}</label>
                  <input class="form-control" type="password" name="password" placeholder="{{__('Password')}}" id="reg-pass">
                  @error('password')
                  <p class="text-danger">{{$message}}</p>
                  @endif
                </div>

              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="reg-pass-confirm">{{__('Confirm Password')}}</label>
                  <input class="form-control" type="password" name="password_confirmation" placeholder="{{__('Confirm Password')}}" id="reg-pass-confirm">
                </div>
              </div>

              @if ($setting->recaptcha == 1)
              <div class="col-lg-12 mb-4">
                  {!! NoCaptcha::renderJs() !!}
                  {!! NoCaptcha::display() !!}
                  @if ($errors->has('g-recaptcha-response'))
                  @php
                      $errmsg = $errors->first('g-recaptcha-response');
                  @endphp
                  <p class="text-danger mb-0">{{__("$errmsg")}}</p>
                  @endif
              </div>
              @endif
              
              <div class="col-12 text-center">
                <button class="btn btn-primary margin-bottom-none btn-sm" type="submit">{{__('Register')}}</button>
              </div>
            </form>
                </div>
            </div>
          </div>
        </div>
  </div>
  <!-- Site Footer-->
@endsection
