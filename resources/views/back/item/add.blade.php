@extends('master.back')

@section('content')

<div class="container-fluid">

<!-- Page Heading -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h3 class="mb-0 bc-title"><b>{{ __('Add Product') }}</b> </h3>
        </div>
    </div>
</div>

<!-- Form -->
<div class="row">
    <div class="col-sm-6 col-md-4">
        <a href="{{route('back.item.create')}}" class="card card-stats card-round">
            <div class="card-body">
                <div class="text-center py-3">
                    <div class="d-inline-block">
                        <div class="icon-big text-center icon-primary bubble-shadow-small  px-3">
                            <i class="fab fa-product-hunt"></i>
                        </div>
                    </div>
                    <div class="d-block mt-3">
                        <div class="numbers">
                            <h2 class="card-title"><b>{{__('Add Physical Product')}}</b></h2>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-4">
        <a href="{{ route('back.digital.item.create') }}" class="card card-stats card-round">
            <div class="card-body">
                <div class="text-center py-3">
                    <div class="d-inline-block">
                        <div class="icon-big text-center icon-info bubble-shadow-small  px-3">
                            <i class="fab fa-digital-ocean"></i>
                        </div>
                    </div>
                    <div class="d-block mt-3">
                        <div class="numbers">
                            <h2 class="card-title"><b>{{__('Add Digital Product')}}</b></h2>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-4">
        <a href="{{ route('back.license.item.create') }}" class="card card-stats card-round">
            <div class="card-body">
                <div class="text-center py-3">
                    <div class="d-inline-block">
                        <div class="icon-big text-center icon-success bubble-shadow-small  px-3">
                            <i class="far fa-copyright"></i>
                        </div>
                    </div>
                    <div class="d-block mt-3">
                        <div class="numbers">
                            <h2 class="card-title"><b>{{__('Add Licence Product')}}</b></h2>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

</div>

@endsection
