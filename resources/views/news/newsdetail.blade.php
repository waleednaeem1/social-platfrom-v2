{{-- @php
   echo "<pre>";
   print_r($data);
   die;
@endphp --}}

<x-app-layout>

        <div class="container">
               <div class="row">
                  <div class="col-lg-8">
                     <div class="card card-block card-stretch card-height blog blog-detail">
                        <div class="card-body">
                           <div class="image-block">
                              {{-- <img src="{{asset('images/blog/01.jpg')}}" class="img-fluid rounded w-100" alt="blog-img">   --}}
                              <img src="https://web.dvmcentral.com/up_data/news/{{$data['news']->top_image_banner}}" class="img-fluid rounded w-100" alt="blog-img">  
                           </div>
                           <div class="blog-description mt-3">
                              {{-- <h5 class="mb-3 pb-3 border-bottom">There are many variations of passages.</h5>
                              <div class="blog-meta d-flex align-items-center mb-3 position-right-side flex-wrap">
                                 <div class="date me-4 d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">calendar_month</i>2 Weeks ago</div>
                                 <div class="like me-4 d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">
                                    thumb_up_alt
                                    </i>20 like
                                 </div>
                                 <div class="comments me-4 d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">
                                    mode_comment
                                    </i>82 comments
                                 </div>
                                 <div class="share d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">
                                    share
                                    </i>share
                                 </div>
                              </div> --}}
                              <p>{!! $data['news']->full_content !!}</p>
                              {{-- <a href="#" tabindex="-1">Read More <i class="ri-arrow-right-s-line"></i></a> --}}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="card card-block card-stretch card-height blog-post">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Recent News</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <ul class="list-inline p-0 mb-0 mt-2">
                              @foreach ($data['recentNews'] as $recentNews)
                                 <li class="mb-3">
                                    <a href="{{route('news.newsdetail',  ['slug' => $recentNews->slug])}}">
                                       <div class="row align-items-top pb-3 border-bottom">
                                          <div class="col-md-5">
                                             <div class="image-block">
                                                <img src="https://web.dvmcentral.com/up_data/news/{{$recentNews->top_image_banner}}" class="img-fluid rounded w-100" alt="blog-img">
                                             </div>
                                          </div>
                                          <div class="col-md-7">
                                             <div class="blog-description mt-1 mt-md-0">
                                                <div class="date mb-1">
                                                   <div>{{$recentNews->publish_date}}</div>
                                                   </div>
                                                <h6>{{$recentNews->name}}</h6>
                                             </div>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                              @endforeach


                              {{-- <li class="mb-3">
                                 <div class="row align-items-top pb-3 border-bottom">
                                    <div class="col-md-5">
                                       <div class="image-block">
                                          <img src="{{asset('images/blog/03.jpg')}}" class="img-fluid rounded w-100" alt="blog-img">
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="blog-description mt-1 mt-md-0">
                                          <div class="date mb-1"><a href="#" tabindex="-1">4 Weeks ago</a></div>
                                          <h6>All the Lorem Ipsum generators</h6>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="mb-3">
                                 <div class="row align-items-top pb-3 border-bottom">
                                    <div class="col-md-5">
                                       <div class="image-block">
                                          <img src="{{asset('images/blog/04.jpg')}}" class="img-fluid rounded w-100" alt="blog-img">
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="blog-description mt-1 mt-md-0">
                                          <div class="date mb-1"><a href="#" tabindex="-1">3 Weeks ago</a></div>
                                          <h6>All the Lorem Ipsum generators</h6>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="mb-3">
                                 <div class="row align-items-top pb-3 border-bottom">
                                    <div class="col-md-5">
                                       <div class="image-block">
                                          <img src="{{asset('images/blog/05.jpg')}}" class="img-fluid rounded w-100" alt="blog-img">
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="blog-description mt-1 mt-md-0">
                                          <div class="date mb-1"><a href="#" tabindex="-1">2 Weeks ago</a></div>
                                          <h6>All the Lorem Ipsum generators</h6>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="mb-3">
                                 <div class="row align-items-top pb-3 border-bottom">
                                    <div class="col-md-5">
                                       <div class="image-block">
                                          <img src="{{asset('images/blog/06.jpg')}}" class="img-fluid rounded w-100" alt="blog-img">
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="blog-description mt-1 mt-md-0">
                                          <div class="date mb-1"><a href="#" tabindex="-1">1 Week ago</a></div>
                                          <h6>All the Lorem Ipsum generators</h6>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="mb-3">
                                 <div class="row align-items-top pb-3 border-bottom">
                                    <div class="col-md-5">
                                       <div class="image-block">
                                          <img src="{{asset('images/blog/07.jpg')}}" class="img-fluid rounded w-100" alt="blog-img">
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="blog-description mt-1 mt-md-0">
                                          <div class="date mb-1"><a href="#" tabindex="-1">3 days ago</a></div>
                                          <h6>All the Lorem Ipsum generators</h6>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li>
                                 <div class="row align-items-top">
                                    <div class="col-md-5">
                                       <div class="image-block">
                                          <img src="{{asset('images/blog/08.jpg')}}" class="img-fluid rounded w-100" alt="blog-img">
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="blog-description mt-1 mt-md-0">
                                          <div class="date mb-1"><a href="#" tabindex="-1">2 Days ago</a></div>
                                          <h6>All the Lorem Ipsum generators</h6>
                                       </div>
                                    </div>
                                 </div>
                              </li> --}}
                           </ul>
                        </div>
                     </div>
                  </div>
                  {{-- <div class="col-lg-12">
                     <div class="card card-block card-stretch card-height blog user-comment">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">User Comment</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="card card-block card-stretch card-height blog">
                                    <div class="card-body">
                                       <div class="d-flex align-items-center">
                                          <div class="user-image mb-3">
                                             <img class="avatar-80 rounded" src="{{asset('images/user/01.jpg')}}" alt="#" data-original-title="" title="">
                                          </div>
                                          <div class="ms-3">
                                             <h5>Kaya Scodelario</h5>
                                             <p>Web Developer</p>
                                          </div>
                                       </div>
                                       <div class="blog-description">
                                          <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
                                          <div class="d-flex align-items-center justify-content-between mb-2 position-right-side"> 
                                             <a href="#" class="comments d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">
                                             mode_comment
                                             </i>82 comments</a>
                                             <span class="text-warning d-block line-height">
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star_half</i>
                                             </span>  
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-12 ps-0 ps-md-5">
                                 <div class="card card-block card-stretch card-height blog">
                                    <div class="card-body">
                                       <div class="d-flex align-items-center">
                                          <div class="user-image mb-3">
                                             <img class="avatar-80 rounded" src="{{asset('images/user/02.jpg')}}" alt="#" data-original-title="" title="">
                                          </div>
                                          <div class="ms-3">
                                             <h5>Tom Cruise</h5>
                                             <p>Web Designer</p>
                                          </div>
                                       </div>
                                       <div class="blog-description">
                                          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum Many desktop publishing packages and web page editors now use Lorem Ipsum.</p>
                                          <div class="d-flex align-items-center justify-content-between mb-2 position-right-side"> 
                                             <a href="#" class="comments d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">
                                             mode_comment
                                             </i>82 comments</a>
                                             <span class="text-warning d-block line-height">
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star_half</i>
                                             </span>  
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="card card-block card-stretch card-height blog">
                                    <div class="card-body">
                                       <div class="d-flex align-items-center">
                                          <div class="user-image mb-3">
                                             <img class="avatar-80 rounded" src="{{asset('images/user/03.jpg')}}" alt="#" data-original-title="" title="">
                                          </div>
                                          <div class="ms-3">
                                             <h5>Walter Hucko</h5>
                                             <p>Web Designer</p>
                                          </div>
                                       </div>
                                       <div class="blog-description">
                                          <p>TThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                          <div class="d-flex align-items-center justify-content-between mb-2 position-right-side"> 
                                             <a href="#" class="comments d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">
                                             mode_comment
                                             </i>82 comments</a>
                                             <span class="text-warning d-block line-height">
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star_half</i>
                                             </span>  
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-12 ps-0 ps-md-5">
                                 <div class="card card-block card-stretch card-height blog">
                                    <div class="card-body">
                                       <div class="d-flex align-items-center">
                                          <div class="user-image mb-3">
                                             <img class="avatar-80 rounded" src="{{asset('images/user/04.jpg')}}" alt="#" data-original-title="" title="">
                                          </div>
                                          <div class="ms-3">
                                             <h5>Mark Walton</h5>
                                             <p>Web Manager</p>
                                          </div>
                                       </div>
                                       <div class="blog-description">
                                          <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.randomised words which don't look even slightly believable variations of passages.</p>
                                          <div class="d-flex align-items-center justify-content-between mb-2 position-right-side"> 
                                             <a href="#" class="comments d-flex align-items-center"><i class="material-symbols-outlined pe-2 md-18 text-primary">
                                             mode_comment
                                             </i>82 comments</a>
                                             <span class="text-warning d-block line-height">
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star</i>
                                             <i class="material-symbols-outlined md-18">star_half</i>
                                             </span>  
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="card card-block card-stretch card-height blog mb-0">
                                    <div class="card-header d-flex justify-content-between">
                                       <div class="header-title">
                                          <h4 class="card-title">Your Comment</h4>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                       <form>
                                          <div class="form-group">
                                             <label for="email1" class="form-label">Email address:</label>
                                             <input type="email" class="form-control" id="email1">
                                          </div>
                                          <div class="form-group">
                                             <label for="pwd" class="form-label">Password:</label>
                                             <input type="password" class="form-control" id="pwd">
                                          </div>
                                          <div class="form-group">
                                             <label for="exampleFormControlTextarea1" class="form-label">Comment</label>
                                             <textarea class="form-control" id="exampleFormControlTextarea1" rows="4"></textarea>
                                          </div>
                                          <div class="form-check mb-3 w-100">
                                             <input class="form-check-input" type="checkbox" id="remember-box" value="option1">
                                             <label class="form-check-label" for="remember-box">Remember me</label>
                                          </div>
                                          <button type="submit" class="btn btn-primary me-2">Submit</button>
                                          <button type="submit" class="btn bg-soft-danger">Cancel</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div> --}}
               </div>
            </div>
    
</x-app-layout>