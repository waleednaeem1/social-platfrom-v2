<x-app-layout>
   {{-- <div class="header-for-bg">
      <div class="background-header position-relative">
         <img src="{{asset('images/page-img/profile-bg7.jpg')}}" class="img-fluid w-100" alt="header-bg">
         <div class="title-on-header">
            <div class="data-block">
               <h2>Category</h2>
            </div>
         </div>
      </div>
   </div> --}}
   <div class="content-page" id="content-page">
      <div class="container">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
               <h4 class="card-title">Old Stock</h4>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-4">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Categories</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="form-check  d-block mb-2">
                        <input type="checkbox" class="form-check-input" id="customCheck1">
                        <label class="form-check-label" for="customCheck1">All Categories</label>
                     </div>
                     <div class="form-check d-block mb-2">
                        <input type="checkbox" class="form-check-input" id="customCheck2">
                        <label class="form-check-label" for="customCheck2">Macbook 2015</label>
                     </div>
                     <div class="form-check d-block mb-2">
                        <input type="checkbox" class="form-check-input" id="customCheck3">
                        <label class="form-check-label" for="customCheck3">Dell Inspiron</label>
                     </div>
                     <div class="form-check d-block mb-2">
                        <input type="checkbox" class="form-check-input" id="customCheck4">
                        <label class="form-check-label" for="customCheck4">HP Elitebook</label>
                     </div>
                     <div class="form-check d-block mb-2">
                        <input type="checkbox" class="form-check-input" id="customCheck5">
                        <label class="form-check-label" for="customCheck5">LED's</label>
                     </div>
                  </div>
               </div>
               {{-- <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Price Range</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div class="form-group me-3">
                           <label for="name01">From:</label>
                           <input type="text" class="form-control" id="name01" value="$  ">
                        </div>
                        <div class="form-group">
                           <label for="to">To:</label>
                           <input type="text" class="form-control" id="to" value="$  ">
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary w-100">Apply</button>
                  </div>
               </div>                     
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Reviews</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check d-flex align-items-center">
                           <input type="radio" class="form-check-input" name="bsradio" id="radio1" checked="">
                           <label for="radio1" class="form-check-label mb-0 ps-2"><b>Al Reviews</b></label>
                        </div>
                        <h6 class="text-primary">6870</h6>
                     </div>
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="form-check d-inline-block">
                           <input type="radio" class="form-check-input" name="bsradio" id="radio2" checked="">
                           <label for="radio2" class="form-check-label mb-0">
                              <span class=" text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                              </span>   
                           </label>
                        </div>
                        <h6 class="text-primary">1023</h6>
                     </div>                           
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="form-check d-inline-block">
                           <input type="radio" class="form-check-input" name="bsradio" id="radio3" checked="">
                           <label for="radio3" class="form-check-label mb-0">
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="fas fa-star-half-alt"></i>
                              </span>    
                           </label>
                        </div>
                        <h6 class="text-primary">1000</h6>
                     </div>                                                     
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="form-check d-inline-block">
                           <input type="radio" class="form-check-input" name="bsradio" id="radio4" checked="">
                           <label for="radio4" class="form-check-label  mb-0">
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="far fa-star"></i>
                              </span>           
                           </label>
                        </div>
                        <h6 class="text-primary">982</h6>
                     </div>
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="form-check d-inline-block">
                           <input type="radio" class="form-check-input" name="bsradio" id="radio5" checked="">
                           <label for="radio5" class="form-check-label mb-0">
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="far fa-star"></i>
                                 <i class="far fa-star"></i>
                              </span>     
                           </label>
                        </div>
                        <h6 class="text-primary">204</h6>
                     </div>
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="form-check d-inline-block">
                           <input type="radio" class="form-check-input" name="bsradio" id="radio6" checked="">
                           <label for="radio6" class="form-check-label mb-0">
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="far fa-star"></i>
                                 <i class="far fa-star"></i>
                                 <i class="far fa-star"></i>
                              </span> 
                           </label>
                        </div>
                        <h6 class="text-primary">50</h6>
                     </div>
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="form-check d-inline-block">
                           <input type="radio" class="form-check-input" name="bsradio" id="radio7" checked="">
                           <label for="radio7" class="orm-check-label mb-0">
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="far fa-star"></i>
                                 <i class="far fa-star"></i>
                                 <i class="far fa-star"></i>
                                 <i class="far fa-star"></i>
                              </span> 
                           </label>
                        </div>
                        <h6 class="text-primary">8</h6>
                     </div>
                  </div>
               </div> --}}
            </div>
            <div class="col-lg-8">
               <div class="row">
                  <div class="col-sm-6 col-md-6">
                     <div class="card card-block card-stretch card-height product">
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between pb-3">
                              <div class="d-flex align-items-center">
                                 <img class="img-fluid rounded-circle avatar-30" src="{{asset('images/user/01.jpg')}}" alt="">
                                 <div class="media-body ms-2">
                                    <p class="mb-0 line-height">Posted By</p>
                                    <h6><a href="#">Bearded Wonder</a></h6>
                                 </div>
                              </div>
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                              </span>    
                           </div> --}}
                           <div class="image-block position-relative">
                              <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                              {{-- <div class="offer">
                                 <div class="offer-title">20%</div>
                              </div> --}}
                              {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              <h6 class="price"><span class="regular-price text-dark pr-2"></span>$200.00</h6>
                           </div>
                           <div class="product-description mt-3">
                              <h6 class="mb-1">Macbook Pro</h6>
                              <span class="categry text-primary ps-3 mb-2 position-relative">Model: 2015</span>
                              <p class="mb-0">Hurry up and grab your laptop.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                     <div class="card card-block card-stretch card-height product">
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between pb-3">
                              <div class="d-flex align-items-center">
                                 <img class="img-fluid rounded-circle avatar-30" src="{{asset('images/user/01.jpg')}}" alt="">
                                 <div class="media-body ms-2">
                                    <p class="mb-0 line-height">Posted By</p>
                                    <h6><a href="#">Bearded Wonder</a></h6>
                                 </div>
                              </div>
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                              </span>    
                           </div> --}}
                           <div class="image-block position-relative">
                              <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                              {{-- <div class="offer">
                                 <div class="offer-title">20%</div>
                              </div> --}}
                              {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              <h6 class="price"><span class="regular-price text-dark pr-2"></span>$200.00</h6>
                           </div>
                           <div class="product-description mt-3">
                              <h6 class="mb-1">Macbook Pro</h6>
                              <span class="categry text-primary ps-3 mb-2 position-relative">Model: 2015</span>
                              <p class="mb-0">Hurry up and grab your laptop.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                     <div class="card card-block card-stretch card-height product">
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between pb-3">
                              <div class="d-flex align-items-center">
                                 <img class="img-fluid rounded-circle avatar-30" src="{{asset('images/user/01.jpg')}}" alt="">
                                 <div class="media-body ms-2">
                                    <p class="mb-0 line-height">Posted By</p>
                                    <h6><a href="#">Bearded Wonder</a></h6>
                                 </div>
                              </div>
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                              </span>    
                           </div> --}}
                           <div class="image-block position-relative">
                              <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                              {{-- <div class="offer">
                                 <div class="offer-title">20%</div>
                              </div> --}}
                              {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              <h6 class="price"><span class="regular-price text-dark pr-2"></span>$200.00</h6>
                           </div>
                           <div class="product-description mt-3">
                              <h6 class="mb-1">Macbook Pro</h6>
                              <span class="categry text-primary ps-3 mb-2 position-relative">Model: 2015</span>
                              <p class="mb-0">Hurry up and grab your laptop.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                     <div class="card card-block card-stretch card-height product">
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between pb-3">
                              <div class="d-flex align-items-center">
                                 <img class="img-fluid rounded-circle avatar-30" src="{{asset('images/user/01.jpg')}}" alt="">
                                 <div class="media-body ms-2">
                                    <p class="mb-0 line-height">Posted By</p>
                                    <h6><a href="#">Bearded Wonder</a></h6>
                                 </div>
                              </div>
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                              </span>    
                           </div> --}}
                           <div class="image-block position-relative">
                              <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                              {{-- <div class="offer">
                                 <div class="offer-title">20%</div>
                              </div> --}}
                              {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              <h6 class="price"><span class="regular-price text-dark pr-2"></span>$200.00</h6>
                           </div>
                           <div class="product-description mt-3">
                              <h6 class="mb-1">Macbook Pro</h6>
                              <span class="categry text-primary ps-3 mb-2 position-relative">Model: 2015</span>
                              <p class="mb-0">Hurry up and grab your laptop.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                     <div class="card card-block card-stretch card-height product">
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between pb-3">
                              <div class="d-flex align-items-center">
                                 <img class="img-fluid rounded-circle avatar-30" src="{{asset('images/user/01.jpg')}}" alt="">
                                 <div class="media-body ms-2">
                                    <p class="mb-0 line-height">Posted By</p>
                                    <h6><a href="#">Bearded Wonder</a></h6>
                                 </div>
                              </div>
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                              </span>    
                           </div> --}}
                           <div class="image-block position-relative">
                              <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                              {{-- <div class="offer">
                                 <div class="offer-title">20%</div>
                              </div> --}}
                              {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              <h6 class="price"><span class="regular-price text-dark pr-2"></span>$200.00</h6>
                           </div>
                           <div class="product-description mt-3">
                              <h6 class="mb-1">Macbook Pro</h6>
                              <span class="categry text-primary ps-3 mb-2 position-relative">Model: 2015</span>
                              <p class="mb-0">Hurry up and grab your laptop.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                     <div class="card card-block card-stretch card-height product">
                        <div class="card-body">
                           {{-- <div class="d-flex align-items-center justify-content-between pb-3">
                              <div class="d-flex align-items-center">
                                 <img class="img-fluid rounded-circle avatar-30" src="{{asset('images/user/01.jpg')}}" alt="">
                                 <div class="media-body ms-2">
                                    <p class="mb-0 line-height">Posted By</p>
                                    <h6><a href="#">Bearded Wonder</a></h6>
                                 </div>
                              </div>
                              <span class="text-warning d-block line-height">
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                                 <i class="material-symbols-outlined md-18">star</i>
                              </span>    
                           </div> --}}
                           <div class="image-block position-relative">
                              <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                              {{-- <div class="offer">
                                 <div class="offer-title">20%</div>
                              </div> --}}
                              {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              <h6 class="price"><span class="regular-price text-dark pr-2"></span>$200.00</h6>
                           </div>
                           <div class="product-description mt-3">
                              <h6 class="mb-1">Macbook Pro</h6>
                              <span class="categry text-primary ps-3 mb-2 position-relative">Model: 2015</span>
                              <p class="mb-0">Hurry up and grab your laptop.</p>
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