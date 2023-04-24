<div>
    {{-- mainpost --}}
    <div class="row">

        <!-- berita section -->
        <div class="col-md-12 mb-3">
            <h4><i class="bi bi-book-half"></i> BERITA TERBARU</h4>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <img src="{{ asset('') }}assets/frontend/images/blog/blog-1.jpg" class="card-img-top" alt="...">
                <div class="card-img-overlay text-end">
                    <span class="badge text-bg-primary">Berita</span>
                </div>
                <div class="card-body">
                    <a href="{{ route('frontend.post.detail') }}">
                        <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit Lorem ipsum
                            dolor sit amet, consectetur adipisicing eli Lorem ipsum dolor sit amet, consectetur
                            adipisicing eli</h6>
                    </a>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center ">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('') }}assets/frontend/images/team/team-1.jpg"
                            class="rounded-5 rounded-circle" alt="...">
                        <a href="#">
                            <span class="author">Sakha Salahudin Rosadi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <img src="{{ asset('') }}assets/frontend/images/blog/blog-2.jpg" class="card-img-top"
                    alt="...">
                <div class="card-img-overlay text-end">
                    <span class="badge text-bg-primary">Berita</span>
                </div>
                <div class="card-body">
                    <a href="{{ route('frontend.post.detail') }}">
                        <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit</h6>
                    </a>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center ">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('') }}assets/frontend/images/team/team-1.jpg"
                            class="rounded-5 rounded-circle" alt="...">
                        <a href="#">
                            <span class="author">Sakha Salahudin Rosadi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <img src="{{ asset('') }}assets/frontend/images/blog/blog-3.jpg" class="card-img-top"
                    alt="...">
                <div class="card-img-overlay text-end">
                    <span class="badge text-bg-primary">Berita</span>
                </div>
                <div class="card-body">
                    <a href="{{ route('frontend.post.detail') }}">
                        <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit</h6>
                    </a>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center ">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('') }}assets/frontend/images/team/team-1.jpg"
                            class="rounded-5 rounded-circle" alt="...">
                        <a href="#">
                            <span class="author">Sakha Salahudin Rosadi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-lg">
                <img src="{{ asset('') }}assets/frontend/images/blog/blog-4.jpg" class="card-img-top"
                    alt="...">
                <div class="card-img-overlay text-end">
                    <span class="badge text-bg-primary">Berita</span>
                </div>
                <div class="card-body">
                    <a href="{{ route('frontend.post.detail') }}">
                        <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit Lorem ipsum
                            dolor sit amet, consectetur adipisicing eli</h6>
                    </a>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center ">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('') }}assets/frontend/images/team/team-1.jpg"
                            class="rounded-5 rounded-circle" alt="...">
                        <a href="#">
                            <span class="author">Sakha Salahudin Rosadi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- end berita section -->

        @livewire('template.frontend.terasblue.main.mainalbum')
        @livewire('template.frontend.terasblue.main.mainvideo')

    </div>
</div>
