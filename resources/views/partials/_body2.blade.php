<div id="loading">
    @include('partials._body_loader')
</div>
<!-- Wrapper Start -->
<div class="wrapper">
    @include('partials._body_header')
    @include('dashboards.rightSidebar')
    {{$pageheader ?? ''}}
    <div id="content-page" class="content-page">
      {{ $slot }}
    </div>
</div>
<!-- Wrapper End-->
@include('dashboards.modal')
@include('partials._body_footer')

@include('partials._scripts')
@include('components.shareoffcanvas')
