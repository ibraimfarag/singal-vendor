@extends('master.back')

@section('content')

<div class="container-fluid">

<!-- Page Heading -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h3 class=" mb-0 bc-title"><b>{{ __('Language') }}</b> </h3>
            <a class="btn btn-primary btn-sm" href="{{route('back.language.index')}}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
            </div>
    </div>
</div>

  <!-- Content Row -->

  <div class="row">

    <div class="col-xl-12 col-lg-12">


        <form class="geniusform" action="{{route('back.language.update',$data->id)}}" method="POST" enctype="multipart/form-data">
            @include('alerts.alerts')
            @csrf
            @method('PUT')
            <input type="hidden"  name="language" value="{{$data->language}}">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Set Language Name') }} </h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Language Name *</label>
                        <input type="text" class="form-control"  name="language" value="{{$data->language}}"
                            placeholder="{{ __('Enter Language Name') }}">

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Set Keywords & Values of : ')}} {{$data->language}}</h6>
                </div>
                <div class="card-body p-4">
                    @foreach($lang as $key => $val)
                    <div class="single-kay  alert alert-primary">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-2">
                                <div class="delete_language_field">
                                    <button class="btn btn-danger btn-sm">
                                        {{ __('Delete') }} <i class="fas fa-times "></i></button>
                                </div>
                            </div>
                            <div class="col-lg-5 col-5">
                                <div class="form-group">
                                      <label>{{ __('Key *') }}</label>
                                      <input type="text" class="form-control" name="keys[]" value="{{ $key }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-5">
                                <div class="form-group">
                                      <label>{{ __('Value *') }}</label>
                                      <input type="text" class="form-control" name="values[]" value="{{ $val }}">
                                </div>
                            </div>
                        </div>
                    </div>


                    @endforeach

                    <div class="new-field">

                    </div>


                    <div class="row justify-content-center mt-4">
                      <button type="button" class="btn btn-secondary" id="add_more_language"><i class="fas fa-plus"> </i> {{__('Add More')}}</button>
                    </div>
                    <div class="row justify-content-center mt-4">
                      <button type="submit" class="btn btn-secondary">{{__('Submit')}}</button>
                    </div>

                </div>
            </div>
        </form>

    </div>

  </div>

</div>

@endsection
