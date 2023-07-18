@extends('master.back')

@section('content')

<div class="container-fluid">

<!-- Page Heading -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h3 class="mb-0 bc-title"><b>{{ __('Create License Product') }}</b> </h3>
            <a class="btn btn-primary   btn-sm" href="{{route('back.item.index')}}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
        </div>
    </div>
</div>

<!-- Form -->
<div class="row">

<div class="col-xl-12 col-lg-12 col-md-12">

    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body pt4">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">

                        <form class="admin-form tab-form" action="{{ route('back.license.item.store') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" value="license" name="item_type">

                            <div class="row justify-content-center">

                                <div class="col-lg-12">
                                    @include('alerts.alerts')

                                    <div class="form-group">
                                        <label
                                            for="name">{{ __('Current Featured Image') }} *</label>
                                        <br>
                                            <img class="admin-img lg"
                                                src="{{ asset('assets/images/placeholder.png') }}"
                                                alt="No Image Found">
                                        <br>
                                        <span class="mt-1">{{ __('Image Size Should Be 570 x 341.') }}</span>
                                    </div>

                                    <div class="form-group position-relative ">
                                        <label class="file">
                                            <input type="file"  accept="image/*"   class="upload-photo" name="photo"
                                                id="file"  aria-label="File browser example">
                                            <span
                                                class="file-custom text-left">{{ __('Upload Image...') }}</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }} *</label>
                                        <input type="text" name="name" class="form-control item-name"
                                            id="name" placeholder="{{ __('Enter Name') }}"
                                            value="{{ old('name') }}" >
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">{{ __('Slug') }} *</label>
                                        <input type="text" name="slug" class="form-control"
                                            id="slug" placeholder="{{ __('Enter Slug') }}"
                                            value="{{ old('slug') }}" >
                                    </div>


                                    <div class="form-group">
                                        <label for="category_id">{{ __('Select Category') }} *</label>
                                        <select name="category_id" id="category_id" data-href="{{route('back.get.subcategory')}}" class="form-control" >
                                            <option value="" selected>{{__('Select One')}}</option>
                                            @foreach(DB::table('categories')->whereStatus(1)->get() as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="subcategory_id">{{ __('Select Sub Category') }} </label>
                                        <select name="subcategory_id" id="subcategory_id" data-href="{{route('back.get.childcategory')}}" class="form-control">
                                            <option value="">{{__('Select One')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="childcategory_id">{{ __('Select Sub Category') }} </label>
                                        <select name="childcategory_id" id="childcategory_id" class="form-control">
                                            <option value="">{{__('Select One')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="brand_id">{{ __('Select Brand') }} *</label>
                                        <select name="brand_id" id="brand_id" class="form-control" >
                                            @foreach(DB::table('brands')->whereStatus(1)->get() as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="file_type">{{ __('Select Type') }} *</label>
                                        <select class="form-control" id="file_type" name="file_type">
                                            <option value="file">{{__('File')}}</option>
                                            <option value="link">{{__('Link')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group view_file ">
                                        <label for="file">{{ __('File') }}
                                            *</label>
                                        <div class="input-group mb-1">
                                            <input type="file" class="form-control" id="file" name="file">
                                        </div>
                                        <p class="text-warning">{{__('File type must be zip')}}</p>
                                    </div>

                                    <div class="form-group d-none view_link">
                                        <label for="link">{{ __('Link') }}
                                            *</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="link" name="link" class="form-control" placeholder="{{__('Enter Link')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="discount_price">{{ __('Current Price') }}
                                            *</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text">{{ PriceHelper::adminCurrency() }}</span>
                                            </div>
                                            <input type="text" id="discount_price"
                                                name="discount_price" class="form-control"
                                                placeholder="{{ __('Enter Current Price') }}"
                                                min="1" step="0.1"
                                                value="{{ old('discount_price') }}" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="previous_price">{{ __('Previous Price') }}
                                            </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text">{{ $curr->sign }}</span>
                                            </div>
                                            <input type="text" id="previous_price"
                                                name="previous_price" class="form-control"
                                                placeholder="{{ __('Enter Previous Price') }}"
                                                min="1" step="0.1"
                                                value="{{ old('previous_price') }}" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sort_details">{{ __('Short Description') }} *</label>
                                        <textarea name="sort_details" id="sort_details"
                                            class="form-control"
                                            placeholder="{{ __('Short Description') }}"
                                            >{{ old('sort_details') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="video">{{ __('Add License') }} *</label>
                                    </div>

                                    <div id="license-section">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        name="license_name[]"
                                                        placeholder="{{ __('License Name') }}" value="">
                                                    </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        name="license_key[]"
                                                        placeholder="{{ __('License Key') }}" value="">
                                                    </div>
                                            </div>
                                            <div class="flex-btn">
                                                <button type="button" class="btn btn-success add-license" data-text="{{ __('License Name') }}" data-text1="{{ __('License Key') }}"> <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="details">{{ __('Description') }} *</label>
                                        <textarea name="details" id="details"
                                            class="form-control text-editor"
                                            rows="6"
                                            placeholder="{{ __('Enter Description') }}"
                                            >{{ old('details') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tax_id">{{ __('Select Tax') }} *</label>
                                        <select name="tax_id" id="tax_id" class="form-control">
                                            <option value="">{{__('Select One')}}</option>
                                            @foreach(DB::table('taxes')->whereStatus(1)->get() as $tax)
                                            <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tags">{{ __('Tags') }}
                                            </label>
                                        <input type="text" name="tags" class="tags"
                                            id="tags"
                                            placeholder="{{ __('Tags') }}"
                                            value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="video">{{ __('Video Link') }} </label>
                                        <input type="text" name="video" class="form-control"
                                            id="video" placeholder="{{ __('Enter Video Link') }}"
                                            value="{{ old('video') }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="meta_keywords">{{ __('Meta Keywords') }}
                                            </label>
                                        <input type="text" name="meta_keywords" class="tags"
                                            id="meta_keywords"
                                            placeholder="{{ __('Enter Meta Keywords') }}"
                                            value="">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="meta_description">{{ __('Meta Description') }}
                                            </label>
                                        <textarea name="meta_description" id="meta_description"
                                            class="form-control" rows="5"
                                            placeholder="{{ __('Enter Meta Description') }}"
                                        >{{ old('meta_description') }}</textarea>
                                    </div>


                                    <div class="form-group">
                                        <label class="switch-primary">
                                            <input type="checkbox" class="switch switch-bootstrap status radio-check" name="is_specification" value="1" checked>
                                            <span class="switch-body"></span>
                                            <span class="switch-text">{{ __('Specifications') }}</span>
                                        </label>
                                    </div>

                                    <div id="specifications-section">
                                        <div class="d-flex">

                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        name="specification_name[]"
                                                        placeholder="{{ __('Specification Name') }}" value="">
                                                    </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        name="specification_description[]"
                                                        placeholder="{{ __('Specification description') }}" value="">
                                                    </div>
                                            </div>
                                            <div class="flex-btn">
                                                <button type="button" class="btn btn-success add-specification" data-text="{{ __('Specification Name') }}" data-text1="{{ __('Specification Description') }}"> <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group d-flex justify-content-center">
                                <button type="submit"
                                    class="btn btn-secondary ">{{ __('Submit') }}</button>
                            </div>

                        </form>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

</div>

@endsection


@section('scripts')
    <script>
        $(document).on('change','#file_type',function(){
            let type = $(this).val();
            if(type == 'file'){
                $('.view_link').addClass('d-none');
                $('.view_file').removeClass('d-none');
                $('.view_file input').prop('required',true);
                $('.view_link input').prop('required',false);
            }else{
                $('.view_link').removeClass('d-none');
                $('.view_file').addClass('d-none');
                $('.view_file input').prop('required',false);
                $('.view_link input').prop('required',true);
            }
        })
    </script>
@endsection