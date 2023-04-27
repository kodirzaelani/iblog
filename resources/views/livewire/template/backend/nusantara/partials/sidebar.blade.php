<div>
    <aside class="main-sidebar">
        <!-- sidebar-->
        <section class="sidebar position-relative">
            <div class="multinav">
                <div class="multinav-scroll" style="height: 100%;">
                    <!-- sidebar menu-->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li>
                            <a href="{{ route('root') }}" target="_blank" title="View Site">
                                <i class="fa fa-desktop" aria-hidden="true"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li class="header">Dashboard & Apps</li>
                        <li>
                            <a href="{{ route('backend.dashboard') }}" title="Dashboard">
                                <i class="fa fa-home"><span class="path1"></span><span class="path2"></span></i>
                                <span>Dashboard</span>
                            </a>
                        </li>


                        {{-- Post Menu  --}}
                        @if (auth()->user()->can('posts.index') ||
                                auth()->user()->can('posts.create') ||
                                auth()->user()->can('postcategory.index') ||
                                auth()->user()->can('postsubcategory.index') ||
                                auth()->user()->can('tags.index'))
                            <li
                                class="treeview {{ setActive('backend/allposts') . setActive('backend/postcategories') . setActive('backend/postsubcategories') . setActive('backend/tags') }} {{ setOpen('backend/allposts') . setOpen('backend/postcategories') . setOpen('backend/postsubcategories') . setOpen('backend/tags') }}">
                                <a href="#">
                                    <i class="fa fa-file-text" aria-hidden="true"></i>
                                    <span>Post</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @can('categoryposts.index')
                                        <li class="{{ setActive('backend/postcategories') }}"><a
                                                href="{{ route('backend.postscategories.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Post Categories</a></li>
                                    @endcan
                                    @can('postsubcategory.index')
                                        <li class="{{ setActive('backend/postsubcategories') }}"><a
                                                href="{{ route('backend.postssubcategories.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Post Sub Categories</a></li>
                                    @endcan
                                    @can('tags.index')
                                        <li class="{{ setActive('backend/tags') }}"><a
                                                href="{{ route('backend.tags.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Tags</a></li>
                                    @endcan
                                    <li
                                        class="treeview {{ setActive('backend/allposts') . setActive('backend/posts/create') }} {{ setOpen('backend/allposts') . setOpen('backend/posts/create') }}">
                                        <a href="#">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Post
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-right pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            @can('posts.create')
                                                <li class="{{ setActive('backend/posts/create') }}"><a
                                                        href="{{ route('backend.posts.create') }}"><i
                                                            class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>Add New</a></li>
                                            @endcan
                                            @can('posts.index')
                                                <li class="{{ setActive('backend/allposts') }}"><a
                                                        href="{{ route('backend.posts.index') }}"><i
                                                            class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>All Post</a></li>
                                            @endcan
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        {{-- End Post Menu --}}
                        {{-- Literacy Menu  --}}
                        @if (auth()->user()->can('literacies.index') ||
                                auth()->user()->can('literacies.create') ||
                                auth()->user()->can('literacycategories.index') ||
                                auth()->user()->can('literacysubcategories.index'))
                            <li
                                class="treeview {{ setActive('backend/literacies') . setActive('backend/literacycategories') . setActive('backend/literacysubcategories') }} {{ setOpen('backend/literacies') . setOpen('backend/literacycategories') . setOpen('backend/literacysubcategories') }}">
                                <a href="#">
                                    <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Literacy</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @can('literacycategories.index')
                                        <li class="{{ setActive('backend/allliteracycategories') }}"><a
                                                href="{{ route('backend.literacycategories.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Literacy Categories</a></li>
                                    @endcan
                                    @can('literacysubcategories.index')
                                        <li class="{{ setActive('backend/allliteracysubcategories') }}"><a
                                                href="{{ route('backend.literacysubcategories.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Literacy Sub Categories</a></li>
                                    @endcan
                                    <li
                                        class="treeview {{ setActive('backend/literacies') . setActive('backend/literacies/create') }} {{ setOpen('backend/literacies') . setOpen('backend/literacies/create') }}">
                                        <a href="#">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Literacy
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-right pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            @can('literacies.create')
                                                <li class="{{ setActive('backend/literacies/create') }}"><a
                                                        href="{{ route('backend.literacies.create') }}">
                                                        <i class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>Add New</a>
                                                </li>
                                            @endcan
                                            @can('literacies.index')
                                                <li class="{{ setActive('backend/allliteracies') }}"><a
                                                        href="{{ route('backend.literacies.index') }}"><i
                                                            class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>All Literacy</a></li>
                                            @endcan
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        {{-- End Literacy Menu --}}

                        {{-- Pages Menu  --}}
                        @if (auth()->user()->can('pages.index') ||
                                auth()->user()->can('pages.create') ||
                                auth()->user()->can('pagecategories.index'))
                            <li
                                class="treeview {{ setActive('backend/allgreetings') . setActive('backend/pagecategories') }} {{ setOpen('backend/allgreetings') . setOpen('backend/pagecategories') }}">
                                <a href="#">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    <span>Pages</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @can('pagecategories.index')
                                        <li class="{{ setActive('backend/pagecategories') }}"><a
                                                href="{{ route('backend.pagecategories.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Page Categories</a></li>
                                    @endcan
                                    <li
                                        class="treeview {{ setActive('backend/allgreetings') . setActive('backend/greetings/create') }} {{ setOpen('backend/allgreetings') . setOpen('backend/greetings/create') }}">
                                        <a href="#">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Pages
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-right pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            @can('pages.create')
                                                <li class="{{ setActive('backend/pages/create') }}"><a
                                                        href="{{ route('backend.pages.create') }}"><i
                                                            class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>Add New</a></li>
                                            @endcan
                                            @can('pages.index')
                                                <li class="{{ setActive('backend/allpages') }}"><a
                                                        href="{{ route('backend.pages.index') }}"><i
                                                            class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>All Pages</a></li>
                                            @endcan
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        {{-- End Pages Menu --}}

                        {{-- Sambutan Menu  --}}
                        @if (auth()->user()->can('greetings.index') ||
                                auth()->user()->can('greetings.create'))
                            <li
                                class="treeview {{ setActive('backend/allgreetings') }} {{ setOpen('backend/allgreetings') }}">
                                @can('greetings.index')
                                <li class="{{ setActive('backend/allgreetings') }}"><a
                                        href="{{ route('backend.greetings.index') }}"><i class="fa fa-vcard-o"
                                            aria-hidden="true"></i> Sambutan</a></li>
                            @endcan
                            </li>
                        @endif
                        {{-- End Sambutan Menu --}}

                        {{-- Galeries Menu --}}
                        @if (auth()->user()->can('downloadfiles.index') ||
                                auth()->user()->can('downloadcategories.index') ||
                                auth()->user()->can('sliders.index') ||
                                auth()->user()->can('sliders.create') ||
                                auth()->user()->can('albums.index') ||
                                auth()->user()->can('albums.create') ||
                                auth()->user()->can('photos.index') ||
                                auth()->user()->can('photos.create') ||
                                auth()->user()->can('advertisements.index') ||
                                auth()->user()->can('advertisements.create') ||
                                auth()->user()->can('video.index') ||
                                auth()->user()->can('video.create'))
                            <li
                                class="treeview {{ setActive('backend/download') . setActive('backend/dldcategory') . setActive('backend/sliders') . setActive('backend/albums') . setActive('backend/photos') . setActive('backend/advertisements') . setActive('backend/video') }} {{ setOpen('backend/download') . setOpen('backend/dldcategory') . setOpen('backend/sliders') . setOpen('backend/sliders') . setOpen('backend/photos') . setOpen('backend/advertisements') . setOpen('backend/video') }}">
                                <a href="#">
                                    <i class="fa fa-file-image-o" aria-hidden="true"></i><span
                                        class="path1"></span><span class="path2"></span></i>
                                    <span>Galeries</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- Download -->
                                    <li
                                        class="treeview {{ setActive('backend/download') . setActive('backend/dldcategory') }} {{ setOpen('backend/download') . setOpen('backend/dldcategory') }}">
                                        <a href="#">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i> Download
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-right pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            @can('downloadcategories.index')
                                                <li class="{{ setActive('backend/download') }}"><a
                                                        href="{{ route('backend.download.categoryindex') }}"><i
                                                            class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>Category</a></li>
                                            @endcan
                                            @can('downloadfiles.index')
                                                <li class="{{ setActive('backend/download') }}"><a
                                                        href="{{ route('backend.download.downloadindex') }}"><i
                                                            class="icon-Commit"><span class="path1"></span><span
                                                                class="path2"></span></i>List Download</a></li>
                                            @endcan
                                        </ul>
                                    </li>
                                    <!-- End Download -->
                                    <li
                                        class="treeview {{ setActive('backend/sliders') . setActive('backend/sliders/create') }} {{ setOpen('backend/sliders') . setOpen('backend/sliders/create') }}">
                                        @can('sliders.index')
                                        <li class="{{ setActive('backend/allsliders') }}"><a
                                                href="{{ route('backend.sliders.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Hero
                                                Sliders</a></li>
                                    @endcan
                            </li>

                            <li
                                class="treeview {{ setActive('backend/fotos') . setActive('backend/fotos/create') }} {{ setOpen('backend/fotos') . setOpen('backend/fotos/create') }}">
                                <a href="#">
                                    <i class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Photos
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @can('albums.index')
                                        <li class="{{ setActive('backend/allalbums') }}"><a
                                                href="{{ route('backend.albums.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Albums</a>
                                        </li>
                                    @endcan
                                    @can('photos.index')
                                        <li class="{{ setActive('backend/allfotos') }}"><a
                                                href="{{ route('backend.fotos.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Photos</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                            <li
                                class="treeview {{ setActive('backend/video') . setActive('backend/videocategories') }} {{ setOpen('backend/video') . setOpen('backend/videocategories') }}">
                                <a href="#">
                                    <i class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>Video
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @can('videocategories.index')
                                        <li class="{{ setActive('backend/videocategories') }}"><a
                                                href="{{ route('backend.videoscategories.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Video Category</a></li>
                                    @endcan
                                    @can('video.index')
                                        <li class="{{ setActive('backend/allvideo') }}"><a
                                                href="{{ route('backend.video.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Video
                                                All</a></li>
                                    @endcan
                                </ul>
                            </li>

                    </ul>
                    </li>
                    @endif
                    {{-- End Galeries Menu --}}

                    {{-- Agendas Menu  --}}
                    @if (auth()->user()->can('agendas.index') ||
                            auth()->user()->can('agendas.create') ||
                            auth()->user()->can('pengajian.index') ||
                            auth()->user()->can('pengajian.create') ||
                            auth()->user()->can('pengajiancategories.index') ||
                            auth()->user()->can('petugasjumat.index') ||
                            auth()->user()->can('petugasjumat.create'))
                        <li
                            class="treeview {{ setActive('backend/allagendas') . setActive('backend/pengajian') . setActive('backend/pengajiancategories') . setActive('backend/petugasjumat') }} {{ setOpen('backend/allagendas') . setOpen('backend/pengajian') . setOpen('backend/pengajiancategories') . setOpen('backend/petugasjumat') }}">
                            <a href="#">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <span>Agenda</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li
                                    class="treeview {{ setActive('backend/pengajian') . setActive('backend/pengajiancategories') }} {{ setOpen('backend/pengajian') . setOpen('backend/pengajiancategories') }}">

                                    <a href="#">
                                        <i class="icon-File"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        <span>Pengajian</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        @can('pengajiancategories.index')
                                            <li class="{{ setActive('backend/pengajiancategories') }}"><a
                                                    href="{{ route('backend.pengajiancategories.index') }}"><i
                                                        class="icon-Commit"><span class="path1"></span><span
                                                            class="path2"></span></i>Pengajian Categories</a></li>
                                        @endcan
                                        <li
                                            class="treeview {{ setActive('backend/pengajian') . setActive('backend/pengajian/create') }} {{ setOpen('backend/pengajian') . setOpen('backend/pengajian/create') }}">
                                            @can('pengajian.create')
                                            <li class="{{ setActive('backend/pengajian/create') }}"><a
                                                    href="{{ route('backend.pengajian.create') }}"><i
                                                        class="icon-Commit"><span class="path1"></span><span
                                                            class="path2"></span></i>Add New</a></li>
                                        @endcan
                                        @can('pengajian.index')
                                            <li class="{{ setActive('backend/pengajian') }}"><a
                                                    href="{{ route('backend.pengajian.index') }}"><i
                                                        class="icon-Commit"><span class="path1"></span><span
                                                            class="path2"></span></i>All Pengajian</a></li>
                                        @endcan
                                </li>

                            </ul>
                        </li>
                        @if (auth()->user()->can('petugasjumat.index') ||
                                auth()->user()->can('petugasjumat.create'))
                            <li
                                class="treeview {{ setActive('backend/petugasjumat') }} {{ setOpen('backend/petugasjumat') }}">
                                <a href="#">
                                    <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Petugas Jumat</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li
                                        class="treeview {{ setActive('backend/petugasjumat') . setActive('backend/petugasjumat/create') }} {{ setOpen('backend/petugasjumat') . setOpen('backend/petugasjumat/create') }}">
                                        @can('petugasjumat.create')
                                        <li class="{{ setActive('backend/petugasjumat/create') }}"><a
                                                href="{{ route('backend.petugasjumat.create') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Add New</a></li>
                                    @endcan
                                    @can('petugasjumat.index')
                                        <li class="{{ setActive('backend/petugasjumat') }}"><a
                                                href="{{ route('backend.petugasjumat.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>All Petugas Jumat</a></li>
                                    @endcan
                            </li>

                            </ul>
                            </li>
                        @endif
                        @can('agendas.create')
                            <li class="{{ setActive('backend/agendas/create') }}"><a
                                    href="{{ route('backend.agendas.create') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span class="path2"></span></i>Add New</a></li>
                        @endcan
                        @can('agendas.index')
                            <li class="{{ setActive('backend/allagendas') }}"><a
                                    href="{{ route('backend.agendas.index') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span class="path2"></span></i>All Agenda</a></li>
                        @endcan
                        </ul>
                        </li>
                    @endif
                    {{-- End Agendas Menu --}}



                    @if (auth()->user()->can('religi.index') ||
                            auth()->user()->can('organizations.index') ||
                            auth()->user()->can('structuroganization.create') ||
                            auth()->user()->can('peraturans.index') ||
                            auth()->user()->can('periode.index') ||
                            auth()->user()->can('employes.index') ||
                            auth()->user()->can('management.index'))
                        <li class="header">Apps BPIC </li>
                        {{-- Apps BPIC Menu  --}}

                        @if (auth()->user()->can('religi.index') ||
                                auth()->user()->can('organizations.create') ||
                                auth()->user()->can('structuroganization.create') ||
                                auth()->user()->can('peraturans.index') ||
                                auth()->user()->can('periode.index') ||
                                auth()->user()->can('employes.index') ||
                                auth()->user()->can('management.index'))
                            <li
                                class="treeview {{ setActive('backend/peraturan') . setActive('backend/periode') . setActive('backend/allorganizations') . setActive('backend/structuroganization') . setActive('backend/employes') . setActive('backend/management') }}
                        {{ setOpen('backend/peraturan') . setOpen('backend/periode') . setOpen('backend/allorganizations') . setOpen('backend/structuroganization') . setOpen('backend/employes') . setOpen('backend/management') }}">
                                <a href="#">
                                    <i class="fa fa-file-image-o" aria-hidden="true"></i><span
                                        class="path1"></span><span class="path2"></span></i>
                                    <span>BPIC</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    {{-- peraturan Menu  --}}
                                    @can('peraturans.index')
                                        <li
                                            class="{{ setActive('backend/peraturan') }} {{ setOpen('backend/peraturan') }}">
                                            <a href="{{ route('backend.peraturan.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span
                                                        class="path2"></span></i>Peraturan</a>
                                        </li>
                                    @endcan
                                    {{-- peraturan Menu  --}}
                                    {{-- periode Menu  --}}
                                    @can('periode.index')
                                        <li class="{{ setActive('backend/periode') }} {{ setOpen('backend/periode') }}">
                                            <a href="{{ route('backend.periode.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Periode</a>
                                        </li>
                                    @endcan
                                    {{-- periode Menu  --}}
                                    {{-- Organisasi Menu  --}}
                                    @can('organizations.index')
                                        <li
                                            class="{{ setActive('backend/allorganizations') }} {{ setOpen('backend/allorganizations') }}">
                                            <a href="{{ route('backend.organizations.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Unit Organisasi</a>
                                        </li>
                                    @endcan
                                    {{-- Organisasi Menu  --}}
                                    {{-- Struktur Organisasi Menu  --}}
                                    @can('structuroganization.index')
                                        <li
                                            class="{{ setActive('backend/structuroganization') }} {{ setOpen('backend/structuroganization') }}">
                                            <a href="{{ route('backend.structuroganization.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Jabatan</a>
                                        </li>
                                    @endcan
                                    {{-- Struktur Organisasi Menu  --}}
                                    {{-- Officer Menu  --}}
                                    @can('employes.index')
                                        <li
                                            class="{{ setActive('backend/employes') }} {{ setOpen('backend/employes') }}">
                                            <a href="{{ route('backend.employes.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Pegawai</a>
                                        </li>
                                    @endcan
                                    {{-- Officer Menu  --}}
                                    {{-- Management Menu  --}}
                                    @can('management.index')
                                        <li
                                            class="{{ setActive('backend/management') }} {{ setOpen('backend/management') }}">
                                            <a href="{{ route('backend.management.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Management</a>
                                        </li>
                                    @endcan
                                    {{-- Management Menu  --}}
                                </ul>
                            </li>
                        @endif
                        {{-- Apps BPIC Menu  --}}
                    @endif

                    @if (auth()->user()->can('settings.index') ||
                            auth()->user()->can('widgets.index') ||
                            auth()->user()->can('menu.index') ||
                            auth()->user()->can('roles.index') ||
                            auth()->user()->can('permissions.index') ||
                            auth()->user()->can('users.index'))
                        <li class="header">LOGIN && CONFIGURATION</li>
                        {{-- Setting Menu  --}}
                        @if (auth()->user()->can('settings.index') ||
                                auth()->user()->can('widgets.index') ||
                                auth()->user()->can('menu.index'))
                            <li
                                class="treeview {{ setActive('backend/allwidget') . setActive('backend/jenjangpendidikan') . setActive('backend/menu') . setActive('backend/settings') }} {{ setOpen('backend/allwidget') . setOpen('backend/jenjangpendidikan') . setOpen('backend/menu') . setOpen('backend/settings') }}">
                                <a href="#">
                                    <i class="icon-Settings-2"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Settings</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>

                                <ul class="treeview-menu">
                                    @can('settings.index')
                                        <li class="{{ setActive('backend/settings') }}"><a
                                                href="{{ route('backend.settings') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>General</a>
                                        </li>
                                    @endcan
                                    {{-- @can('webmoduls.index')
                            <li class="{{ setActive('backend/webmoduls') }}"><a href="{{ route('backend.settings.webmoduls') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Web Modul</a></li>
                            @endcan --}}
                                    @can('widgets.index')
                                        <li class="{{ setActive('backend/allwidget') }}"><a
                                                href="{{ route('backend.widgets.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Widget</a>
                                        </li>
                                    @endcan
                                    @can('menu.index')
                                        <li class="{{ setActive('backend/categorymenu') }}"><a
                                                href="{{ route('backend.menu.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Menu</a>
                                        </li>
                                    @endcan
                                    @if (auth()->user()->can('religi.index'))
                                        <li
                                            class="{{ setActive('backend/religi') }} {{ setOpen('backend/religi') }}"">
                                            <a href="{{ route('backend.religi.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Agama</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->can('jenjangpendidikan.index'))
                                        <li
                                            class="{{ setActive('backend/jenjangpendidikan') }} {{ setOpen('backend/jenjangpendidikan') }}">
                                            <a href="{{ route('backend.jenjangpendidikan.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Jenjang Pendidikan</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        {{-- Setting Menu  --}}
                        {{-- Authentication Menu  --}}
                        @if (auth()->user()->can('roles.index') ||
                                auth()->user()->can('permissions.index') ||
                                auth()->user()->can('users.index'))
                            <li
                                class="treeview {{ setActive('backend/roles/index') . setActive('backend/permissions/index') . setActive('backend/users/index') }} {{ setOpen('backend/roles/index') . setOpen('backend/permissions/index') . setOpen('backend/users/index') }}">
                                <a href="#">
                                    <i class="icon-Chat-locked"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Authentication</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @can('permissions.index')
                                        <li class="{{ setActive('backend/permissions/index') }}"><a
                                                href="{{ route('backend.permissions.index') }}"><i
                                                    class="icon-Commit"><span class="path1"></span><span
                                                        class="path2"></span></i>Permissions</a></li>
                                    @endcan
                                    @can('roles.index')
                                        <li class="{{ setActive('backend/roles/index') }}"><a
                                                href="{{ route('backend.roles.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Roles</a>
                                        </li>
                                    @endcan
                                    @can('users.index')
                                        <li class="{{ setActive('backend/users/index') }}"><a
                                                href="{{ route('backend.users.index') }}"><i class="icon-Commit"><span
                                                        class="path1"></span><span class="path2"></span></i>Users</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif
                        {{-- Authentication Menu  --}}
                    @endif

                    </ul>
                </div>
            </div>
        </section>
        <div class="sidebar-footer">
            <a href="#" class="link" data-bs-toggle="tooltip" title="Email"><span
                    class="icon-Mail"></span></a>
            <a href="{{ route('logout') }}" class="link" data-bs-toggle="tooltip" title="{{ __('Logout') }}"
                onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><span
                    class="icon-Lock-overturning"><span class="path1"></span><span class="path2"></span></span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>
</div>
