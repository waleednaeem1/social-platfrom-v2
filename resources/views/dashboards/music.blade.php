<x-app-layout>
<div class="header-for-bg">
            <div class="background-header position-relative">
               <img src="images/page-img/profile-bg8.jpg" class="img-fluid w-100 rounded rounded" alt="header-bg">
               <div class="title-on-header">
                  <div class="data-block">
                     <h2>Music</h2>
                  </div>
               </div>
            </div>
         </div>
<div id="content-page" class="content-page">
      <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Play Lists</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="music-lists m-0 p-0">
                            <li class="d-flex mb-4 align-items-center">
                                <div class="user-img img-fluid"><img src="{{asset('images/page-img/l1.jpg')}}" alt="story-img" class="rounded-circle avatar-40"></div>
                                <div class="d-flex justify-content-between w-100">
                                    <div class="ms-3">
                                        <h6>Ember</h6>
                                    </div>
                                    <div class="music-time">3:00</div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 align-items-center">
                                <div class="user-img img-fluid"><img src="{{asset('images/page-img/l2.jpg')}}" alt="story-img" class="rounded-circle avatar-40"></div>
                                <div class="d-flex justify-content-between w-100">
                                    <div class="ms-3">
                                    <h6>Light Out(Bonus Track)</h6>
                                    </div>
                                    <div class="music-time">5:00</div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 align-items-center">
                                <div class="user-img img-fluid"><img src="{{asset('images/page-img/l3.jpg')}}" alt="story-img" class="rounded-circle avatar-40"></div>
                                 <div class="d-flex justify-content-between w-100">
                                    <div class="ms-3">
                                    <h6>Darkness Overture</h6>
                                    </div>
                                    <div class="music-time">2:30</div>
                                 </div>
                            </li>
                            <li class="d-flex mb-4 align-items-center">
                                <div class="user-img img-fluid"><img src="{{asset('images/page-img/l4.jpg')}}" alt="story-img" class="rounded-circle avatar-40"></div>
                                 <div class="d-flex justify-content-between w-100">
                                    <div class="ms-3">
                                    <h6>Dritin</h6>
                                    </div>
                                    <div class="music-time">4:20</div>
                                 </div>
                            </li>
                            <li class="d-flex mb-4 align-items-center">
                                <div class="user-img img-fluid"><img src="{{asset('images/page-img/l5.jpg')}}" alt="story-img" class="rounded-circle avatar-40"></div>
                                <div class="d-flex justify-content-between w-100">
                                    <div class=" ms-3">
                                    <h6>Bones</h6>
                                    </div>
                                    <div class="music-time">1:45</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="user-img img-fluid"><img src="{{asset('images/page-img/l6.jpg')}}" alt="story-img" class="rounded-circle avatar-40"></div>
                                <div class="d-flex justify-content-between w-100">
                                    <div class="ms-3">
                                    <h6>Hozier</h6>
                                    </div>
                                    <div class="music-time">2:00</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-block card-stretch card-height">
                    <div class="card-body p-0  ">
                        <a href="#"><img src="{{asset('images/page-img/48.jpg')}}" alt="story-img" class="img-fluid rounded h-100 w-100"></a>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">New Music</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="#">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-music overflow-hidden ">
                            <ul  class="swiper-wrapper list-inline m-0 p-0 ">
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n1.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Sean Paul</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n2.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Fetty Wap</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n3.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Brittany Howard</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n4.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Elton John</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n5.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Tierra Whack</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n6.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Trippie Redd</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n7.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Quincy Jones</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="swiper-slide text-center">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n8.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Ciara</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Recent Added</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="#">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="recent-music overflow-hidden ">
                            <ul class="swiper-wrapper list-inline m-0 p-0">
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n8.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Lizzo</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r8.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Kathleen Hanna</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n7.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Sheryl Crow</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r1.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Karen O</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n1.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Cyndi Lauper</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r2.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Rick Ross</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r7.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Kamasi Washington</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/n2.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Christina Aguilera</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Top Music</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <a href="#">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="top-music overflow-hidden">
                            <ul class="swiper-wrapper list-inline m-0 p-0">
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r1.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Mary J. Blige</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r2.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Ne-Yo</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r3.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Loric Sih</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r4.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Annie Flook</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r5.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Alex Gvojic</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r6.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Mindy Monk</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r7.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Coffey Rock</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                                <li class="text-center swiper-slide">
                                    <div class="music-thumbnail position-relative mb-3">
                                    <a href="#"><img src="{{asset('images/page-img/r8.jpg')}}" alt="music-thumb" class="img-fluid w-100"></a>
                                    <div class="play-btn">
                                        <a href="#"><i class="ri-play-fill text-white"></i></a>
                                    </div>
                                    </div>
                                    <h6>Sam Smith</h6>
                                    <p class="mb-0">Best Advice</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</x-app-layout>
    