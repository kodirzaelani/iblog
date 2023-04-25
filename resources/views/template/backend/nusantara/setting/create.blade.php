@extends('template.backend.nusantara.layouts.appb')
@section('title', $title)

@section('content')
<!-- Content Header (Foto header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">@yield('title')</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update General setting</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>
<!-- Main content -->
<section class="content">
    <form id="post-form" enctype="multipart/form-data" action="{{ route('backend.settings.store') }}" method="post">
        <div class="row">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Update  Setting</h4>
                            <div class="box-controls pull-right">
                                <input type="text" name="status_site_update" id="status_site_update" hidden>
                                <input type="text" name="fresh_site" id="fresh_site" hidden>
                                <button id="publish-btn" type="submit"class="btn btn-sm btn-primary">
                                    Publish
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab2" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">General</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#profile7" role="tab"><span class="hidden-sm-up"><i class="ion-person"></i></span> <span class="hidden-xs-down">Media Social</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#messages7" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Contac Info</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#logo7" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Logo</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#maps7" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Maps</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#meta9" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Meta Descriptions</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="home7" role="tabpanel">
                                    <div class="p-15">
                                        <div class="box">
                                            <div class="box-header">
                                                <h4 class="box-title"> General
                                                </h4>

                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <h5>Site Title <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="webname" class="form-control @error('webname') is-invalid @enderror" value="{{ old('webname')}}" placeholder="Web Title" required>
                                                    </div>
                                                    @error('webname')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Tagline <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline') }}" placeholder="Moto situs bisa diletakkan di sini" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Moto situs bisa diletakkan di sini</code></small></div>
                                                    @error('tagline')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Site URL <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="url" name="siteurl" class="form-control @error('siteurl') is-invalid @enderror" value="{{ old('siteurl')}}" placeholder="Alamat website" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Alamat website </code> | contoh: http://digitalnusantara.id</small></div>
                                                    @error('siteurl')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Home Site URL <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="url" name="homeurl" class="form-control @error('homeurl') is-invalid @enderror" value="{{ old('homeurl')}}" placeholder="Alamat Beranda website" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Alamat Beranda website, atau dapat diisi sesuai Site URL</code></small></div>
                                                    @error('homeurl')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Description <span class="text-danger">*</span></label>
                                                    <textarea id="editor1"  rows="10" cols="80" class="form-control @error('description') is-invalid @enderror" name="description" >{{ old('description') }}</textarea>
                                                    <div class="form-control-feedback"><small><code>Deskripsi Singkat </code></small></div>
                                                    @error('description')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile7" role="tabpanel">
                                    <div class="p-15">
                                        <div class="box">
                                            <div class="box-header">
                                                <h4 class="box-title">Social Media
                                                </h4>

                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <h5>Facebook <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook')  }}" placeholder="Alamat Facebook" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Alamat Facebook</code></small></div>
                                                    @error('facebook')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Instagram <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram')}}" placeholder="Alamat Instagram" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Alamat Instagram</code></small></div>
                                                    @error('instagram')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Youtube Chanel <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ old('youtube')}}" placeholder="Alamat Youtube Chanel" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Alamat Youtube Chanel</code></small></div>
                                                    @error('youtube')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Twitter <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ old('twitter') }}" placeholder="Alamat Twitter" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Alamat Twitter</code></small></div>
                                                    @error('twitter')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Linkedln <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="linkedln" class="form-control @error('linkedln') is-invalid @enderror" value="{{ old('linkedln')}}" placeholder="Alamat Linkedln" required>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Alamat Linkedln</code></small></div>
                                                    @error('linkedln')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="messages7" role="tabpanel">
                                    <div class="p-15">
                                        <div class="box">
                                            <div class="box-header">
                                                <h4 class="box-title">Contact Info
                                                </h4>
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <h5>Whatsapp </h5>
                                                    <div class="controls">
                                                        <input type="text" name="watshapp" class="form-control @error('watshapp') is-invalid @enderror" value="{{ old('watshapp')}}" placeholder="Nomor Whatsapp" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>Nomor Whatsapp</code></small></div>
                                                    @error('watshapp')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Telegram </h5>
                                                    <div class="controls">
                                                        <input type="text" name="telegram" class="form-control @error('telegram') is-invalid @enderror" value="{{ old('telegram')}}" placeholder="username telegram" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code>username telegram (@....)</code></small></div>
                                                    @error('telegram')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Phone </h5>
                                                    <div class="controls">
                                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone')}}" placeholder=" phone" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code> phone (@....)</code></small></div>
                                                    @error('phone')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Email </h5>
                                                    <div class="controls">
                                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email')}}" placeholder=" email" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code> Email </code></small></div>
                                                    @error('email')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Address </h5>
                                                    <div class="controls">
                                                        <textarea rows="5" name="address" class="form-control @error('address') is-invalid @enderror"  placeholder="address" >{{ old('address') }} </textarea>
                                                    </div>
                                                    <div class="form-control-feedback"><small><code> Alamat jalan  </code></small></div>
                                                    @error('address')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>City </h5>
                                                    <div class="controls">
                                                        <input type="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city')}}" placeholder=" city" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code> Kota  </code></small></div>
                                                    @error('city')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Province </h5>
                                                    <div class="controls">
                                                        <input type="state" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state')}}" placeholder=" Province" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code> Provinsi  </code></small></div>
                                                    @error('state')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Country </h5>
                                                    <div class="controls">
                                                        <input type="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country')}}" placeholder=" country" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code> Negara  </code></small></div>
                                                    @error('country')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Postal Code </h5>
                                                    <div class="controls">
                                                        <input type="postalcode" name="postalcode" class="form-control @error('postalcode') is-invalid @enderror" value="{{ old('postalcode')}}" placeholder=" postalcode" >
                                                    </div>
                                                    <div class="form-control-feedback"><small><code> Kode Pos  </code></small></div>
                                                    @error('postalcode')
                                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="logo7" role="tabpanel">
                                    <div class="p-15">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="box h-300">
                                                    <div class="box-header">
                                                        <h4 class="box-title">
                                                            Logo
                                                        </h4>
                                                    </div>
                                                    <div class="box-body text-center ">
                                                        <label class="form-label">Size : 600 pixel x 400 pixel</label>
                                                        <div class="form-group">
                                                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                                                    <img src="{{ asset('') }}assets/images/no_image.png"  alt="...">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                                                <div>
                                                                    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                                    <input type="file" class="@error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}"></span>
                                                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                </div>
                                                            </div>
                                                            @error('logo')
                                                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="box h-300">
                                                    <div class="box-header">
                                                        <h4 class="box-title">
                                                            Favicon
                                                        </h4>
                                                    </div>
                                                    <div class="box-body text-center ">
                                                        <label class="form-label">Size : 500kb</label>
                                                        {{-- <div ><small><a href="https://favicon.io/favicon-converter/" target="_blank">Generator Favicon</a></small></div><p></p> --}}
                                                        <div class="form-group">
                                                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                                                    <img src="{{ asset('') }}assets/images/no_image.png"  alt="...">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                                                <div>
                                                                    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                                    <input type="file" class="@error('favicon') is-invalid @enderror" name="favicon" value="{{ old('favicon') }}"></span>
                                                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                </div>
                                                            </div>
                                                            @error('favicon')
                                                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="box h-300">
                                                    <div class="box-header">
                                                        <h4 class="box-title">
                                                            Logo Menu
                                                        </h4>
                                                    </div>
                                                    <div class="box-body text-center ">
                                                        <label class="form-label">Size : 140 x 21 pixel | 500kb</label>
                                                        <div class="form-group">
                                                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                                                    <img src="{{ asset('') }}assets/images/no_image.png"  alt="...">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                                                <div>
                                                                    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                                    <input type="file" class="@error('logo_menu') is-invalid @enderror" name="logo_menu" value="{{ old('logo_menu') }}"></span>
                                                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                </div>
                                                            </div>
                                                            @error('logo_menu')
                                                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="box h-300">
                                                    <div class="box-header">
                                                        <h4 class="box-title">
                                                            Background Header
                                                        </h4>
                                                    </div>
                                                    <div class="box-body text-center ">
                                                        <label class="form-label">Size : 1980 pixel x 1280 pixel | 1Mb</label>
                                                        <div class="form-group">
                                                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                                                    <img src="{{ asset('') }}assets/images/no_image.png"  alt="...">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                                                <div>
                                                                    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                                    <input type="file"  name="bg_header" value="{{ old('bg_header') }}" class="@error('bg_header') is-invalid @enderror"></span>
                                                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                </div>
                                                            </div>
                                                            @error('bg_header')
                                                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="box h-300">
                                                    <div class="box-header">
                                                        <h4 class="box-title">
                                                            Background Statistic
                                                        </h4>
                                                    </div>
                                                    <div class="box-body text-center ">
                                                        <label class="form-label">Size : Size : 1980 pixel x 1280 pixel | 1Mb</label>
                                                        <div class="form-group">
                                                            <div class=" fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new img-thumbnail" style="width: 200px;">
                                                                    <img src="{{ asset('') }}assets/images/no_image.png"  alt="...">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px;"></div>
                                                                <div>
                                                                    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                                    <input type="file" class="@error('bg_statistic') is-invalid @enderror" name="bg_statistic" value="{{ old('bg_statistic') }}"></span>
                                                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                </div>
                                                            </div>
                                                            @error('bg_statistic')
                                                            <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="maps7" role="tabpanel">
                                    <div class="p-15">
                                        <div class="row">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h4 class="box-title">Maps
                                                    </h4>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <h5>Maps </h5>
                                                        <div class="controls">
                                                            <textarea rows="5" name="maps" class="form-control @error('maps') is-invalid @enderror"  placeholder="maps" >{{ old('maps')}} </textarea>
                                                        </div>
                                                        <div class="form-control-feedback"><small> Exp:
                                                            <code>
                                                                https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6519218789713!2d117.08926731409771!3d-0.5232837354157259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f93048b4a03%3A0x77d556abf72c93d0!2sPENERBIT%20BUKU%20MEDIATAMA%20CABANG%20SAMARINDA!5e0!3m2!1sen!2sid!4v1643782605913!5m2!1sen!2sid
                                                            </code>
                                                        </small></div>
                                                        @error('maps')
                                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="meta9" role="tabpanel">
                                    <div class="p-15">
                                        <div class="row">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h4 class="box-title">
                                                        Meta Descriptions & Meta Keywords
                                                    </h4>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <h5>Meta Descriptions </h5>
                                                        <div class="controls">
                                                            <textarea rows="2" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror"  placeholder="meta_description" >{{ old('meta_description')}} </textarea>
                                                        </div>
                                                        <div class="form-control-feedback">
                                                            <small> Exp:
                                                                <code>
                                                                    Digital Nusantara, Digital Nusantara Borneo, Borneo, Digital, Nusantara, Kaltim
                                                                </code>
                                                            </small>
                                                        </div>
                                                        @error('meta_description')
                                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <h5>Meta Keywords </h5>
                                                        <div class="controls">
                                                            <textarea rows="2" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror"  placeholder="meta_keywords" >{{ old('meta_keywords') }} </textarea>
                                                        </div>
                                                        <div class="form-control-feedback">
                                                            <small> Exp:
                                                                <code>
                                                                    Digital Nusantara, Digital Nusantara Borneo, Borneo, Digital, Nusantara, Kaltim
                                                                </code>
                                                            </small>
                                                        </div>
                                                        @error('meta_keywords')
                                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </form>
</section>

@push('styles')
<!-- Jasny Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
@endpush

@push('scripts')
<script src="{{ asset('') }}assets/vendor_plugins/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
<script src="{{ asset('') }}assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{ asset('') }}assets/vendor_components/select2/dist/js/select2.full.js"></script>
<script src="{{ asset('') }}assets/vendor_components/ckeditor/ckeditor.js"></script>
<script src="{{ asset('') }}assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
{{-- <script src="{{ asset('') }}assets/backend/js/pages/editor.js"></script> --}}
<script>
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
</script>
<script>
    CKEDITOR.replace('editor1', options);
    //Initialize Select2 Elements
    $('.select2').select2();

    //Save Draft
    $('#draft-btn').click(function(e) {
        e.preventDefault();
        $('#status_site_update').val(0);
        $('#post-form').submit();
    });
    //Save Publish
    $('#publish-btn').click(function(e) {
        e.preventDefault();
        $('#status_site_update').val(1);
        $('#fresh_site').val(1);
        $('#post-form').submit();
    });

</script>
@endpush
@endsection
