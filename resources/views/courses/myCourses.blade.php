<x-app-layout>
    <div id="content-page" class="content-page">
        <div class="container">
            {{-- <h2 style="margin-bottom: 2rem;">My Courses</h2> --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    <h4 class="card-title">My Courses</h4>
                    </div>
                </div>
            </div>
            @if(count($courseEnrollments) > 0)
                <div class="d-grid gap-2 d-grid-template-1fr-19 grid-cols-2 updateFeed">
                    @foreach($courseEnrollments as $course)
                        @if(!empty($course['course']))
                            @if ($course['course']->marking_user == 'coach')
                                @if($course['course']['getShallowCourseData'][0]->coach_id == '' || $course['course']['getShallowCourseData'][0]->coach_id == null)
                                    {{-- <a class="mt-1" onclick="enrollCoach('{{ $course->slug }}')">{{$course->title}}</a> --}}
                                    <a onclick="enrollCoach('{{ $course['course']->slug }}')" class="iq-sub-card">
                                        <div class="card mb-0" style="max-width: 520px; height: 8rem;">
                                            <div class="align-items-center card-body d-flex p-3">
                                                <div class="mt-0" style="">
                                                    @if (isset($course['course']->thumbnail) && $course['course']->thumbnail !== '')
                                                        <img class="avatar-120 rounded" style="object-fit:contain" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course['course']->thumbnail}}"alt="">
                                                    @else
                                                        <img class="avatar-100 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                    @endif
                                                </div>
                                                <div class="p-3">
                                                    <h6>{{$course['course']->title}}</h6>
                                                    <small>{{ $course['course']->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{route('courseDetail',  ['cat_slug' => $course['course']['category']->slug,'course_slug' => $course['course']->slug])}}" class="iq-sub-card">
                                        <div class="card mb-0" style="max-width: 520px; height: 8rem;">
                                            <div class="align-items-center card-body d-flex p-3">
                                                <div class="mt-0" style="">
                                                    @if (isset($course['course']->thumbnail) && $course['course']->thumbnail !== '')
                                                        <img class="avatar-120 rounded" style="object-fit:contain" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course['course']->thumbnail}}"alt="">
                                                    @else
                                                        <img class="avatar-100 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                    @endif
                                                </div>
                                                <div class="p-3">
                                                    <h6>{{$course['course']->title}}</h6>
                                                    <small>{{ $course['course']->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @else
                                {{-- <a href="{{route('courseDetail',  ['cat_id' => $course['course']->course_category_id,'course_id' => $course['course']->id])}}" class="iq-sub-card"> --}}
                                <a href="{{route('courseDetail',  ['cat_slug' => $course['course']['category']->slug,'course_slug' => $course['course']->slug])}}" class="iq-sub-card">
                                    <div class="card mb-0" style="max-width: 520px; height: 8rem;">
                                        <div class="align-items-center card-body d-flex p-3">
                                            <div class="mt-0" style="">
                                                @if (isset($course['course']->thumbnail) && $course['course']->thumbnail !== '')
                                                    <img class="avatar-120 rounded" style="object-fit:contain" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course['course']->thumbnail}}"alt="">
                                                @else
                                                    <img class="avatar-100 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                @endif
                                            </div>
                                            <div class="p-3">
                                                <h6>{{$course['course']->title}}</h6>
                                                <small>{{ $course['course']->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endif
                    @endforeach
                </div>
            @else
                <div style="margin-top:2rem">
                    <h4 style="margin-bottom: 2rem;">You have no purchased courses yet</h4>
                    <a href="{{route('courses.categories')}}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;">View Courses</a>
                </div>
            @endif
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
                            <div id="error-message" class="alert alert-success" style="display: none;"></div>
                            <div class="form-group col-sm-6">
                               {!! Form::label('coach', 'Select Coach:') !!}<span class="text-danger">*</span>
                               <div id="div_coach">
                                  <select id="coach-select" class="form-control"></select>
                               </div>
                            </div>
                            <input type="hidden" id="courseSlug" name="courseSlug" value=""/>
                         </div>
                         <div class="col-sm-12 text-center loader-div" style="display: none;">
                            <img src="{{asset('images/page-img/page-load-loader.gif')}}" alt="loader" style="height: 100px;">
                         </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" disabled class="btn btn-primary applyCoach">Add Coach</button>
                         </div>
                      </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
