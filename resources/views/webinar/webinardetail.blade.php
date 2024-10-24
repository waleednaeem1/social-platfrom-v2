<x-app-layout>
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-block card-stretch card-height blog blog-detail">
               <div class="card-body">
                  <h2>{{$data['webinar']->name}}</h2>
                  <p>{!! $data['webinar']->short_detail !!}</p>
                  <div class="image-block">
                     <img src="https://web.dvmcentral.com/up_data/webiners/images/{{$data['webinar']->image}}" class="img-fluid rounded w-100" alt="webinar-img">  
                  </div>
                  <div class="blog-description mt-3">
                     <p>{!! $data['webinar']->full_detail !!}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>