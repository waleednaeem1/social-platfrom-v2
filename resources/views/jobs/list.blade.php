<x-app-layout> 
   <div class="container">
      <div class="row">
         <div class="col-x-8 m-0 py-0 rem-div-1">
            <div class="header-for-bg">
               <div class="background-header position-relative">
                  <img src="images/page-img/jobs-banner.png" class="img-fluid w-100 rounded" alt="profile-bg">
               </div>
            </div>
            <div class="content-page" id="content-page">
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-12 m-0 py-0 mx-auto">
                           <div class="row">
                              <div class="col-lg-4">
                                 <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                       <div class="header-title">
                                          <h4 class="card-title">Job Categories</h4>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                       <div class="form-check  mb-2 d-block">
                                          <input type="checkbox" class="form-check-input" id="customCheck7">
                                          <label class="form-check-label" for="customCheck7">All Categories</label>
                                       </div>
                                       @foreach ($data['job_category'] as $category)
                                          <div class="form-check  mb-2 d-block">
                                             <input type="checkbox" class="form-check-input" id="customCheck7">
                                             <label class="form-check-label" for="customCheck{{$category->id}}">{{$category->name}}</label>
                                          </div>
                                       @endforeach
                                    </div>
                                 </div>
                                 <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                       <div class="header-title">
                                          <h4 class="card-title">Job Type</h4>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                       @foreach ($data['job_type'] as $type)
                                          <div class="form-check  mb-2 d-block">
                                             <input type="checkbox" class="form-check-input" id="customCheck7">
                                             <label class="form-check-label" for="customCheck{{$type->id}}">{{$type->name}}</label>
                                          </div>
                                       @endforeach
                                    </div>
                                 </div>
                                 <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                       <div class="header-title">
                                          <h4 class="card-title">Price Range</h4>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                       <div class="d-flex align-items-center">
                                          <div class="form-group me-3">
                                             <label for="name1">From:</label>
                                             <input type="text" class="form-control" id="name1" value="$  ">
                                          </div>
                                          <div class="form-group">
                                             <label for="to">To:</label>
                                             <input type="text" class="form-control" id="to" value="$  ">
                                          </div>
                                       </div>
                                       <button type="submit" class="btn btn-primary w-100">Apply</button>
                                    </div>
                                 </div>                     
                              </div>
                              <div class="col-lg-8">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="card card-block card-stretch card-height product">
                                          <div class="card-body">
                                             @foreach ($data['job_detail'] as $job)
                                                <div class="row align-items-top mb-3">
                                                   <div class="col-lg-6">
                                                      <div class="image-block position-relative">
                                                         {{-- <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img"> --}}
                                                         <img src="{{asset('images/page-img/jobs-banner.png')}}" class="img-fluid w-100 rounded" style="height:160px" alt="product-img">
                                                         {{-- <div class="offer">
                                                            <div class="offer-title">20%</div>
                                                         </div> --}}
                                                         {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                                                         <h6 class="price"><span>Salary: </span>${{$job->salary}}</h6>
                                                      </div>
                                                   </div>
                                                   <div class="col-lg-6">
                                                      <div class="product-description ps-2 circle-category mt-2 mt-md-0">
                                                         <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                                            <div class="d-flex align-items-center">
                                                               {{-- <img class="img-fluid rounded-circle avatar-30" src="{{asset('{{}}images/user/01.jpg')}}" alt=""> --}}
                                                               @if (isset($job['vendor']->logo) && $job['vendor']->logo !=='')
                                                                  {{-- <img class="img-fluid rounded-circle avatar-30" src="https://web.dvmcentral.com/up_data/vendors/logo/{{$job['vendor']->logo}}" alt=""> --}}
                                                                  <img class="img-fluid rounded-circle avatar-30" src="{{ asset('images/icon/logo.png')}}" alt="">
                                                               @endif
                                                               <div class=" ms-2">
                                                                  <p class="mb-0 line-height">Posted By</p>
                                                                  @if(isset($job['vendor']->name))
                                                                     {{-- <h6><a href="https://www.dvmcentral.com/vendors/{{$job['vendor']->slug}}" target="_blank">{{$job['vendor']->name}}</a></h6> --}}
                                                                     <h6><a href="https://devsinc.com/" target="_blank">Devsinc</a></h6>
                                                                  @else
                                                                     <h6><a href="#">Waleed</a></h6>
                                                                  @endif
                                                               </div>
                                                            </div>
                                                            <div class="d-block line-height">
                                                               <span class="text-warning">
                                                                  <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Apply</button>
                                                                  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                     <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                           <div class="modal-header">
                                                                              <h5 class="modal-title">Modal title</h5>
                                                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                              </button>
                                                                           </div>
                                                                           <div class="modal-body">
                                                                              <p>Modal body text goes here.</p>
                                                                           </div>
                                                                           <div class="modal-footer">
                                                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                              <button type="button" class="btn btn-primary">Save changes</button>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                               </span>                                             
                                                            </div>
                                                         </div>
                                                         <h6 class="mb-1">{{$job->title}}</h6>
                                                         <span class="categry text-primary ps-3 mb-2 position-relative">{{$job['job_working_time']->name}}</span>
                                                         <h6 class="mb-0"><span>Required Experience: </span>{{$job->required_experience_num.' '.$job->required_experience_duration}}s</h6>
                                                      </div>
                                                   </div>
                                                </div>
                                             @endforeach
                                             {{-- <div class="row align-items-top mb-3">
                                                <div class="col-lg-6">
                                                   <div class="image-block position-relative">
                                                      <img src="{{asset('images/store/02.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                                                      <div class="offer">
                                                         <div class="offer-title">20%</div>
                                                      </div>
                                                      <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6>
                                                   </div>
                                                </div>
                                                <div class="col-lg-6">
                                                   <div class="product-description ps-2 circle-category mt-2 mt-md-0">
                                                      <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                                         <div class="d-flex align-items-center">
                                                            <img class="img-fluid rounded-circle avatar-30" src="{{asset('images/user/02.jpg')}}" alt="">
                                                            <div class=" ms-2">
                                                               <p class="mb-0 line-height">Posted By</p>
                                                               <h6><a href="#">Bearded Wonder</a></h6>
                                                            </div>
                                                         </div>
                                                         <div class="d-block line-height">
                                                            <span class="text-warning">
                                                            <i class="material-symbols-outlined md-18">star</i>
                                                            <i class="material-symbols-outlined md-18">star</i>
                                                            <i class="material-symbols-outlined md-18">star</i>
                                                            <i class="material-symbols-outlined md-18">star</i>
                                                            <i class="material-symbols-outlined md-18">star</i>
                                                            </span>                                             
                                                         </div>
                                                      </div>
                                                      <h6 class="mb-1">Flaming Skull Team Logo</h6>
                                                      <span class="categry text-primary ps-3 mb-2 position-relative">Logo and badges</span>
                                                      <p class="mb-0">Success in containing the virus comes slowing activity.</p>
                                                   </div>
                                                </div>
                                             </div> --}}
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
   
</x-app-layout>