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
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                            <h4 class="card-title">Doctors</h4>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-6 col-md-6">
                           <div class="card card-block card-stretch card-height product">
                              <div class="card-body">
                                 <div class="image-block position-relative">
                                    <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                                    {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                                    <a href="#"><h6 class="price"><span class="regular-price text-dark pr-2"></span>Get Appointment</h6></a>
                                 </div>
                                 <div class="product-description mt-3">
                                    <h6 class="mb-1">Dr. Waleed Naeem</h6>
                                    <span class="categry text-primary ps-3 mb-2 position-relative">Physiotherapist</span>
                                    <p class="mb-0">Success in containing the virus comes slowing activity.</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="card card-block card-stretch card-height product">
                              <div class="card-body">
                                 <div class="image-block position-relative">
                                    <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img">
                                    <a href="#"><h6 class="price"><span class="regular-price text-dark pr-2"></span>Get Appointment</h6></a>
                                 </div>
                                 <div class="product-description mt-3">
                                    <h6 class="mb-1">Dr. Charles Stauffer</h6>
                                    <span class="categry text-primary ps-3 mb-2 position-relative">Ophthalmologist</span>
                                    <p class="mb-0">Success in containing the virus comes slowing activity.</p>
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