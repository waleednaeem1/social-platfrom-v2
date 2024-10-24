<!-- loader Start -->
<div id="loading">
    @include('partials._body_loader')
</div>
<!-- loader END -->
<!-- Wrapper Start -->
@include('partials._body_sidebar')
@include('partials._body_header')
<div class="main-content">
    <div class="position-relative">
       {{$pageheader ?? ''}}
    </div>
    <div id="content-page" class="content-page">
        {{ $slot }}
    </div>
@include('dashboards.modal')
</div>
{{-- Move all the footer content in _verticalnav blade --}}
<!-- Wrapper End-->
{{-- @include('partials._body_footer') --}} 
<!-- offcanvas start -->
@include('dashboards.rightSidebar')
<!-- Live Customizer start -->
@include('components.setting-offcanvas')
<!-- Live Customizer end -->

@include('components.shareoffcanvas')

<!-- Ajax Modal Html-->
@include('partials.modal-view')

@include('partials._scripts')
@include('dashboards._app_toast')
