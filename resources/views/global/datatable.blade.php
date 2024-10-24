@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
<x-app-layout>
<div class="container">
   <div class="row">
      <div class="col-sm-12">
         <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
            <div class="inner-page-title">
               <div class="header-title">
                  <h4 class="text-white">{{ $pageTitle ?? 'List'}}</h4>
                  <p class="text-white">lorem </p>
               </div>
            </div>
         </div>
      </div> 
      <div class="col-sm-12">        
         <div class="card"> 
                <div class="card-body">
                <div id="table" class="">
                   <span class="d-flex justify-content-end table-add folat-end mb-3 me-3">
                    {!! $headerAction ?? '' !!}
                  </span>
                    {{ $dataTable->table(['class' => 'table table-bordered table-responsive-md table-striped text-center'],true) }}
               </div>
               </div>
         </div>
      </div>
   </div>
</div>
</x-app-layout>
