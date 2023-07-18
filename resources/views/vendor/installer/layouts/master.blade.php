<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ trans('installer_messages.title') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-16x16.png') }}" sizes="16x16"/>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-32x32.png') }}" sizes="32x32"/>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-96x96.png') }}" sizes="96x96"/>
        <link href="{{ asset('installer/css/style.min.css') }}" rel="stylesheet"/>
        @yield('style')
        <style>
            .newmaster{
                height: 100vh;
                display: flex;
                width: 100%;
                justify-content: center;
                align-items: center
            }
            .header {
                background: #eff5ff;
            }
            .header .header__title{
                color: #222;
                font-weight: 700;
            }
            .step__icon {
                background-color: #9a9a9a; 
            }
            .step__item.active .step__icon, .step__item.active ~ .step__divider, .step__item.active ~ .step__item .step__icon {
                background-color: #0C59DB;
            }
            .button{
                background-color: #0C59DB;
            }
            .box {
                -webkit-box-shadow: 0 10px 20px rgb(1 0 6 / 6%), 0 6px 30px rgb(51 10 113 / 9%);
                box-shadow: 0 10px 20px rgb(1 0 6 / 6%), 0 6px 30px rgb(51 10 113 / 9%);
            }
        </style>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div class="newmaster">
            <div class="box">
                <div class="header">
                    <h1 class="header__title">@yield('title')</h1>
                </div>
                <ul class="step">
                    <li class="step__divider"></li>
                    <li class="step__item {{ isActive('LaravelInstaller::final') }}">
                        <i class="step__icon fa fa-thumbs-up" aria-hidden="true"></i>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ isActive('LaravelInstaller::environment')}} {{ isActive('LaravelInstaller::environmentWizard')}} {{ isActive('LaravelInstaller::environmentClassic')}}">
                        @if(Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('LaravelInstaller::environment') }}">
                                <i class="step__icon fa fa-database" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-database" aria-hidden="true"></i>
                        @endif
                    </li>

                    <li class="step__divider"></li>
                    <li class="step__item {{ isActive('LaravelInstaller::license') }}">
                        @if(Request::is('install/license') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('LaravelInstaller::license') }}">
                                <i class="step__icon fa fa-key" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-key" aria-hidden="true"></i>
                        @endif
                    </li>

                    
                    <li class="step__divider"></li>
                    <li class="step__item {{ isActive('LaravelInstaller::permissions') }}">
                        @if(Request::is('install/license') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('LaravelInstaller::permissions') }}">
                                <i class="step__icon fa fa-folder" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-folder" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ isActive('LaravelInstaller::requirements') }}">
                        @if(Request::is('install/license') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('LaravelInstaller::requirements') }}">
                                <i class="step__icon fa fa-list" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-list" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ isActive('LaravelInstaller::welcome') }}">
                        @if(Request::is('install/license') || Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('LaravelInstaller::welcome') }}">
                                <i class="step__icon fa fa-home" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-home" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li class="step__divider"></li>
                </ul>
                <div class="main">
                    @if (session('message'))
                        <p class="alert text-center">
                            <strong>
                                @if(is_array(session('message')))
                                    {{ session('message')['message'] }}
                                @else
                                    {{ session('message') }}
                                @endif
                            </strong>
                        </p>
                    @endif
                    @if(session()->has('errors'))
                        <div class="alert alert-danger" id="error_alert">
                            <button type="button" class="close" id="close_alert" data-dismiss="alert" aria-hidden="true">
                                 <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                            <h4 style="font-size: 18px;">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ trans('installer_messages.forms.errorTitle') }}
                            </h4>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('container')
                </div>
            </div>
        </div>
        @yield('scripts')
        <script type="text/javascript">
            var x = document.getElementById('error_alert');
            var y = document.getElementById('close_alert');
            y.onclick = function() {
                x.style.display = "none";
            };
        </script>
    </body>
</html>
