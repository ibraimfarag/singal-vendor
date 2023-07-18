@extends('master.front')
@section('title')
    {{__('Blog Details')}}
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
                <li><a href="{{route('front.blog')}}">{{__('Blog')}}</a>
                </li>
                <li class="separator"></li>
                <li>{{$post->title}}</li>
              </ul>
          </div>
      </div>
    </div>
  </div>
  <!-- Page Content-->
  <div class="container padding-bottom-3x mb-1">
  <div class="row">
          <!-- Content-->
          <div class="col-xl-9 col-lg-8 order-lg-2">
            <div class="card blog-details-box">
                <!-- Gallery-->
                <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: true, &quot;dots&quot;: true, &quot;loop&quot;: true }">

                    @foreach (json_decode($post->photo,true) as $photo)
                    <img src="{{asset('assets/images/'.$photo)}}" alt="Image">
                    @endforeach
                </div>
                <div class="blog-details-main-content">
                    <h2 class="pt-4">{{$post->title}}</h2>
                <ul class="post-meta mb-4">
                    <li><i class="icon-user"></i><a href="javascript:;}">{{__('Admin')}}</a></li>
                    <li><i class="icon-tag"></i><a href="{{route('front.blog').'?category='.$post->category->slug}}">{{$post->category->name}}</a></li>
                    <li><i class="icon-clock"></i><a href="javascript:;">{{ date('jS F, Y', strtotime($post->created_at)) }}</a></li>
                    </ul>
                <div>
                    {!! $post->details !!}
                </div>

                <!-- Post Tags + Share-->
                <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 pb-4">

                    @if ($post->tags)
                    <div class="pb-2">
                        {{ __('Tags :') }}
                        @foreach (explode(',',$post->tags) as $tag)
                        @if($loop->last)
                        <a class="text-sm text-muted navi-link" href="{{route('front.blog').'?tag='.$tag}}">{{$tag}}</a>
                        @else
                        <a class="text-sm text-muted navi-link" href="{{route('front.blog').'?tag='.$tag}}">{{$tag}}</a>,
                        @endif
                        @endforeach
                    </div>
                    @endif



                    <div class="pb-2"><span class="d-inline-block align-middle text-sm text-muted">Share post:</span>
                        <a class="social-button shape-rounded sb-facebook" href="#" data-toggle="tooltip" data-placement="top" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="social-button shape-rounded sb-twitter" href="#" data-toggle="tooltip" data-placement="top" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="social-button shape-rounded sb-linkedin" href="#" data-toggle="tooltip" data-placement="top" title="LinkedIn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
                </div>
            </div>


            @if($post->category->posts->where('id','!=',$post->id)->count() > 0)

                <div class="row">
                    <div class="col-lg-12 pb-2">
                        <div class="section-title">
                            <h2 class="h3">{{ __('You May Also Like') }}</h2>
                        </div>
                    </div>
                </div>
                <!-- Relevant Posts-->
                <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;loop&quot;: false, &quot;autoHeight&quot;: true, &quot;margin&quot;: 30, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;630&quot;:{&quot;items&quot;:2},&quot;991&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}} }">

                    @foreach ($post->category->posts->where('id','!=',$post->id) as $like_post)
                    <div class="widget widget-featured-posts">
                        <div class="entry">
                        <div class="entry-thumb"><a href="{{route('front.blog.details',$like_post->slug)}}"><img src="{{asset('assets/images/'.json_decode($like_post->photo,true)[array_key_first(json_decode($like_post->photo,true))])}}" alt="Post"></a></div>
                        <div class="entry-content">
                            <h4 class="entry-title"><a href="{{route('front.blog.details',$like_post->slug)}}">
                                {{ strlen(strip_tags($like_post->title)) > 75 ? substr(strip_tags($like_post->title), 0, 75) . '...' : strip_tags($like_post->title) }}
                            </a></h4><span class="entry-meta">{{__('by')}} {{__('Admin')}}</span>
                        </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

          </div>
          <!-- Sidebar          -->
          <div class="col-xl-3 col-lg-4 order-lg-1">
            <div class="sidebar-toggle position-left"><i class="icon-filter"></i></div>
            <aside class="sidebar sidebar-offcanvas position-left"><span class="sidebar-close"><i class="icon-x"></i></span>
              <!-- Widget Search-->
              <section class="widget">
                <form action="{{route('front.blog')}}" class="input-group form-group" method="get"><span class="input-group-btn">
                    <button type="submit"><i class="icon-search"></i></button></span>
                  <input class="form-control" name="search" type="text" placeholder="{{ __('Search blog') }}">
                </form>
              </section>
              <!-- Widget Categories-->
              <section class="widget widget-categories card rounded p-4 mt-n3">
                <h3 class="widget-title">{{__('Blog Categories')}}</h3>
                <ul>
                  @foreach ($categories as $category)
                  <li><a href="{{route('front.blog').'?category='.$category->slug}}">{{$category->name}}</a><span>{{$category->posts_count}}</span></li>
                  @endforeach

                </ul>
              </section>
              <!-- Widget Featured Posts-->
              <section class="widget widget-featured-posts card rounded p-4">
                <h3 class="widget-title">{{__('Most Recent Added Posts')}}</h3>
               @foreach ($posts as $recent)
               <div class="entry">
                <div class="entry-thumb"><a href="{{route('front.blog.details',$recent->slug)}}"><img src="{{ asset('assets/images/'.json_decode($recent->photo,true)[array_key_first(json_decode($recent->photo,true))]) }}" alt="Post"></a></div>
                <div class="entry-content">
                  <h4 class="entry-title"><a href="{{route('front.blog.details',$recent->slug)}}">
                    {{ strlen(strip_tags($recent->title)) > 55 ? substr(strip_tags($recent->title), 0, 55) . '...' : strip_tags($recent->title) }}

                </a></h4><span class="entry-meta">{{__('by')}} {{__('Admin')}}</span>
                </div>
              </div>
               @endforeach
              </section>
              <!-- Widget Tags-->
              <section class="widget widget-featured-posts card rounded p-4">
                <h3 class="widget-title">{{__('Popular Tags')}}</h3>
               <div>
                @foreach ($tags as $tag)
                <a class="tag" href="{{route('front.blog').'?tag='.$tag}}">{{$tag}}</a>
                @endforeach
               </div>
              </section>
            </aside>
          </div>
        </div>
  </div>
@endsection
