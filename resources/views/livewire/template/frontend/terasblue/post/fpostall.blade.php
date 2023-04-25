<div>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Blog</h2>
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li>Blog</li>
                    </ol>
                </div>

            </div>
        </div><!-- End Breadcrumbs -->

        <!-- ======= Blog Section ======= -->
        <section id="blog" class="blog py-5">
            <div class="container" data-aos="fade-up">

                <div class="row g-5">

                    <div class="col-lg-8">

                        <div class="row">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-lg">
                                    <img src="{{ asset('') }}assets/frontend/images/blog/blog-1.jpg"
                                        class="card-img-top" alt="...">
                                    <div class="card-img-overlay text-end">
                                        <span class="badge text-bg-primary">Berita</span>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('frontend.post.detail') }}">
                                            <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit Lorem ipsum
                                                dolor sit amet, consectetur adipisicing eli Lorem ipsum dolor sit amet,
                                                consectetur
                                                adipisicing eli</h6>
                                        </a>
                                    </div>
                                    <div
                                        class="card-footer bg-white d-flex justify-content-between align-items-center ">
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
                                    <img src="{{ asset('') }}assets/frontend/images/blog/blog-2.jpg"
                                        class="card-img-top" alt="...">
                                    <div class="card-img-overlay text-end">
                                        <span class="badge text-bg-primary">Berita</span>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('frontend.post.detail') }}">
                                            <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit</h6>
                                        </a>
                                    </div>
                                    <div
                                        class="card-footer bg-white d-flex justify-content-between align-items-center ">
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
                                    <img src="{{ asset('') }}assets/frontend/images/blog/blog-3.jpg"
                                        class="card-img-top" alt="...">
                                    <div class="card-img-overlay text-end">
                                        <span class="badge text-bg-primary">Berita</span>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('frontend.post.detail') }}">
                                            <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit</h6>
                                        </a>
                                    </div>
                                    <div
                                        class="card-footer bg-white d-flex justify-content-between align-items-center ">
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
                                    <img src="{{ asset('') }}assets/frontend/images/blog/blog-4.jpg"
                                        class="card-img-top" alt="...">
                                    <div class="card-img-overlay text-end">
                                        <span class="badge text-bg-primary">Berita</span>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('frontend.post.detail') }}">
                                            <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit Lorem ipsum
                                                dolor sit amet, consectetur adipisicing eli</h6>
                                        </a>
                                    </div>
                                    <div
                                        class="card-footer bg-white d-flex justify-content-between align-items-center ">
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
                        </div>
                        <!-- End blog posts list -->

                        <div class="blog-pagination">
                            <ul class="justify-content-center">
                                <li><a href="#">1</a></li>
                                <li class="active"><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                            </ul>
                        </div><!-- End blog pagination -->

                    </div>

                    <div class="col-lg-4">

                        @livewire('template.frontend.terasblue.partials.sidebarpost')

                    </div>

                </div>

            </div>
        </section>
        <!-- End Blog Section -->

    </main><!-- End #main -->
</div>
