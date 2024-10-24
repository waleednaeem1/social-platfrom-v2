{{-- @php
echo "<pre>";
   print_r($data['posts']);
   die;
@endphp --}}


<x-app-layout>
   <div class="container">
      <div class="row">
         <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
            @foreach ($data['posts'] as $post)
               <div class="col-lg-12">
                  <div class="card card-block card-stretch card-height blog-list">
                     <div class="card-body">
                        <div class="row align-items-center">
                           <div class="col-md-6">
                              <div class="image-block">
                                 {{-- <img src="{{asset('images/blog/01.jpg')}}" class="img-fluid rounded w-100" alt="blog-img" loading="lazy"> --}}
                                 <img src="https://web.dvmcentral.com/up_data/blog/{{$post->image_thumbnail}}" class="img-fluid rounded w-100" alt="blog-img" loading="lazy">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="blog-description p-2">
                                 <div class="blog-meta d-flex align-items-center justify-content-between mb-2">
                                    <div class="date">
                                       <a href="#" tabindex="-1">{{ \Carbon\Carbon::parse($post->publish_date)->isoFormat('MMM D, YYYY')}}</a>
                                    </div>
                                 </div>
                                 <h5 class="mb-2">{{$post->name}}</h5>
                                 <p>{{$post->short_content}}</p>
                                 <a href="{{route('blog.blogdetail',  ['slug' => $post->slug])}}" class="d-flex align-items-center" tabindex="-1">Read More <i class="material-symbols-outlined md-14">arrow_forward_ios</i></a>
                                 {{-- <a href="#" class="d-flex align-items-center" tabindex="-1">Read More <i class="material-symbols-outlined md-14">arrow_forward_ios</i></a> --}}
                                 {{-- <div class="group-smile mt-4 d-flex flex-wrap align-items-center justify-content-between position-right-side">
                                    <div class="iq-media-group">
                                       <a href="#" class="iq-media">
                                       <img class="img-fluid rounded-circle" src="{{asset('images/icon/01.png')}}" alt="" loading="lazy">
                                       </a>
                                       <a href="#" class="iq-media">
                                       <img class="img-fluid rounded-circle" src="{{asset('images/icon/02.png')}}" alt="" loading="lazy">
                                       </a>
                                       <a href="#" class="iq-media">
                                       <img class="img-fluid rounded-circle" src="{{asset('images/icon/03.png')}}" alt="" loading="lazy">
                                       </a>
                                       <a href="#" class="iq-media">
                                       <img class="img-fluid rounded-circle" src="{{asset('images/icon/07.png')}}" alt="" loading="lazy">
                                       </a>
                                    </div>
                                    <div class="comment d-flex align-items-center"><i class="material-symbols-outlined me-2 md-18">chat_bubble_outline</i>7 comments</div>
                                 </div> --}}
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </div>
</x-app-layout>