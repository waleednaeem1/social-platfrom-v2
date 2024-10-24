<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="header-for-bg">
                    <div class="background-header position-relative">
                        <img src="images/page-img/calender-banner.png" class="img-fluid w-100" alt="profile-bg">
                    </div>
                </div>
                <div id="content-page" class="content-page">
                    <div class="container">
                        <div class="row row-eq-height">
                            <div class="col-md-4 col-lg-3 updateSchedule">
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="input-group">
                                            <div class="vanila-datepicker"></div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h4 class="card-title ">Classification</h4>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">
                                            <a href="#"><i class="fa fa-plus  mr-0" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="m-0 p-0 job-classification list-inline">
                                            <li class=""><i class="ri-check-line bg-danger"></i>Meeting</li>
                                            <li class=""><i class="ri-check-line bg-success"></i>Business travel</li>
                                            <li class=""><i class="ri-check-line bg-warning"></i>Personal Work</li>
                                            <li class=""><i class="ri-check-line bg-info"></i>Team Project</li>
                                        </ul>
                                    </div>
                                </div> --}}
                                {{-- @if(!$data['todaysSchedule']->isEmpty()) --}}
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Today's Schedule</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul class="m-0 p-0 today-schedule">
                                                @if(count($data['todaysSchedule']) > 0)
                                                    @foreach ($data['todaysSchedule'] as $schedule)
                                                        <li class="d-flex">
                                                            {{-- <div class="schedule-icon"><i class="ri-checkbox-blank-circle-fill text-primary"></i></div> --}}
                                                            <div class="schedule-text w-100">
                                                                <span><strong>{{$schedule->event_name}}</strong></span>
                                                                <span><h6>{{ Str::limit($schedule->description, 30, '...') }}</h6></span>
                                                                <span><h6>{{$schedule->address}}</h6></span>
                                                                <span>{{ \Carbon\Carbon::parse($schedule->event_start_time)->format('g:i A') }}</span>
                                                            </div>
                                                            <div>
                                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-edit-event-modal" onclick="editScheduleEvent({{$schedule}})"><span class="material-symbols-outlined">edit</span></a>
                                                                <a href="javascript:void(0)" onclick="deleteScheduleEvent({{$schedule->id}})"><span class="material-symbols-outlined">delete</span></a>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="d-flex">
                                                        <span><h6>No schedule for today</h6></span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                {{-- @endif --}}
                                @if(!$data['tomorrowsSchedule']->isEmpty())
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Tomorrow's Schedule</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul class="m-0 p-0 today-schedule">
                                                @foreach ($data['tomorrowsSchedule'] as $tomSchedule)
                                                    <li class="d-flex">
                                                        <div class="schedule-icon"><i class="ri-checkbox-blank-circle-fill text-primary"></i></div>
                                                        <div class="schedule-text">
                                                            <span><strong>{{$tomSchedule->event_name}}</strong></span>
                                                            <span><h6>{{ Str::limit($tomSchedule->description, 30, '...') }}</h6></span>
                                                            <span><h6>{{$tomSchedule->address}}</h6></span>
                                                            <span>{{ \Carbon\Carbon::parse($tomSchedule->event_start_time)->format('g:i A') }}</span>
                                                        </div>
                                                        <div>
                                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-edit-event-modal" onclick="editScheduleEvent({{$tomSchedule}})"><span class="material-symbols-outlined">edit</span></a>
                                                            <a href="javascript:void(0)" onclick="deleteScheduleEvent({{$tomSchedule->id}})"><span class="material-symbols-outlined">delete</span></a>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <div class="card">
                                <div class="card-header d-flex justify-content-between flex-wrap">
                                    <div class="header-title">
                                        <h4 class="card-title">Add Schedule</h4>
                                    </div>
                                    <div class="card-header-toolbar d-flex align-items-center mt-1 mt-md-0">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#add-edit-event-modal" class="material-symbols-outlined md-18" onclick="addScheduleEvent()">
                                            AddEvent
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="calendar1" class="calendar-s"></div>
                                </div>
                                </div>
                            </div>

                            <div class="modal fade" id="add-edit-event-modal" tabindex="-1"  aria-labelledby="event-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
                                <div class="modal-dialog  modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="event-modalLabel">Add Schedule</h5>
                                            <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                <span class="material-symbols-outlined">close</span>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex align-items-center" data-bs-spy="scroll">
                                                <form class="post-text ms-3 w-100 add_edit_schedule_event" action="{{ route('user.addEvent') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="event_calender_grid" style="display: grid;grid-template-columns: 1fr 1fr;">
                                                        <div>
                                                            <input type="hidden" id="schedule_id" name="schedule_id" value="" required class="form-control rounded" style="border:none;">
                                                            <input type="hidden" name="userId" value={{auth()->user()->id}} required class="form-control rounded" style="border:none;">
                                                            <input type="text" name="eventName" id="eventName" required class="form-control rounded" placeholder="Event Name" style="border: 1px solid #d2d0d0;">
                                                            <hr>
                                                            <label>Date</label>
                                                            <input id="eventDate" required type="date" class="form-control" name="eventDate" style="margin-bottom: -2px; margin-left: -1px;"/>
                                                            {{-- <input type="text" name="otherRequirements" required class="form-control rounded" placeholder="Other Requirements" style="border:none;"> --}}
                                                            <hr>
                                                            {{-- <hr> --}}

                                                            {{-- <label>Event Image</label>
                                                            <input type="file" name="eventImage" id="eventImage" required class="form-control" accept="image/*" placeholder="Event Image" style="border:none;">
                                                            <hr> --}}

                                                        </div>
                                                        <div>
                                                            <input type="text" name="location" id="location" required class="form-control rounded" placeholder="Address" style=" border: 1px solid #d2d0d0;
                                                            margin-left: 2px;">
                                                            <hr>

                                                            <label>Start Time</label>
                                                            <input type="time" id="startTime" required name="startTime" class="form-control" style="margin-bottom: -2px; margin-left: 1px;">
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <textarea style="border: 1px solid #d2d0d0;" name="description" required class="form-control rounded" placeholder="Description" id="description" rows="4"></textarea>
                                                    <button type="submit" class="btn btn-primary d-block w-100 mt-3" id="event-buttonLabel">Add Schedule</button>
                                                </form>
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
