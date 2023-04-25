<div>
    <footer class="main-footer">
        <div class="pull-right d-none d-sm-inline-block">
            <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">FAQ</a>
                </li>
            </ul>
        </div>
        &copy;
        @php
        echo date('Y');
        @endphp
        | <span class="text-white mx-5 ">
            <a href="{{ route('root') }}">
                @if ($global_option <> '0')
                {{ !empty($global_option->webname) ? $global_option->webname:'Silahkan Sesuaikan ' }}
                @else
                Silahkan Sesuaikan di menu setting
                @endif
            </a>
        </span> | Dibuat dengan <i class="fa fa-heart mx-5" aria-hidden="true"></i> untuk <i class="flag-icon flag-icon-id mx-5" title="Indonesia" id="id"></i>
    </footer>
</div>
