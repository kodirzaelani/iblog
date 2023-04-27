<div>
    @auth
        @php
            $currentUser = Auth::user();
        @endphp
    @endauth

    <!-- Main content -->
    <section class="content">
        <div class="row align-items-end">
            <div class="col-xl-9 col-12">
                <div class="box bg-primary pull-up">
                    <div class="box-body p-xl-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-3"><img
                                    src="{{ asset('') }}assets/backend/nusantara/images/svg-icon/color-svg/custom-14.svg"
                                    alt=""></div>
                            <div class="col-12 col-lg-9">
                                <h2>Hello {{ $currentUser->name }}, Welcome Back!</h2>
                                <p class="text-white-50 mb-0 fs-16">
                                    Masjid Islamic Center Kalimanan Timur
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-12">
                <div class="box bg-transparent no-shadow">
                    <div class="box-body p-xl-0 text-center">
                        <h3 class="px-30 mb-20">Have More<br>info to share?</h3>
                        @if (auth()->user()->can('posts.create'))
                            <a href="{{ route('backend.posts.create') }}"
                                class="waves-effect waves-light w-p100 btn btn-primary"><i class="fa fa-plus me-15"></i>
                                Cheate New Post</a>
                        @else
                            <button type="button" class="waves-effect waves-light w-p100 btn btn-default"
                                title="No Permission"><i class="fa fa-plus me-15"></i> Cheate New Post</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-xl-3 col-md-6 col-12">
                <a href="{{ route('backend.pages.index') }}">
                    <div class="box bg-dark pull-up" style="background-image: url({{ asset('')}}assets//images/svg-icon/color-svg/st-1.svg); background-position: right bottom; background-repeat: no-repeat;">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pe-2 justify-content-between">
                                </div>
                                <h4 class="mt-25 mb-5">Pages</h4>
                                <p class="text-fade mb-0 fs-20">{{ $pages->count() }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <a href="{{ route('backend.posts.index') }}">
                    <div class="box bg-dark pull-up" style="background-image: url({{ asset('')}}assets//images/svg-icon/color-svg/st-2.svg); background-position: right bottom; background-repeat: no-repeat;">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pe-2 justify-content-between">
                                </div>
                                <h4 class="mt-25 mb-5">Posts</h4>
                                <p class="text-fade mb-0 fs-20">{{ $posts->count() }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <a href="{{ route('backend.greetings.index') }}">
                    <div class="box bg-dark pull-up" style="background-image: url({{ asset('')}}assets//images/svg-icon/color-svg/st-3.svg); background-position: right bottom; background-repeat: no-repeat;">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pe-2 justify-content-between">

                                </div>
                                <h4 class="mt-25 mb-5">Sambutan</h4>
                                <p class="text-fade mb-0 fs-20">{{ $greetings->count() }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <a href="{{ route('backend.pengajian.index') }}">
                    <div class="box bg-dark pull-up" style="background-image: url({{ asset('')}}assets//images/svg-icon/color-svg/st-4.svg); background-position: right bottom; background-repeat: no-repeat;">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pe-2 justify-content-between">

                                </div>
                                <h4 class="mt-25 mb-5">Jadwal Pengajian</h4>
                                <p class="text-fade mb-0 fs-20">{{ $pengajians->count() }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div> --}}
</div>
<div class="row">
    <div class="col-lg-6 col-12">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title"><i class="fa fa-video-camera" aria-hidden="true"></i> Galeri Video</h4>
                <ul class="box-controls pull-right d-md-flex d-none">
                    <li>
                        <a href="{{ route('backend.video.index') }}" class="btn btn-primary-light px-10">View All</a>
                    </li>
                </ul>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Place somewhere in the <body> of your page -->
                <div class="flexslider">
                    <ul class="slides">
                        {{-- @foreach ($videos as $item)
                            <li>
                                <iframe width="415" height="275"
                                    src="https://www.youtube.com/embed/{{ $item->video }}" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                <img src="{{ ($item->imageThumbUrl) ? $item->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="slide">
                                <p class="flex-caption">{{ $item->title }}</p>
                            </li>
                        @endforeach --}}
                    </ul>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title"><i class="fa fa-picture-o" aria-hidden="true"></i> Galeri Photo</h4>
                <ul class="box-controls pull-right d-md-flex d-none">
                    <li>
                        <a href="{{ route('backend.albums.index') }}" class="btn btn-primary-light px-10">View All</a>
                    </li>
                </ul>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Place somewhere in the <body> of your page -->
                <div class="flexslider">
                    <ul class="slides">
                        {{-- @foreach ($albums as $item)
                            <li>
                                <img src="{{ $item->imageUrl ? $item->imageUrl : '/assets/images/no_image.png' }}"
                                    alt="slide">
                                <p class="flex-caption">{{ $item->title }}</p>
                            </li>
                        @endforeach --}}
                    </ul>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
</section>
@push('scripts')
    <script src="{{ asset('') }}assets/vendor_plugins/bootstrap-slider/bootstrap-slider.js"></script>
    <script src="{{ asset('') }}assets/vendor_components/OwlCarousel2/dist/owl.carousel.js"></script>
    <script src="{{ asset('') }}assets/vendor_components/flexslider/jquery.flexslider.js"></script>


    <script src="4f/js/pages/slider.js"></script>
@endpush
<!-- /.content -->
</div>
