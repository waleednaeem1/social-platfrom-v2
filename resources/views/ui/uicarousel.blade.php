<x-app-layout>
<div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                     <div class="inner-page-title">
                        <h3 class="text-white">Carousel Page</h3>
                        <p class="text-white">lorem ipsum</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-lg-6">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Slides only</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Here’s a carousel with slides only. Note the presence of the <code>.d-block</code> and <code>.img-fluid</code> on carousel images to prevent browser default image alignment.</p>
                           <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                              <div class="carousel-inner">
                                 <div class="carousel-item active">
                                    <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                                 </div>
                                 <div class="carousel-item">
                                    <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                                 </div>
                                 <div class="carousel-item">
                                    <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                                 </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-lg-6">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Slides With Controls</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Here’s a carousel with slides only. Note the presence of the <code>.d-block</code> and <code>.img-fluid</code> on carousel images to prevent browser default image alignment.</p>
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                           <div class="carousel-inner">
                              <div class="carousel-item active">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                              <div class="carousel-item">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                              <div class="carousel-item">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                           </div>
                           <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                           </button>
                           <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-lg-6">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Slides With Indicators</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Here’s a carousel with slides only. Note the presence of the <code>.d-block</code> and <code>.img-fluid</code> on carousel images to prevent browser default image alignment.</p>
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                           <div class="carousel-indicators">
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                           </div>
                           <div class="carousel-inner">
                              <div class="carousel-item active">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                              <div class="carousel-item">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                              <div class="carousel-item">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                           </div>
                           <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                           </button>
                           <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-lg-6">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Slides With Captions</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Here’s a carousel with slides only. Note the presence of the <code>.d-block</code> and <code>.img-fluid</code> on carousel images to prevent browser default image alignment.</p>
                        <div class="bd-example">
                           <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                              <div class="carousel-indicators">
                                 <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                 <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                 <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                              </div>
                              <div class="carousel-inner">
                                 <div class="carousel-item active">
                                    <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                                    <div class="carousel-caption d-none d-md-block">
                                    <h5>First slide label</h5>
                                    <p>Some representative placeholder content for the first slide.</p>
                                    </div>
                                 </div>
                                 <div class="carousel-item">
                                    <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                                    <div class="carousel-caption d-none d-md-block">
                                    <h5>Second slide label</h5>
                                    <p>Some representative placeholder content for the second slide.</p>
                                    </div>
                                 </div>
                                 <div class="carousel-item">
                                    <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                                    <div class="carousel-caption d-none d-md-block">
                                    <h5>Third slide label</h5>
                                    <p>Some representative placeholder content for the third slide.</p>
                                    </div>
                                 </div>
                              </div>
                              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                 <span class="visually-hidden">Previous</span>
                              </button>
                              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                 <span class="visually-hidden">Next</span>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-lg-6">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Slides With Crossfade</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Here’s a carousel with slides only. Note the presence of the <code>.d-block</code> and <code>.img-fluid</code> on carousel images to prevent browser default image alignment.</p>
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                           <div class="carousel-inner">
                              <div class="carousel-item active">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                              <div class="carousel-item">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                              <div class="carousel-item">
                                 <img src="{{asset('images/small/img-1.jpg')}}" class="d-block w-100">
                              </div>
                           </div>
                           <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                           </button>
                           <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
</x-app-layout>