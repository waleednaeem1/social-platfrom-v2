<x-app-layout>

   {{-- @php
      echo "<pre>";
         print_r($data);
         die;
   @endphp --}}

   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-block card-stretch card-height blog blog-detail">
               <div class="card-body">
                  <h2>{{$data['speaker'][0]->first_name}}</h2>
                  <p>{{$data['speaker'][0]->job_title}}</p>
                  <p>{{$data['speaker'][0]->institute}}</p>
                  {{-- <p>{!! $data['speaker'][0]->about !!}</p> --}}
                  <div class="image-block">
                     <img src="https://web.dvmcentral.com/up_data/speakers/{{$data['speaker'][0]->profile}}" class="img-fluid rounded" alt="speaker-img">  
                  </div>
                  <div class="blog-description mt-3">
                     <p>{!! $data['speaker'][0]->about !!}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>