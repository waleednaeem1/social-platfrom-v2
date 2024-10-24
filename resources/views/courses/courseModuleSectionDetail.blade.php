{{-- @php
   echo "<pre>";
   // print_r($data['module']['sections']);
   print_r($data['all_sections']);
   die;
@endphp --}}
<x-app-layout>
   <div class="header-for-bg">
      <div class="background-header position-relative">
         {{-- <img src="{{asset('images/page-img/profile-bg7.jpg')}}" class="img-fluid w-100" alt="header-bg"> --}}
         <img src="{{asset('images/user/courseCover.png')}}" class="img-fluid w-100" style="height: 368px;" alt="header-bg">
         <div class="title-on-header">
            <div class="data-block">
               <h2>{{$data['section']->title}}</h2>
            </div>
         </div>
      </div>
   </div>
   <div class="content-page" id="content-page">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Progress</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="progress mb-3">

                        @if($data['is_section_complete'])
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                       @else
                        <div class="progress-bar" role="progressbar" style="width: {{$data['percentage']}}%;" aria-valuenow="{{$data['percentage']}}" aria-valuemin="0" aria-valuemax="100">{{$data['percentage']}}%</div>
                      @endif

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Section Info:</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="image-block position-relative">
                        <p class="mb-0">{!! ($data['section']->detail) !!}</p>
                     </div>
                     @if(isset($data['section']->video_id) && $data['section']->video_id !== '')
                        <div class="image-block position-relative">
                           <iframe src="{{'https://player.vimeo.com/video/'.$data['section']->video_id}}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="row" style="margin-bottom:2rem;padding-left: 1rem">
            <div class="col-md-6">
               <a href="{{ url($data['links'][0]['previous']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;" id="button1">Previous</a>
            </div>
            <div class="col-md-6" style="padding-left: 20rem;">
               <a href="{{ url($data['links'][1]['next']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;" id="button2">Next</a>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">This module contains the following sections and exercises​</h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div id="faqAccordion" class="container">
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="accordion" id="accordionExample">
                              {{-- @foreach($data['module']['sections'] as $section) --}}
                              @foreach($data['all_sections'] as $section)
                                 <div class="accordion-item mb-3">
                                    <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
                                       <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                                             {{ $section->title }}
                                       </button>
                                    </h2>
                                    <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $loop->iteration }}" data-bs-parent="#accordionExample">
                                       <div class="accordion-body">
                                             <div id="nestedAccordion" class="accordion">
                                                <a href="{{route('courseModuleSectionDetail',  ['cat_slug' => $data['category']->slug,'course_slug' => $data['course']->slug,'module_slug' => $data['module']->slug,'section_slug' => $section->slug])}}" style="margin-left: 3rem;">
                                                   {{ $section->title }}
                                                </a>
                                                @foreach($section['exercise'] as $exercise)
                                                   <div id="nestedCollapse{{ $loop->iteration }}" class="accordion-collapse collapse show" aria-labelledby="nestedHeading{{ $loop->iteration }}" data-bs-parent="#nestedAccordion">
                                                         <div class="accordion-body"
                                                            style="margin-left: 2rem;background-color: var(--bs-primary-tint-90);height: 60px;margin-bottom: 1rem;">
                                                            <a href="{{ route('courseModuleSectionExcerciseDetail', ['cat_slug' => $data['category']->slug,'course_slug' => $data['course']->slug,'module_slug' => $data['module']->slug,'section_slug' => $section->slug,'exercise_slug' => $exercise->slug]) }}">
                                                               <p>{{ $exercise->title }}</p>
                                                            </a>
                                                         </div>
                                                   </div>
                                                @endforeach
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                              @endforeach
                          </div>
                      </div>
                  </div>
              </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>