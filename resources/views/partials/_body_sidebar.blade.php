@if(auth()->user())
<aside class="sidebar sidebar-default sidebar-base navs-rounded-all sidebar-soft" id="first-tour" data-toggle="main-sidebar" data-sidebar="responsive">
  {{-- <div class="sidebar-body pt-0 data-scrollbar"> --}}
    <div class="sidebar-body pt-0 pe-0" style="height: 100%">
        <div class="sidebar-list custom-sidebar-scroll">
          @include('partials._body_verticalnav')
        </div>
    </div>
    <div class="sidebar-footer"></div>
    
    <a class="left-sidebar-toggle bg-primary text-white mt-3" data-toggle="sidebar" data-active="true" href="javascript:void(0);">
      <div class="icon material-symbols-outlined iq-burger-menu pt-2">
          menu
      </div>
    </a>
    
</aside>
@endif