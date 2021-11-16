@php
    $info = app('user.helper')->getAppInfo();
@endphp
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                {{ $info['year'] }} © {{ $info['app_name'] }}. | V.{{ $info['version'] }}
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    {{ $info['information'] }}
                </div>
            </div>
        </div>
    </div>
</footer>