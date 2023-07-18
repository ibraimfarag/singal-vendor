@extends('master.front')

@section('title')
    {{__('Product')}}
@endsection

@section('meta')
<meta name="keywords" content="{{$item->meta_keywords}}">
<meta name="description" content="{{$item->meta_description}}">
@endsection

@section('content')
<div class="page-title">
    <div class="container">
      <div class="row">
          <div class="col-lg-12">
            <ul class="breadcrumbs">
                <li><a href="{{route('front.index')}}">{{__('Home')}}</a>
                </li>
                <li class="separator"></li>
                <li><a href="{{route('front.catalog')}}">{{__('Shop')}}</a>
                </li>
                <li class="separator"></li>
                <li>{{$item->name}}</li>
              </ul>
          </div>
      </div>
    </div>
</div>
  <!-- Page Content-->
<div class="container padding-bottom-1x mb-1">
    <div class="row">
      <!-- Poduct Gallery-->
      <div class="col-xxl-5 col-lg-6 col-md-6">
        <div class="product-gallery">
          @if ($item->video)
          <div class="gallery-wrapper">
            <div class="gallery-item video-btn text-center"><a href="javascript:;" data-toggle="tooltip" data-type="video" data-video="&lt;div class=&quot;wrapper&quot;&gt;&lt;div class=&quot;video-wrapper&quot;&gt;&lt;iframe class=&quot;pswp__video&quot; width=&quot;960&quot; height=&quot;640&quot; src=&quot;https://www.youtube.com/embed/{{$video}}&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;&lt;/div&gt;&lt;/div&gt;" title="Watch video"></a></div>
          </div>
          @endif
          @if($item->is_stock())
          <span class="product-badge
          @if($item->is_type == 'feature')
          bg-warning
          @elseif($item->is_type == 'new')
          bg-success
          @elseif($item->is_type == 'top')
          bg-info
          @elseif($item->is_type == 'best')
          bg-dark
          @elseif($item->is_type == 'flash_deal')
            bg-success
          @endif
          ">{{   ucfirst(str_replace('_',' ',$item->is_type))   }}</span>

          @else
          <span class="product-badge bg-secondary border-default text-body
          ">{{__('out of stock')}}</span>
          @endif

          @if($item->previous_price && $item->previous_price !=0)
          <div class="product-badge bg-goldenrod  ppp-t"> -{{PriceHelper::DiscountPercentage($item)}}</div>
          @endif
          <div class="product-carousel owl-carousel gallery-wrapper">
            <div class="gallery-item" itemscope data-hash="one"><a href="{{asset('assets/images/'.$item->photo)}}" data-size="1000x1000"><img src="{{asset('assets/images/'.$item->photo)}}" alt="Product"></a></div>

            @foreach ($galleries as $key => $gallery)
            <div class="gallery-item" itemscope data-hash="gallery{{$key}}"><a href="{{asset('assets/images/'.$gallery->photo)}}" data-size="1000x1000"><img src="{{asset('assets/images/'.$gallery->photo)}}" alt="Product"></a></div>
            @endforeach
          </div>
          <ul class="product-thumbnails">
            <li class="active"><a href="#one"><img src="{{asset('assets/images/'.$item->photo)}}" alt="Product"></a></li>

            @foreach ($galleries as $key => $gallery)
            <li><a href="#gallery{{$key}}"><img src="{{asset('assets/images/'.$gallery->photo)}}" alt="Product"></a></li>
            @endforeach
          </ul>
        </div>
      </div>

        @php
        function renderStarRating($rating,$maxRating=5) {

                $fullStar = "<i class = 'far fa-star filled'></i>";
                $halfStar = "<i class = 'far fa-star-half filled'></i>";
                $emptyStar = "<i class = 'far fa-star'></i>";
            $rating = $rating <= $maxRating?$rating:$maxRating;

            $fullStarCount = (int)$rating;
            $halfStarCount = ceil($rating)-$fullStarCount;
            $emptyStarCount = $maxRating -$fullStarCount-$halfStarCount;

            $html = str_repeat($fullStar,$fullStarCount);
            $html .= str_repeat($halfStar,$halfStarCount);
            $html .= str_repeat($emptyStar,$emptyStarCount);
            $html = $html;
            return $html;
        }
        @endphp
        <!-- Product Info-->
        <div class="col-xxl-7 col-lg-6 col-md-6">
            <div class="details-page-top-right-content d-flex align-items-center">
                <div class="div w-100">
                    <input type="hidden" id="item_id" value="{{$item->id}}">
                    <input type="hidden" id="demo_price" value="{{PriceHelper::setConvertPrice($item->discount_price)}}">
                    <input type="hidden" value="{{PriceHelper::setCurrencySign()}}" id="set_currency">
                    <input type="hidden" value="{{PriceHelper::setCurrencyValue()}}" id="set_currency_val">
                    <input type="hidden" value="{{$setting->currency_direction}}" id="currency_direction">
                    <h4 class="mb-2">{{$item->name}}</h4>
                    <div class="mb-3">
                        <div class="rating-stars d-inline-block gmr-3">
                        {!!renderStarRating($item->reviews->avg('rating'))!!}
                        </div>
                        @if ($item->is_stock())
                            <span class="text-success  d-inline-block">{{__('In Stock')}}</span>
                        @else
                            <span class="text-danger  d-inline-block">{{__('Out of stock')}}</span>
                        @endif
                    </div>


                    @if($item->is_type == 'flash_deal')
                    @if (date('d-m-y') != \Carbon\Carbon::parse($item->date)->format('d-m-y'))
                    <div class="countdown countdown-alt mb-3" data-date-time="{{ $item->date }}">
                    </div>
                    @endif
                    @endif

                    <span class="h3 d-block">
                    @if ($item->previous_price != 0)
                        <small class="d-inline-block"><del>{{PriceHelper::setPreviousPrice($item->previous_price)}}</del></small>
                    @endif
                    <span id="main_price">{{PriceHelper::grandCurrencyPrice($item)}}</span>
                    </span>

                    <p class="text-muted">{{$item->sort_details}} <a href="#details" class="scroll-to">{{__('Read more')}}</a></p>

                    <div class="row margin-top-1x">
                        @foreach($attributes as $attribute)
                        @if($attribute->options->count() != 0)
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label for="{{ $attribute->name }}">{{ $attribute->name }}</label>
                                <select class="form-control attribute_option" id="{{ $attribute->name }}">
                                    @foreach($attribute->options as $option)
                                    <option value="{{ $option->name }}" data-type="{{$attribute->id}}" data-href="{{$option->id}}" data-target="{{PriceHelper::setConvertPrice($option->price)}}">{{ $option->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row align-items-end pb-4">
                        @if ($item->item_type != 'digital')
                            <div class="col-sm-4">
                                <div class="form-group mb-0">
                                    <label for="quantity">{{__('Quantity')}}</label>
                                    <select class="form-control" id="quantity">
                                        <option>{{ __('1') }}</option>
                                        <option>{{ __('2') }}</option>
                                        <option>{{ __('3') }}</option>
                                        <option>{{ __('4') }}</option>
                                        <option>{{ __('5') }}</option>
                                        <option>{{ __('6') }}</option>
                                        <option>{{ __('7') }}</option>
                                        <option>{{ __('8') }}</option>
                                        <option>{{ __('9') }}</option>
                                        <option>{{ __('10') }}</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-8">
                            <div class="pt-4 hidden-sm-up"></div>
                            @if ($item->is_stock())
                                <button class="btn btn-primary  m-0" id="add_to_cart"><i class="icon-bag"></i>{{ __('Add to Cart') }}</button>
                                <button class="btn btn-primary  m-0" id="but_to_cart"><i class="icon-bag"></i>{{ __('Buy Now') }}</button>
                            @else
                                <button class="btn btn-secondary  m-0"><i class="icon-bag"></i> {{__('Out of stock')}}</button>
                            @endif
                        </div>

                    </div>
                    <div class="div">
                        <div class="t-c-b-area">
                            @if ($item->brand_id)
                            <div class="pt-1 mb-1"><span class="text-medium">{{__('Brand')}}:</span>
                                    <a href="{{route('front.catalog').'?brand='.$item->brand->slug}}">{{$item->brand->name}}</a>
                                </div>
                            @endif

                                <div class="pt-1 mb-1"><span class="text-medium">{{__('Categories')}}:</span>
                                    <a href="{{route('front.catalog').'?category='.$item->category->slug}}">{{$item->category->name}}</a>
                                        @if ($item->subcategory->name)
                                        /
                                        @endif
                                    <a href="{{route('front.catalog').'?subcategory='.$item->subcategory->slug}}">{{$item->subcategory->name}}</a>
                                        @if ($item->childcategory->name)
                                        /
                                        @endif
                                    <a href="{{route('front.catalog').'?childcategory='.$item->childcategory->slug}}">{{$item->childcategory->name}}</a>
                                </div>
                                <div class="pt-1 mb-1"><span class="text-medium">{{__('Tags')}}:</span>
                                    @if($item->tags)
                                    @foreach (explode(',',$item->tags) as $tag)
                                    @if ($loop->last)
                                    <a href="{{route('front.catalog').'?tag='.$tag}}">{{$tag}}</a>
                                    @else
                                    <a href="{{route('front.catalog').'?tag='.$tag}}">{{$tag}}</a>,
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                                @if ($item->item_type = 'digital' || $item->item_type = 'licence')
                                @else
                                <div class="pt-1 mb-4"><span class="text-medium">{{__('SKU')}}:</span> #{{$item->sku}}</div>
                                @endif
                        </div>
                        <hr class="mb-2 mt-2">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="mt-2 mb-2">
                                <a class="btn btn-outline-primary btn-sm wishlist_store wishlist_text" href="{{route('user.wishlist.store',$item->id)}}"><i class="icon-heart"></i>
                                @if (Auth::check() && App\Models\Wishlist::where('user_id',Auth::user()->id)->where('item_id',$item->id)->exists())
                                {{__('Added To Wishlist')}}
                                @else
                                <span class="wishlist1">{{__('Wishlist')}}</span>
                                <span class="wishlist2 d-none">{{__('Added To Wishlist')}}</span>
                                @endif
                                </a>
                                <button class="btn btn-outline-primary btn-sm  product_compare" data-target="{{route('fornt.compare.product',$item->id)}}" ><i class="icon-repeat"></i>{{__('Compare')}}</button>
                            </div>

                            <div class="mt-2 mb-2"><span class="text-muted">{{__('Share')}}:</span>
                                <div class="d-inline-block a2a_kit a2a_kit_size_32">
                                <a class="facebook social-button shape-rounded a2a_button_facebook" href="">
                                    <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="twitter social-button shape-rounded a2a_button_twitter" href="">
                                    <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="linkedin social-button shape-rounded a2a_button_linkedin" href="">
                                    <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a class="pinterest social-button shape-rounded a2a_button_pinterest" href="">
                                    <i class="fab fa-pinterest"></i>
                                    </a>
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row padding-top-3x mb-3" id="details">
            <div class="col-lg-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">{{__('Descriptions')}}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button" role="tab" aria-controls="specification" aria-selected="false">{{__('Specifications')}}</a>
                </li>
            </ul>
            <div class="tab-content card">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab"">
                {!! $item->details !!}
                </div>
                <div class="tab-pane fade show" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                <div class="comparison-table">
                    <table class="table table-bordered">
                        <thead class="bg-secondary">
                        </thead>
                        <tbody>
                        <tr class="bg-secondary">
                            <th class="text-uppercase">{{__('Specifications')}}</th>
                            <td><span class="text-medium">{{__('Descriptions')}}</span></td>
                        </tr>
                        @if($sec_name)
                        @foreach(array_combine($sec_name,$sec_details) as  $sname => $sdetail)
                        <tr>
                            <th>{{$sname}}</th>
                            <td>{{$sdetail}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="text-center">
                            <td colspan="2">{{__('No Specifications')}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


  <!-- Reviews-->
  <div class="container  review-area">
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2 class="h3">{{ __('Latest Reviews') }}</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
              @forelse ($reviews as $review)
              <div class="single-review">
                  <div class="comment">
                    <div class="comment-author-ava"><img class="lazy" data-src="{{asset('assets/images/'.$review->user->photo)}}" alt="Comment author"></div>
                    <div class="comment-body">
                      <div class="comment-header d-flex flex-wrap justify-content-between">
                        <div>
                            <h4 class="comment-title mb-1">{{$review->subject}}</h4>
                            <span>{{$review->user->first_name}}</span>
                            <span class="ml-3">{{$review->created_at->format('M d, Y')}}</span>
                        </div>
                        <div class="mb-2">
                          <div class="rating-stars">
                            @php
                                for($i=0; $i<$review->rating;$i++){
                                 echo "<i class = 'far fa-star filled'></i>";
                                }
                            @endphp
                          </div>
                        </div>
                      </div>
                      <p class="comment-text  mt-2">{{$review->review}}</p>

                    </div>
                  </div>
              </div>
              @empty
              <div class="card p-5">
                {{__('No Review')}}
              </div>
              @endforelse
              <div class="row mt-15">
                <div class="col-lg-12 text-center">
                    {{$reviews->links()}}
                </div>
            </div>

          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="text-center">
                  <div class="d-inline align-baseline display-3 mr-1">{{ round($item->reviews->avg('rating'),2)}}</div>
                  <div class="d-inline align-baseline text-sm text-warning mr-1">
                    <div class="rating-stars">{!!renderStarRating($item->reviews->avg('rating'))!!}</div>
                  </div>
                </div>
                <div class="pt-3">
                  <label class="text-medium text-sm">5 {{__('stars')}} <span class="text-muted">- {{$item->reviews->where('status',1)->where('rating',5)->count()}}</span></label>
                  <div class="progress margin-bottom-1x">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$item->reviews->where('status',1)->where('rating',5)->sum('rating') * 20}}%; height: 2px;" aria-valuenow="100" aria-valuemin="{{$item->reviews->where('rating',5)->sum('rating') * 20}}" aria-valuemax="100"></div>
                  </div>
                  <label class="text-medium text-sm">4 {{__('stars')}} <span class="text-muted">- {{$item->reviews->where('status',1)->where('rating',4)->count()}}</span></label>
                  <div class="progress margin-bottom-1x">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$item->reviews->where('status',1)->where('rating',4)->sum('rating') * 20}}%; height: 2px;" aria-valuenow="{{$item->reviews->where('rating',4)->sum('rating') * 20}}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <label class="text-medium text-sm">3 {{__('stars')}} <span class="text-muted">- {{$item->reviews->where('status',1)->where('rating',3)->count()}}</span></label>
                  <div class="progress margin-bottom-1x">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$item->reviews->where('rating',3)->sum('rating') * 20}}%; height: 2px;" aria-valuenow="{{$item->reviews->where('rating',3)->sum('rating') * 20}}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <label class="text-medium text-sm">2 {{__('stars')}} <span class="text-muted">- {{$item->reviews->where('status',1)->where('rating',2)->count()}}</span></label>
                  <div class="progress margin-bottom-1x">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$item->reviews->where('status',1)->where('rating',2)->sum('rating') * 20}}%; height: 2px;" aria-valuenow="{{$item->reviews->where('rating',2)->sum('rating') * 20}}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <label class="text-medium text-sm">1 {{__('star')}} <span class="text-muted">- {{$item->reviews->where('status',1)->where('rating',1)->count()}}</span></label>
                  <div class="progress mb-2">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$item->reviews->where('status',1)->where('rating',1)->sum('rating') * 20}}; height: 2px;" aria-valuenow="0" aria-valuemin="{{$item->reviews->where('rating',1)->sum('rating') * 20}}" aria-valuemax="100"></div>
                  </div>
                </div>
                @if (Auth::user())
                <div class="pb-2"><a class="btn btn-primary btn-block" href="#" data-bs-toggle="modal" data-bs-target="#leaveReview">{{__('Leave a Review')}}</a></div>
                @else
                <div class="pb-2"><a class="btn btn-primary btn-block" href="{{route('user.login')}}" >{{__('Login')}}</a></div>
                @endif
              </div>
            </div>
          </div>


    </div>
  </div>

  @if(count($related_items)>0)
  <div class="relatedproduct-section container padding-bottom-3x mb-1 s-pt-30">
    <!-- Related Products Carousel-->
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title">
                <h2 class="h3">{{ __('You May Also Like') }}</h2>
            </div>
        </div>
    </div>
    <!-- Carousel-->
    <div class="row">
        <div class="col-lg-12">
            <div class="relatedproductslider owl-carousel" >
                @foreach ($related_items as $related)
                    <div class="slider-item">
                        <div class="product-card">

                            @if ($related->is_stock())
                                @if($related->is_type == 'new')
                                @else
                                    <div class="product-badge
                                    @if($related->is_type == 'feature')
                                    bg-warning

                                    @elseif($related->is_type == 'top')
                                    bg-info
                                    @elseif($related->is_type == 'best')
                                    bg-dark
                                    @elseif($related->is_type == 'flash_deal')
                                    bg-success
                                    @endif
                                    ">{{ ucfirst(str_replace('_',' ',$related->is_type)) }}</div>
                                    @endif
                                    @else
                                    <div class="product-badge bg-secondary border-default text-body
                                    ">{{__('out of stock')}}</div>
                            @endif
                                    @if($related->previous_price && $related->previous_price !=0)
                                    <div class="product-badge product-badge2 bg-info"> -{{PriceHelper::DiscountPercentage($related)}}</div>
                            @endif

                            @if($related->previous_price && $related->previous_price !=0)
                            <div class="product-badge product-badge2 bg-info"> -{{PriceHelper::DiscountPercentage($related)}}</div>
                            @endif
                            <a class="product-thumb" href="{{route('front.product',$related->slug)}}"><img class="lazy" data-src="{{asset('assets/images/'.$related->thumbnail)}}" alt="Product"></a>
                            <div class="product-card-body">
                              <div class="product-category"><a href="{{route('front.catalog').'?category='.$related->category->slug}}">{{$related->category->name}}</a></div>
                              <h3 class="product-title"><a href="{{route('front.product',$related->slug)}}">
                                {{ strlen(strip_tags($related->name)) > 45 ? substr(strip_tags($related->name), 0, 45) . '...' : strip_tags($related->name) }}
                            </a></h3>
                              <h4 class="product-price">
                                @if ($related->previous_price !=0)
                                    <del>{{PriceHelper::setPreviousPrice($related->previous_price)}}</del>
                                @endif
                                {{PriceHelper::grandCurrencyPrice($related)}} </h4>
                            </div>
                            <div class="product-button-group">
                              <a class="product-button wishlist_store" href="{{route('user.wishlist.store',$related->id)}}"><i class="icon-heart"></i><span>{{__('Wishlist')}}</span></a>
                              <a class="product-button product_compare" href="javascript:;" data-target="{{route('fornt.compare.product',$related->id)}}"><i class="icon-repeat"></i><span>{{__('Compare')}}</span></a>
                              @if ($item->is_stock())
                                <a class="product-button add_to_single_cart" href="javascript:;" data-target="{{$related->id}}"><i class="icon-shopping-cart"></i><span>{{__('To Cart')}}</span>
                                </a>
                                @else
                                <a class="product-button" href="{{route('front.product',$related->slug)}}"><i class="icon-arrow-right"></i><span>{{__('Details')}}</span></a>
                                @endif
                              </div>
                          </div>
                    </div>
                @endforeach
              </div>
        </div>
    </div>
  </div>
  @endif

  <!-- Photoswipe container-->
  <!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="pswp__bg"></div>

    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>


                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>


