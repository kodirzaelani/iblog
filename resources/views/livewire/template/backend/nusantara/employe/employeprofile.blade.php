<div>
    <!-- Main content -->
    <section class="content">
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Congratulations!</strong>
            <br> {{ session('success') }}
        </div>
        @endif
        <div class="row">
            <div class="col-12 col-lg-7 col-xl-8">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li><a href="#usertimeline" data-bs-toggle="tab">Timeline</a></li>
                        <li><a href="#activity" data-bs-toggle="tab">Activity</a></li>
                        <li><a class="active" href="#settings" data-bs-toggle="tab">Setting</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane" id="usertimeline">
                            <div class="publisher publisher-multi b-1 mb-30">
                                <h2>Comming Soon</h2>
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="activity">
                            <div class="publisher publisher-multi b-1 mb-30">
                                <h2 >Comming Soon</h2>
                            </div>
                            <!-- /.post -->
                        </div>
                        <!-- /.tab-pane -->

                        <div class="active tab-pane" id="settings">

                            <div class="box no-shadow">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input wire:model="name" type="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter a name" readonly>
                                    @error('name')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="prevEmail">Email <span class="text-danger">*</span></label>
                                    <input wire:model="prevEmail" type="prevEmail" value="{{ old('prevEmail') }}" class="form-control @error('prevEmail') is-invalid @enderror" placeholder="Enter a prevEmail" readonly>
                                    @error('prevEmail')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="prevCeluller">Phone/Whatapps <span class="text-danger">*</span></label>
                                    <input wire:model="prevCeluller" type="prevCeluller" value="{{ old('prevCeluller') }}" class="form-control @error('prevCeluller') is-invalid @enderror" placeholder="Enter a prevCeluller" readonly>
                                    @error('prevCeluller')
                                    <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                    @enderror
                                </div>
                                <form class="form-horizontal" wire:submit.prevent="update" >
                                    <div class="form-group">
                                        <label for="displayname">Display Name </label>
                                        <input wire:model="displayname" type="displayname" value="{{ old('displayname') }}" class="form-control @error('displayname') is-invalid @enderror" placeholder="Enter a displayname" >
                                        @error('displayname')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="ms-auto">
                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                        </div>
                                    </div>
                                </form>
                                <form class="form-horizontal" wire:submit.prevent="updatebio" >

                                    <div class="form-group">
                                        <label for="bio">Bio </label>
                                        <textarea class="form-control @error('bio') is-invalid @enderror" id="inputExperience" wire:model='bio' placeholder="Bio"></textarea>
                                        @error('bio')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="ms-auto">
                                            <button type="submit" class="btn btn-success btn-sm">Update Bio</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="box no-shadow">
                                <form class="form-horizontal" wire:submit.prevent="changeemail" >
                                    <div class="form-group">
                                        <label for="email">New Email <span class="text-danger">*</span></label>
                                        <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="New Email" />
                                        <span class="form-text text-muted">Using <code>input type="email" Active</code></span>
                                        @error('email')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                    @if (!empty($email))
                                    <div class="form-group">
                                        <label for="current_password_for_email">Current Password <span class="text-danger">*</span></label>
                                        <input wire:model="current_password_for_email" type="password" class="form-control @error('current_password_for_email') is-invalid @enderror" placeholder="New Email" />
                                        <span class="form-text text-muted">Your Password <code>in system</code></span>
                                        @error('current_password_for_email')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="ms-auto">
                                            <button type="submit" class="btn btn-success btn-sm">Change Email</button>
                                        </div>
                                    </div>
                                    @endif
                                </form>

                                <form class="form-horizontal" wire:submit.prevent="changephone" >
                                    <div class="form-group">
                                        <label for="celuller_no">New Phone/Whatapps <span class="text-danger">*</span></label>
                                        <input wire:model="celuller_no" type="text" class="form-control @error('celuller_no') is-invalid @enderror" placeholder="New Phone/Whatapps" />
                                        <span class="form-text text-muted">Using <code>input type="0812xxxxxxx" Phone/Whatapps Active</code></span>
                                        @error('celuller_no')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                    @if (!empty($celuller_no))
                                    <div class="form-group">
                                        <label for="current_password_for_phone">Current Password <span class="text-danger">*</span></label>
                                        <input wire:model="current_password_for_phone" type="password" class="form-control @error('current_password_for_phone') is-invalid @enderror" placeholder="Current Password" />
                                        <span class="form-text text-muted">Your Password <code>in system</code></span>
                                        @error('current_password_for_phone')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="ms-auto">
                                            <button type="submit" class="btn btn-success btn-sm">Change Phone/Whatapps</button>
                                        </div>
                                    </div>
                                    @endif
                                </form>
                                <form class="form-horizontal" wire:submit.prevent="changepassword" >
                                    <div class="form-group">
                                        <label for="password">New Password <span class="text-danger">*</span></label>
                                        <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password" />
                                        <span class="form-text text-muted"> <code>New Password</code></span>
                                        @error('password')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>

                                    @if (!empty($password))
                                    <div class="form-group">
                                        <label for="password_confirmation">Password Confirmation <span class="text-danger">*</span></label>
                                        <input wire:model="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password Confirmation" />
                                        <span class="form-text text-muted">New Password <code>Confirmation</code></span>
                                        @error('password_confirmation')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="current_password_for_password">Current Password <span class="text-danger">*</span></label>
                                        <input wire:model="current_password_for_password" type="password" class="form-control @error('current_password_for_password') is-invalid @enderror" placeholder="Current Password" />
                                        <span class="form-text text-muted">Your Password <code>in system</code></span>
                                        @error('current_password_for_password')
                                        <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="ms-auto">
                                            <button type="submit" class="btn btn-success btn-sm">Change Password</button>
                                        </div>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->

            <div class="col-12 col-lg-5 col-xl-4">
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('{{ asset('') }}assets/images/gallery/full/10.jpg') center center;" data-overlay="5">
                        <h3 class="widget-user-username text-white">{{ $name }}</h3>
                        <h6 class="widget-user-desc text-white">{{ $prevDisplayname }}</h6>
                    </div>
                    <div class="widget-user-image">
                        @if ($prevImage)
                        <img class="rounded-circle" src="{{ asset('') }}uploads/images/users/images_thumb/{{ $prevImage }}" alt="{{ $prevName }}">
                        @else
                        <img class="rounded-circle" src="{{ asset('') }}assets/images/avatar/avatar-1.png" alt="User">
                        @endif
                    </div>
                    <div class="box-footer">
                        <form class="form-horizontal" wire:submit.prevent="changeimage" >
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Change Image</label>
                                <input wire:model="image" type="file"  class="form-control @error('image') is-invalid @enderror" id="formFile">
                            </div>
                            <div class="mb-3">
                                @error('image')
                                <div class="form-control-feedback"><small> <code>{{ $message }}</code> </small></div>
                                @enderror
                                @if ($image)
                                <label for="formFile" class="form-label">Image Preview:</label>
                                <img src="{{ $image->temporaryUrl() }}" style="max-width: 40%">
                                @endif
                            </div>
                            @if (!empty($image))
                            <div class="form-group row">
                                <div class="ms-auto col-sm-10">
                                    <button type="submit" class="btn btn-success btn-sm">Change Image</button>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body box-profile">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <p><i class="fa fa-user" aria-hidden="true"></i><span class="text-gray ps-10">{{ $prevUsername }}</span> </p>
                                    <p><i class="fa fa-envelope" aria-hidden="true"></i><span class="text-gray ps-10">{{ $prevEmail }}</span> </p>
                                    <p><i class="fa fa-phone" aria-hidden="true"></i><span class="text-gray ps-10">{{ $prevCeluller}}</span></p>
                                    <p>Bio :<span class="text-gray ps-10"><p>{{ $prevBio }}</p></span></p>
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

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div><!-- /.livewire -->
