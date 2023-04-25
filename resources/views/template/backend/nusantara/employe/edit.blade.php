@extends('template.backend.nusantara.layouts.appb')

@section('title', $title)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">@yield('title')</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.employes.index') }}">Officer list</a></li>
                        <li class="breadcrumb-item" aria-current="page">Officer Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-7 col-xl-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li><a class="active" href="#update" data-bs-toggle="tab">Officer Updates</a></li>
                    <li><a href="#usertimeline" data-bs-toggle="tab">Position Histories </a></li>
                    <li><a  href="#activity" data-bs-toggle="tab">Other Activity</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="usertimeline">
                        @livewire('template.backend.nusantara.historyposition.historypositionall')
                    </div>

                    <div class=" tab-pane" id="activity">

                            @livewire('template.backend.nusantara.otheractivity.otheractivityall')

                    </div>

                    <div class="active tab-pane" id="update">

                        <div class="box no-shadow">
                            <h4 class="box-title">Officer
                                <small>Update</small>
                            </h4>
                            <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.employes.update', $employe->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" name="status" id="status" hidden>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input
                                        name="name"
                                        type="text"
                                        required
                                        value="{{ old('name') ?? $employe->name}}"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Enter a full name">
                                        @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="birth_place">Birth Place</label>
                                                <input
                                                name="birth_place"
                                                type="text"
                                                value="{{ old('birth_place')  ?? $employe->birth_place}}"
                                                class="form-control @error('birth_place') is-invalid @enderror" placeholder="Enter a Birth Place">
                                                @error('birth_place')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="example-date-input" >Birth Date <span class="text-danger">*</span></label>
                                                <input class="form-control" type="date" name="birth_date" value="{{ old('birth_date') ?? $employe->birth_date }}" id="example-date-input">
                                                @error('birth_date')
                                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nik">NIK <span class="text-danger">*</span></label>
                                                <input
                                                name="nik"
                                                type="text"
                                                required
                                                value="{{ old('nik') ?? $employe->nik}}"
                                                class="form-control @error('nik') is-invalid @enderror" placeholder="Enter a employe nik">
                                                @error('nik')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="celuller_no">Whatapps</label>
                                                <input
                                                name="celuller_no"
                                                type="text"
                                                value="{{ old('celuller_no') ?? $employe->celuller_no }}"
                                                class="form-control @error('celuller_no') is-invalid @enderror" placeholder="Enter a Whatapps" readonly>
                                                @error('celuller_no')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input
                                                name="username"
                                                type="text"
                                                value="{{ old('username') ?? $employe->user->username}}"
                                                class="form-control @error('username') is-invalid @enderror" placeholder="Enter a username" readonly>
                                                @error('username')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input
                                                name="email"
                                                type="email"
                                                required
                                                value="{{ old('email') ?? $employe->email}}"
                                                class="text-lowercase form-control @error('email') is-invalid @enderror" placeholder="Enter a employe email" readonly>
                                                @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group @error('gender') has-error @enderror">
                                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                                <select class="form-control select2" style="width: 100%;" name="gender">
                                                    <option value="" holder>Select Gender</option>
                                                    <option value="L" {{ (old('gender') == 'L' ? 'selected': '') }}
                                                    @if($employe->gender == 'L')
                                                    selected
                                                    @endif
                                                    >Laki-laki</option>
                                                    <option value="P" {{ (old('gender') == 'P' ? 'selected': '') }}
                                                    @if($employe->gender == 'P')
                                                    selected
                                                    @endif>Perempuan</option>
                                                </select>
                                                @error('gender')
                                                <span class="help-block"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group @error('agama_id') has-error @enderror">
                                                <label class="form-label">Religi <span class="text-danger">*</span></label>
                                                <select class="form-control select2" style="width: 100%;" name="agama_id">
                                                    <option value="" holder>Select Religi</option>
                                                    @foreach ($religions as $item)
                                                    <option value="{{ $item->agamaid }}" {{ (old('agama_id') == $item->agamaid ? 'selected': '') }}
                                                        @if($item->agamaid == $employe->agama_id)
                                                        selected
                                                        @endif>{{ $item->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('agama_id')
                                                    <span class="help-block"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group @error('jenjangpendidikan_id') has-error @enderror">
                                                    <label class="form-label">Education <span class="text-danger">*</span></label>
                                                    <select class="form-control select2" style="width: 100%;" name="jenjangpendidikan_id">
                                                        <option value="" holder>Select Education</option>
                                                        @foreach ($educations as $item)
                                                        <option value="{{ $item->id }}" {{ (old('jenjangpendidikan_id') == $item->id ? 'selected': '') }}
                                                            @if($item->id == $employe->jenjangpendidikan_id)
                                                            selected
                                                            @endif
                                                            >{{ $item->title }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('jenjangpendidikan_id')
                                                        <span class="help-block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="department">Education Department <span class="text-danger">*</span></label>
                                                <input
                                                name="department"
                                                type="text"
                                                value="{{ old('department') ?? $employe->department}}"
                                                class="form-control @error('department') is-invalid @enderror" placeholder="Department">
                                                @error('department')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-12">
                                                    <div class="form-group">
                                                        <label for="family" class="mb-2">Family <span class="text-danger">*</span></label>
                                                        <input
                                                        name="family"
                                                        type="text"
                                                        value="{{ old('family') ?? $employe->family}}"
                                                        class="form-control @error('family') is-invalid @enderror" placeholder="Family">
                                                        @error('family')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="phonefamily" class="mb-2 ">Phone Family <span class="text-danger">*</span></label>
                                                        <input
                                                        name="phonefamily"
                                                        type="text"
                                                        value="{{ old('phonefamily') ?? $employe->phonefamily}}"
                                                        class="form-control @error('phonefamily') is-invalid @enderror" placeholder="Phone Family">
                                                        @error('phonefamily')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group @error('statusfamily') has-error @enderror">
                                                        <label class="form-label">Status family <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" style="width: 100%;" name="statusfamily">
                                                            <option value="" holder>Select status</option>
                                                            <option value="1" {{ (old('statusfamily') == '1' ? 'selected': '') }}
                                                            @if($employe->statusfamily == '1')
                                                            selected
                                                            @endif
                                                            >Suami</option>
                                                            <option value="2" {{ (old('statusfamily') == '2' ? 'selected': '') }}
                                                            @if($employe->statusfamily == '2')
                                                            selected
                                                            @endif
                                                            >Istri</option>
                                                            <option value="3" {{ (old('statusfamily') == '3' ? 'selected': '') }}
                                                            @if($employe->statusfamily == '3')
                                                            selected
                                                            @endif
                                                            >Saudara</option>
                                                        </select>
                                                        @error('statusfamily')
                                                        <span class="help-block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                                <textarea id="editor1"  rows="3" cols="80" class="form-control @error('address') is-invalid @enderror" name="address" >{{ old('address') ?? $employe->address }}</textarea>
                                                @error('address')
                                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <div class="box-body text-center ">
                                                            <div class="form-group">
                                                                <div class=" fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                                                        <img src="{{ ($employe->imageThumbUrl) ? $employe->imageThumbUrl : '/assets/images/no_image.png' }}"  alt="...">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                                                    <div>
                                                                        <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                                        <input type="file" class="@error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"></span>
                                                                        <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                    </div>
                                                                </div>
                                                                @error('image')
                                                                <div class="invalid-feedback" style="display: block">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <label class="form-label">Maps <span class="text-danger">*</span></label>
                                                                <textarea id="editor1"  rows="7" cols="6" class="form-control @error('maps') is-invalid @enderror" name="maps" >{{ old('maps') ?? $employe->maps }}</textarea>
                                                                @error('maps')
                                                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <button id="draft-btn" type="submit"  class="btn btn-sm btn-warning me-1">
                                                Draft
                                            </button>
                                            <button id="publish-btn" type="submit" class="btn btn-sm btn-primary">
                                                Update
                                            </button>


                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>

                <div class="col-12 col-lg-5 col-xl-4">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('{{ asset('') }}assets/images/gallery/full/10.jpg') center center;" data-overlay="5">
                            <h3 class="widget-user-username text-white">{{ $employe->name}}</h3>
                            <h6 class="widget-user-desc text-white">{{ $employe->user->displayname}}</h6>
                        </div>
                        <div class="widget-user-image">

                            <img class="rounded-circle" src="{{ ($employe->imageThumbUrl) ? $employe->imageThumbUrl : '/assets/images/avatar/avatar-4.png' }}" alt="{{ $employe->name }}">

                        </div>
                        <div class="box-footer">

                            <!-- /.row -->
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body box-profile">
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <p>People ID :<span class="text-gray ps-10">{{ $employe->nik}}</span> </p>
                                        <p>Birth Place :<span class="text-gray ps-10">{{ $employe->birth_place}}</span> </p>
                                        <p>Birth Date :<span class="text-gray ps-10"></span>{{ TanggalID("j M Y", $employe->birth_date) }}</span> </p>
                                        <p>Email :<span class="text-gray ps-10">{{ $employe->email}}</span> </p>
                                        <p>Phone :<span class="text-gray ps-10">{{ $employe->celuller_no}}</span></p>
                                        <p>Family :<span class="text-gray ps-10">{{ $employe->family}}</span></p>
                                        <p>Family Phone :<span class="text-gray ps-10">{{ $employe->phonefamily}}</span></p>
                                        <p>Relation :<span class="text-gray ps-10">
                                            @if ($employe->statusfamily == 1)
                                            Suami
                                            @elseif ($employe->statusfamily == 2)
                                            Istri
                                            @else
                                            Saudara
                                            @endif</span>
                                        </p>
                                        <p>Address :<span class="text-gray ps-10">{{ $employe->address}}</span></p>
                                        <p>Biografi :<span class="text-gray ps-10"><p>{{ $employe->user->bio }}</p></span></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="pb-15">
                                        <p class="mb-10">Social Profile</p>
                                        <div class="user-social-acount">
                                            <button class="btn btn-circle btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></button>
                                            <button class="btn btn-circle btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></button>
                                            <button class="btn btn-circle btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <div class="map-box">
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2805244.1745767146!2d-86.32675167439648!3d29.383165774894163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88c1766591562abf%3A0xf72e13d35bc74ed0!2sFlorida%2C+USA!5e0!3m2!1sen!2sin!4v1501665415329" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    {{-- <div class="box">
                        <div class="box-body">
                            <div class="flexbox align-items-baseline mb-20">
                                <h6 class="text-uppercase ls-2">Friends</h6>
                                <small>20</small>
                            </div>
                            <div class="gap-items-2 gap-y">
                                <a class="avatar" href="#"><img src="{{ asset('') }}assets/images/avatar/1.jpg" alt="..."></a>
                                <a class="avatar" href="#"><img src="{{ asset('') }}assets/images/avatar/3.jpg" alt="..."></a>
                                <a class="avatar" href="#"><img src="{{ asset('') }}assets/images/avatar/4.jpg" alt="..."></a>
                                <a class="avatar" href="#"><img src="{{ asset('') }}assets/images/avatar/5.jpg" alt="..."></a>
                                <a class="avatar" href="#"><img src="{{ asset('') }}assets/images/avatar/6.jpg" alt="..."></a>
                                <a class="avatar" href="#"><img src="{{ asset('') }}assets/images/avatar/7.jpg" alt="..."></a>
                                <a class="avatar" href="#"><img src="{{ asset('') }}assets/images/avatar/8.jpg" alt="..."></a>
                                <a class="avatar avatar-more" href="#">+15</a>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a class="text-uppercase d-blockls-1 text-fade" href="#">Invite People</a>
                        </div>
                    </div> --}}
                    {{-- <div class="box box-inverse" style="background-color: #3b5998">
                        <div class="box-header no-border">
                            <span class="fa fa-facebook fs-30"></span>
                            <div class="box-tools pull-right">
                                <h5 class="box-title">Facebook feed</h5>
                            </div>
                        </div>

                        <blockquote class="blockquote blockquote-inverse no-border m-0 py-15">
                            <p>Holisticly benchmark plug imperatives for multifunctional deliverables. Seamlessly incubate cross functional action.</p>
                            <div class="flexbox">
                                <time class="text-white" datetime="2017-11-21 20:00">21 November, 2021</time>
                                <span><i class="fa fa-heart"></i> 75</span>
                            </div>
                        </blockquote>
                    </div> --}}

                </div>

            </div>

        </section>


        @push('styles')
        <link rel="stylesheet" href="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
        @endpush

        @push('scripts')
        <script src="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
        <script src="{{ asset('') }}assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
        <script src="{{ asset('') }}assets/vendor_components/select2/dist/js/select2.full.js"></script>

        <script>

            //Save Draft
            $('#draft-btn').click(function(e) {
                e.preventDefault();
                $('#status').val(0);
                $('#post-form').submit();
            });
            //Save Publish
            $('#publish-btn').click(function(e) {
                e.preventDefault();
                $('#status').val(1);
                $('#post-form').submit();
            });

        </script>
        @endpush
        @endsection
