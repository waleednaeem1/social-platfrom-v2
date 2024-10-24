<x-app-layout>
    <div class="container-fluid">
        <div class="desktop-header">
            <div class="card card-block topnav-left">
                <div class="card-body write-card">
                    <div class="d-flex align-items-top justify-content-between">
                        <div class="iq-note-callapse-menu">
                            <a class="iq-note-callapse-btn show-note-button" data-toggle="collapse" href="#collapseMenu" role="button"
                                data-extra-toggle="toggle" data-extra-class-show=".hide-note-button" data-extra-class-hide=".show-note-button"
                                aria-expanded="false">
                                <i class="las la-pencil-alt pr-2"></i>Write Your Note
                            </a>
                            <span class="hide-note-button d-none"><i class="las la-folder pr-2"></i>Folder</span>
                        </div>
                        <div class="note-right media align-items-top hide-note-button d-none">
                            <div class="mr-2"><a href="#" class="btn view-btn body-bg" data-toggle="modal" data-target="#share-note">Share</a></div>
                            <div class="view-btn btn-dropdown body-bg rounded">
                                <div class="dropdown">
                                    <span class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown">
                                        <i class="ri-more-2-fill"></i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#"><i class="lar la-heart mr-3"></i>Add To Favorite</a>
                                        <a class="dropdown-item" href="#"><i class="las la-thumbtack mr-3"></i>Mark As Pin</a>
                                        <a class="dropdown-item" href="#"><i class="las la-trash-alt mr-3"></i>Move to Trash</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card topnav-right">
                {{-- {{> partials/backend/header-action }} --}}
                <x-header-action />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="collapse" id="collapseMenu">
                    <div class="card card-block card-stretch">
                        <div class="card-body write-card">
                            <div class="container-fluid collapse-fluid">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 p-0">
                                        <div class="card card-transparent card-block card-stretch event-note">
                                            <div class="card-body px-0 bukmark">
                                                <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">                                                    
                                                    <div class="quill-tool">
                                                    </div>
                                                    <div class="iq-full-screen"><a href="#" class="" id="btnFullscreen"><i class="las la-expand-arrows-alt font-size-18"></i></a></div>
                                                </div>
                                                <div id="quill-toolbar">
                                                    <h1 class="mb-3">Birthday Bash</h1>
                                                    <p>Hosting friend's birthday party and purchasing items.</p>
                                                    <ul>
                                                        <li>Cake</li>
                                                        <li>Balloons</li>
                                                        <li>Cold Drinks</li>
                                                    </ul>
                                                    <img src="{{asset('images/event-note/01.png')}}" class="img-fluid image-1" alt="image">                                                    
                                                    <img src="{{asset('images/event-note/02.png')}}" class="img-fluid image-2" alt="image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-12 p-0 d-flex justify-content-end">
                                        <button class="btn btn-outline-primary" data-extra-toggle="toggle" data-extra-class-show=".show-note-button" data-extra-class-hide=".hide-note-button">Close</button>
                                        <button class="btn btn-primary ml-2" data-extra-toggle="toggle" data-extra-class-show=".show-note-button" data-extra-class-hide=".hide-note-button">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">                
                <div class="card card-block card-stretch">
                    <div class="card-body custom-notes-space">
                        <h3 class="mb-3">Your Reminder Notes</h3>
                        <div class="rounded p-2 iq-grid body-bg mb-4">                            
                            <form class="add-notes">
                                <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                <input type="text" class="text search-input" placeholder="6 Notes" value="">
                            </form>
                        </div> 
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height card-bottom-border-info note-detail">
                                    <div class="card-header d-flex justify-content-between pb-1">
                                        <div class="icon iq-icon-box-2 icon-border-info rounded">
                                            <svg width="23" height="23" class="svg-icon" id="iq-main-01" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle dropdown-bg" id="dropdownMenuButton3"
                                                    data-toggle="dropdown" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton3" style="">
                                                        <a href="#" class="dropdown-item new-note1" data-toggle="modal" data-target="#new-note1"><i class="las la-eye mr-3"></i>View</a>
                                                        <a href="#" class="dropdown-item edit-note1" data-toggle="modal" data-target="#edit-note1"><i class="las la-pen mr-3"></i>Edit</a>
                                                        <a class="dropdown-item" data-extra-toggle="delete" data-closest-elem=".card" href="#"><i class="las la-trash-alt mr-3"></i>Delete</a>
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body rounded">
                                        <div class="media flex-wrap align-items-top">
                                            <h4 class="card-title mr-3">Weekly Planner</h4>
                                            <span class="card-text card-text-info"><i class="ri-time-line mr-2"></i>02:30 Am</span>
                                        </div>
                                        <p class="mb-3 card-description short">Virtual Digital Marketing Course every week on Monday, Wednesday and Saturday.Virtual Digital Marketing Course every week on Monday</p>                                                            
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center justify-content-between note-text note-text-info"> 
                                            <a href="#" class=""><i class="las la-user-friends mr-2 font-size-20"></i>03 share</a>                                                            
                                            <a href="#" class=""><i class="las la-calendar mr-2 font-size-20"></i>10 Jan 2021</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height card-bottom-border-purple note-detail">
                                    <div class="card-header d-flex justify-content-between pb-1">
                                        <div class="icon iq-icon-box-2 icon-border-purple rounded">
                                            <svg width="23" height="23" class="svg-icon" id="iq-main-02" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                            </svg>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle dropdown-bg" id="dropdownMenuButton4"
                                                    data-toggle="dropdown" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton4" style="">
                                                    <a href="#" class="dropdown-item new-note2" data-toggle="modal" data-target="#new-note2"><i class="las la-eye mr-3"></i>View</a>
                                                    <a href="#" class="dropdown-item edit-note1" data-toggle="modal" data-target="#edit-note1"><i class="las la-pen mr-3"></i>Edit</a>
                                                    <a class="dropdown-item" data-extra-toggle="delete" data-closest-elem=".card" href="#"><i class="las la-trash-alt mr-3"></i>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body rounded">
                                        <div class="media flex-wrap align-items-top">
                                            <h4 class="card-title mr-3">Birthday Celebration</h4>
                                            <span class="card-text card-text-purple"><i class="ri-time-line mr-2"></i>02:45 Am</span>
                                        </div>
                                        <p class="mb-3 card-description short">Take organized notes and share later as meeting minutes or check-list with this simple accessible Noteplus.</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center justify-content-between note-text note-text-purple"> 
                                            <a href="#" class=""><i class="las la-user mr-2 font-size-20"></i>Only You</a>                                                            
                                            <a href="#" class=""><i class="las la-calendar mr-2 font-size-20"></i>11 Jan 2021</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height card-bottom-border-warning note-detail">
                                    <div class="card-header d-flex justify-content-between pb-1">
                                        <div class="icon iq-icon-box-2 icon-border-warning rounded">
                                            <svg width="23" height="23" class="svg-icon" id="iq-main-03"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">                                                                
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="favorite"><i class="lar la-heart mr-2"></i></a>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle dropdown-bg" id="dropdownMenuButton5"
                                                    data-toggle="dropdown" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton5" style="">
                                                    <a href="#" class="dropdown-item new-note3" data-toggle="modal" data-target="#new-note3"><i class="las la-eye mr-3"></i>View</a>
                                                    <a href="#" class="dropdown-item edit-note1" data-toggle="modal" data-target="#edit-note1"><i class="las la-pen mr-3"></i>Edit</a>
                                                    <a class="dropdown-item" data-extra-toggle="delete" data-closest-elem=".card" href="#"><i class="las la-trash-alt mr-3"></i>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body rounded">
                                        <div class="media flex-wrap align-items-top">
                                            <h4 class="card-title mr-3">Essay Outline</h4>
                                            <span class="card-text card-text-warning"><i class="ri-time-line mr-2"></i>03:00 Am</span>
                                        </div>
                                        <ul class="pl-3 mb-0">
                                            <li class="note-list mb-2">Content should be of topic.</li>
                                            <li class="note-list mb-2">300 Words only.</li>
                                            <li class="note-list">Make presentation.</li>
                                        </ul>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center justify-content-between note-text note-text-warning"> 
                                            <a href="#" class=""><i class="las la-user mr-2 font-size-20"></i>Only You</a>                                                            
                                            <a href="#" class=""><i class="las la-calendar mr-2 font-size-20"></i>12 Jan 2021</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height card-bottom-border-danger note-detail">
                                    <div class="card-header d-flex justify-content-between pb-1">
                                        <div class="icon iq-icon-box-2 icon-border-danger rounded">
                                            <svg width="23" height="23" class="svg-icon" id="iq-main-04" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">                                                                
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="favorite"><i class="lar la-heart mr-2"></i></a>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle dropdown-bg" id="dropdownMenuButton6"
                                                    data-toggle="dropdown" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton6" style="">
                                                    <a href="#" class="dropdown-item new-note4" data-toggle="modal" data-target="#new-note4"><i class="las la-eye mr-3"></i>View</a>
                                                    <a href="#" class="dropdown-item edit-note1" data-toggle="modal" data-target="#edit-note1"><i class="las la-pen mr-3"></i>Edit</a>
                                                    <a class="dropdown-item" data-extra-toggle="delete" data-closest-elem=".card" href="#"><i class="las la-trash-alt mr-3"></i>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body rounded">
                                        <div class="media flex-wrap align-items-top">
                                            <h4 class="card-title mr-3">Lecture Notes</h4>
                                            <span class="card-text card-text-danger"><i class="ri-time-line mr-2"></i>02:45 Am</span>
                                        </div>
                                        <div class="checkbox mb-2">
                                            <input type="checkbox" class="checkbox-input mr-3" id="checkbox1">
                                            <label for="checkbox1" class="note-checkbox mb-0">Chapter 1 notes.</label>
                                        </div>
                                        <div class="checkbox mb-2">
                                            <input type="checkbox" class="checkbox-input mr-3" id="checkbox2">
                                            <label for="checkbox2" class="note-checkbox mb-0">Chapter 2 Assignment.</label>
                                        </div>
                                        <div class="checkbox mb-2">
                                            <input type="checkbox" class="checkbox-input mr-3" id="checkbox3">
                                            <label for="checkbox3" class="note-checkbox mb-0">Chapter 3 practical File.</label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center justify-content-between note-text note-text-danger"> 
                                            <a href="#" class=""><i class="las la-user mr-2 font-size-20"></i>Only You</a>                                                            
                                            <a href="#" class=""><i class="las la-calendar mr-2 font-size-20"></i>10 Jan 2021</a>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height card-bottom-border-primary note-detail">
                                    <div class="card-header d-flex justify-content-between pb-1">
                                        <div class="icon iq-icon-box-2 icon-border-primary rounded">
                                            <svg width="23" height="23" class="svg-icon" id="iq-main-05" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="pin content"><i class="las la-thumbtack mr-2"></i></a>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle dropdown-bg" id="dropdownMenuButton7"
                                                    data-toggle="dropdown" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton7" style="">
                                                    <a href="#" class="dropdown-item new-note5" data-toggle="modal" data-target="#new-note5"><i class="las la-eye mr-3"></i>View</a>
                                                    <a href="#" class="dropdown-item edit-note1" data-toggle="modal" data-target="#edit-note1"><i class="las la-pen mr-3"></i>Edit</a>
                                                    <a class="dropdown-item" data-extra-toggle="delete" data-closest-elem=".card" href="#"><i class="las la-trash-alt mr-3"></i>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body rounded">
                                        <div class="media flex-wrap align-items-top">
                                            <h4 class="card-title mr-3">Image Notes</h4>
                                            <span class="card-text card-text-primary"><i class="ri-time-line mr-2"></i>03:30 Am</span>
                                        </div>
                                        <ul class="row mb-0 p-0 list-inline flex-wrap align-items-center">
                                            <li class="col-md-4">
                                                <a href="#">
                                                    <img src="{{asset('images/gallery/grid/01.jpg')}}" class="img-fluid rounded note-image" alt="" />  
                                                </a> 
                                            </li>
                                            <li class="col-md-4">
                                                <a href="#">
                                                    <img src="{{asset('images/gallery/grid/02.jpg')}}" class="img-fluid rounded note-image" alt="" />  
                                                </a> 
                                            </li>
                                            <li class="col-md-4">
                                                <a href="#">
                                                    <img src="{{asset('images/gallery/grid/03.jpg')}}" class="img-fluid rounded note-image" alt="" />  
                                                </a> 
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center justify-content-between note-text note-text-primary"> 
                                            <a href="#" class=""><i class="las la-user-friends mr-2 font-size-20"></i>01 share</a>                                                            
                                            <a href="#" class=""><i class="las la-calendar mr-2 font-size-20"></i>10 Jan 2021</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height card-bottom-border-success note-detail">
                                    <div class="card-header d-flex justify-content-between pb-1">
                                        <div class="icon iq-icon-box-2 icon-border-success rounded">
                                            <svg width="23" height="23" class="svg-icon" id="iq-main-06" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle dropdown-bg" id="dropdownMenuButton8"
                                                    data-toggle="dropdown" aria-expanded="false" role="button">
                                                    <i class="ri-more-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton8" style="">
                                                    <a href="#" class="dropdown-item new-note6" data-toggle="modal" data-target="#new-note6"><i class="las la-eye mr-3"></i>View</a>
                                                    <a href="#" class="dropdown-item edit-note1" data-toggle="modal" data-target="#edit-note1"><i class="las la-pen mr-3"></i>Edit</a>
                                                    <a class="dropdown-item" data-extra-toggle="delete" data-closest-elem=".card" href="#"><i class="las la-trash-alt mr-3"></i>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body rounded">
                                        <div class="media flex-wrap align-items-top">
                                            <h4 class="card-title mr-3">Benefits of NotePlus</h4>
                                            <span class="card-text card-text-success"><i class="ri-time-line mr-2"></i>03:45 Am</span>
                                        </div>
                                        <p class="mb-3 card-description short">Take organized notes and share later as meeting minutes or check-list with this simple accessible Noteplus.</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex align-items-center justify-content-between note-text note-text-success"> 
                                            <a href="#" class=""><i class="las la-user-friends mr-2 font-size-20"></i>02 share</a>                                                            
                                            <a href="#" class=""><i class="las la-calendar mr-2 font-size-20"></i>13 Jan 2021</a>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
    {{-- {{!-- {{> partials/backend/modal }} --}} 
    <!-- Modal Edit -->
    <div class="modal fade" id="edit-note1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <div class="media align-items-top justify-content-between">                            
                            <h3 class="mb-3">Weekly Planner</h3>
                            <div class="btn-cancel p-0" data-dismiss="modal"><i class="las la-times"></i></div>
                        </div>
                        <div class="content edit-notes">
                            <div class="card card-transparent card-block card-stretch event-note mb-0">
                                <div class="card-body px-0 bukmark">
                                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">                                                    
                                        <div class="quill-tool">
                                        </div>
                                    </div>
                                    <div id="quill-toolbar1">
                                        <p>Virtual Digital Marketing Course every week on Monday, Wednesday and Saturday.Virtual Digital Marketing Course every week on Monday</p>
                                    </div>
                                </div>
                                <div class="card-footer border-0">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-end">
                                        <div class="btn btn-primary mr-3" data-dismiss="modal">Cancel</div>
                                        <div class="btn btn-outline-primary" data-dismiss="modal">Save</div>
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