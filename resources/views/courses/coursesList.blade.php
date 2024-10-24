<x-app-layout>
   {{-- <x-slot name="pageheader">
        <div class="header-for-bg">
            <div class="background-header position-relative">
               <img src="{{asset('images/page-img/profile-bg7.jpg')}}" class="img-fluid w-100" alt="header-bg">
               <div class="title-on-header">
                  <div class="data-block">
                     <h2>Store</h2>
                  </div>
               </div>
            </div>
         </div>
   </x-slot> --}}
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Course Categories</h4>
                  </div>
               </div>
               <div class="card-body" style="height: 87px">
                  <div class="row">
                     @foreach ($data['course_categories'] as $category)
                        <div class="card" style="width: max-content;background-color: #8c68cd; margin-left:1rem;height: 53px;justify-content:center">
                           <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                              <div class="header-title">
                                 <a href="{{route('coursesList',  ['slug' => $category->slug])}}"><h5 class="card-title" style="color: white;">{{$category->name}}</h5></a>
                              </div>
                           </div>
                        </div>
                     @endforeach
                     {{-- <div class="col-sm-6 col-md-6 col-lg-3 mb-md-0 mb-2">
                        <a href="store-category-grid.html"><img class="img-fluid rounded" src="{{asset('images/store/c1.jpg')}}" alt="category-image1"></a>
                     </div>
                     <div class="col-sm-6 col-md-6 col-lg-3 mb-md-0 mb-2">
                        <a href="store-category-grid.html"><img class="img-fluid rounded" src="{{asset('images/store/c2.jpg')}}" alt="category-image2"></a>
                     </div>
                     <div class="col-sm-6 col-md-6 col-lg-3 mb-md-0 mb-2">
                        <a href="store-category-grid.html"><img class="img-fluid rounded" src="{{asset('images/store/c3.jpg')}}" alt="category-image3"></a>
                     </div>
                     <div class="col-sm-6 col-md-6 col-lg-3">
                        <a href="store-category-grid.html"><img class="img-fluid rounded" src="{{asset('images/store/c4.jpg')}}" alt="category-image4"></a>
                     </div> --}}

                  </div>
               </div>
            </div>
         </div>
         @if(isset($data['course_list']) && count($data['course_list']) > 0)
            <div class="col-lg-12">
               <div class="card shadow-none p-0">
                  <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                     <div class="header-title">
                        <h4 class="card-title">{{$data['category']->name}} Courses</h4>
                     </div>
                  </div>
               </div>
               <div class="row updateFeed">
                  @foreach($data['course_list'] as $course)
                     <div class="col-sm-6 col-md-6 col-lg-4">
                        <div class="card card-block card-stretch card-height product">
                           <div class="card-body">
                              <div class="d-flex align-items-center justify-content-between pb-3">
                                 <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                       <h6>
                                          @if(isset($course['enrollments']) && count($course['enrollments']) > 0 && $course->id == $course['enrollments'][0]->course_id)
                                             @if ($course->marking_user == 'coach')
                                                @if($course['getShallowCourseData'][0]->coach_id == '' || $course['getShallowCourseData'][0]->coach_id == null)
                                                   <a class="mt-1" onclick="enrollCoach('{{ $course->slug }}')">{{$course->title}}</a>
                                                @else
                                                   <a href="{{route('courseDetail',  ['cat_slug' => $data['category']->slug,'course_slug' => $course->slug])}}">{{$course->title}}</a>
                                                @endif
                                             @else
                                                <a href="{{route('courseDetail',  ['cat_slug' => $data['category']->slug,'course_slug' => $course->slug])}}">{{$course->title}}</a>
                                             @endif
                                          @else
                                             <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Purchase this course for further processing!">
                                                <h6><a style="color: #8C68CD">{{$course->title}}</a></h6>
                                             </span>
                                          @endif
                                       </h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="image-block position-relative">
                                 {{-- <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img"> --}}
                                 <img src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course->thumbnail}}" class="w-100 rounded" style="height:252px;width:168px;object-fit: contain;" alt="course-img">
                                 {{-- <div class="offer">
                                    <div class="offer-title">20%</div>
                                 </div> --}}
                                 {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              </div>
                              <div class="product-description mt-3">
                                 <h6 class="mb-1">{{$course['getCourseType']->name}}</h6>
                                 @if(isset($course['enrollments']) && count($course['enrollments']) > 0)
                                    <button type="button" class="btn btn-primary d-block w-100 mt-3" onclick="enrollCourse('{{ $course->slug }}')" data-bs-toggle="modal" data-bs-target="#enrollCourse">
                                       Enrolled
                                    </button>
                                 @else
                                    <button type="button" class="btn btn-primary d-block w-100 mt-3" onclick="enrollCourse('{{ $course->slug }}')" data-bs-toggle="modal" data-bs-target="#enrollCourse">
                                       Enroll
                                    </button>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
            <div id="enrollCoach" class="modal fade bd-example-modal-lg" style="margin-top:4rem" tabindex="-1" role="dialog"  aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <form>
                        <div class="modal-header">
                           <h5 class="modal-title">Select coach first</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                           </button>
                        </div>
                        <div class="modal-body">
                           <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                           <div class="form-group col-sm-6">
                              {!! Form::label('coach', 'Select Coach:') !!}<span class="text-danger">*</span>
                              <div id="div_coach">
                                 <select id="coach-select" class="form-control"></select>
                              </div>
                           </div>
                           <input type="hidden" id="courseSlug" name="courseSlug" value=""/>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           <button type="button" disabled class="btn btn-primary applyCoach">Add Coach</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         @else
            <div style="margin-top:2rem">
               <h4 style="margin-bottom: 2rem;color: #8C68CD;margin-left:4rem">No course available in {{$data['category']->name}} category</h4>
            </div>
         @endif
      </div>
      <div id="enrollCourse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="enrollCourseTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="image-section position-relative" id="image-section">
                  <img id="enrolled-course-thumbnail" src="https://web.dvmcentral.com/up_data/courses/thumbnails/" class="img-fluid w-100 rounded" style="height:252px;width:168px;object-fit:contain" alt="product-img">
               </div>
               <div class="row">
                  <div class="col-md-9">
                     <h5 class="modal-title" id="enrollCourseTitle" style="padding-left: 1rem;padding-top: 1rem;"></h5>
                  </div>
                  <div class="col-md-3">
                     <h5 class="price" id="enrollCoursePrice" style="padding-top: 1.5rem; padding-left: 2rem;"></h5>
                  </div>
               </div>
               <div class="modal-body">
                  <p id="enrollCourseDescription" style="padding-top: 1rem;"></p>
               </div>
               <div>
                  {{-- <h5 class="modal-title" id="enrollCourseModule"></h5> --}}
               </div>
               <div class="modal-footer" id="addToCartBtnDiv" style="display:none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button id="addToCartBtn" type="button" onclick="addToCart()" class="btn btn-primary">Add to Cart</button>
               </div>
               <div class="modal-footer" id="alreadyinCart" style="display:none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" disabled class="btn btn-primary">Already in Cart</button>
               </div>
               <div class="modal-footer" id="alreadyEnrolled" style="display:none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" disabled class="btn btn-primary">Purchased</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>