@auth
<form class="modal fade ratingForm" action="{{route('front.review.submit')}}" method="post" id="leaveReview" tabindex="-1">
  @csrf
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{__('Leave a Review')}}</h4>
        <button class="close modal_close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        @php
            $user = Auth::user();
        @endphp
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="review-name">{{__('Your Name')}}</label>
              <input class="form-control" type="text" id="review-name" value="{{$user->first_name}}" required>
            </div>
          </div>
          <input type="hidden" name="item_id" value="{{$item->id}}">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="review-email">{{__('Your Email')}}</label>
              <input class="form-control" type="email" id="review-email" value="{{$user->email}}" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="review-subject">{{__('Subject')}}</label>
              <input class="form-control" type="text" name="subject" id="review-subject" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="review-rating">{{__('Rating')}}</label>
              <select name="rating" class="form-control" id="review-rating">
                <option value="5">5 {{__('Stars')}}</option>
                <option value="4">4 {{__('Stars')}}</option>
                <option value="3">3 {{__('Stars')}}</option>
                <option value="2">2 {{__('Stars')}}</option>
                <option value="1">1 {{__('Star')}}</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="review-message">{{__('Review')}}</label>
          <textarea class="form-control" name="review" id="review-message" rows="8" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">{{__('Submit Review')}}</button>
      </div>
    </div>
  </div>
</form>
@endauth

@endsection
