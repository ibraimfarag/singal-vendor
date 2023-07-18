@extends('master.back')

@section('content')

<div class="container-fluid">

	<!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Gallery Images') }}</b> </h3>
                <a class="btn btn-primary   btn-sm" href="{{route('back.item.index')}}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                </div>
        </div>
    </div>

	<!-- Form -->
	<div class="row">

		<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card o-hidden border-0 shadow-lg">
				<div class="card-body ">
					<!-- Nested Row within Card Body -->
					<div class="row ">
						<div class="col-lg-12">
                                <form class="admin-form" action="{{ route('back.item.galleries.update') }}" method="POST"
                                    enctype="multipart/form-data">

                                    @csrf

                                    @include('alerts.alerts')

                                    <h5 class="">
                                        <b>{{ __('Multiple Images Uploading Are Allowed') }}</b>
                                    </h5>

                                    <br>

                                    <div class="d-block">

                                        @forelse($item->galleries as $gallery)
                                            <div class="single-g-item d-inline-block m-2">
                                                    <span data-toggle="modal"
                                                    data-target="#confirm-delete" href="javascript:;"
                                                    data-href="{{ route('back.item.gallery.delete',$gallery->id) }}" class="remove-gallery-img">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                    <a class="popup-link" href="{{ $gallery->photo ? asset('assets/images/'.$gallery->photo) : asset('assets/images/placeholder.png') }}">
                                                        <img class="admin-gallery-img" src="{{ $gallery->photo ? asset('assets/images/'.$gallery->photo) : asset('assets/images/placeholder.png') }}"
                                                            alt="No Image Found">
                                                    </a>
                                            </div>
                                        @empty

                                            <h6><b>{{ __('No Images Added') }}</b></h6>

                                        @endforelse

                                    </div>

                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <div class="form-group position-relative ">
                                        <label class="file">
                                            <input type="file"  accept="image/*"  name="galleries[]" id="file"
                                                aria-label="File browser example" accept="image/*" multiple>
                                            <span class="file-custom text-left">{{ __('Upload Images...') }}</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-secondary ">{{ __('Submit') }}</button>
                                    </div>

                                    <div>
                                </form>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>



{{-- DELETE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

		<!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm Delete?') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
		</div>

		<!-- Modal Body -->
        <div class="modal-body">
			{{ __('You are going to delete this image from gallery.') }} {{ __('Do you want to delete it?') }}
		</div>

		<!-- Modal footer -->
        <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
			<form action="" class="d-inline btn-ok" method="POST">

                @csrf

                @method('DELETE')

                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>

			</form>
		</div>

      </div>
    </div>
  </div>

{{-- DELETE MODAL ENDS --}}

@endsection
