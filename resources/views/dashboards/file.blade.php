<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Files</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                            <span class="dropdown-btoggle material-symbols-outlined" id="dropdownMenuButton5" data-bs-toggle="dropdown">
                            more_horiz
                            </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton5">
                               <a class="dropdown-item d-flex align-items-center" href="#"><span class="material-symbols-outlined me-2 md-18">
                               visibility
                               </span>View</a>
                               <a class="dropdown-item d-flex align-items-center" href="#"><span class="material-symbols-outlined me-2 md-18">
                               delete
                               </span>Delete</a>
                               <a class="dropdown-item d-flex align-items-center" href="#"><span class="material-symbols-outlined me-2 md-18">
                               edit
                               </span>Edit</a>
                               <a class="dropdown-item d-flex align-items-center" href="#"><span class="material-symbols-outlined me-2 md-18">
                               print
                               </span>Print</a>
                               <a class="dropdown-item d-flex align-items-center" href="#"><span class="material-symbols-outlined me-2 md-18">
                               file_download
                               </span>Download</a>
                            </div>
                         </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row justify-content-between d-flex">
                            <div class="col-sm-12 col-md-6">
                            <div id="user_list_datatable_info" class="dataTables_filter">
                                <form class="me-3 position-relative">
                                    <div class="form-group mb-0">
                                        <input type="search" class="form-control" id="exampleInputSearch" placeholder="Search">
                                    </div>
                                </form>
                            </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                            <div class="user-list-files d-flex justify-content-end">
                                <a href="#" class="chat-icon-phone btn bg-soft-primary">
                                Print
                                </a>
                                <a href="#" class="chat-icon-video btn bg-soft-primary">
                                Excel
                                </a>
                                <a href="#" class="chat-icon-delete btn bg-soft-primary">
                                Pdf
                                </a>
                            </div>
                            </div>
                        </div>
                        <table class="files-lists table table-striped mt-4">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </th>
                                <th scope="col">File Name</th>
                                <th scope="col">File Type</th>
                                <th scope="col">Date</th>
                                <th scope="col">Size</th>
                                <th scope="col">Author</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <img class="rounded-circle img-fluid avatar-40 me-2" src="{{asset('images/page-img/43.png')}}" alt="profile"> post report
                                </td>
                                <td>Document</td>
                                <td>
                                    Mar 12, 2020
                                </td>
                                <td>390 kb</td>
                                <td>
                                    Anna Sthesia
                                </td>
                                <td>
                                    <div class="flex align-items-center list-user-action lh-1">
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Download" href="#"><i class="material-symbols-outlined">
                                       file_download
                                       </i></a>
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" href="#"><i class="material-symbols-outlined">
                                       delete
                                       </i></a>
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <img class="rounded-circle img-fluid avatar-40 me-2" src="{{asset('images/page-img/44.png')}}" alt="profile"> usages
                                </td>
                                <td>Document</td>
                                <td>
                                    Mar 18, 2020
                                </td>
                                <td>600 kb</td>
                                <td>
                                    Paul Molive
                                </td>
                                <td>
                                    <div class="flex align-items-center list-user-action lh-1">
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Download" href="#"><i class="material-symbols-outlined">
                                       file_download
                                       </i></a>
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" href="#"><i class="material-symbols-outlined">
                                       delete
                                       </i></a>
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <img class="rounded-circle img-fluid avatar-40 me-2" src="{{asset('images/page-img/45.png')}}" alt="profile"> Images file
                                </td>
                                <td>Slide</td>
                                <td>
                                    Mar 19, 2020
                                </td>
                                <td>800 kb</td>
                                <td>
                                    Bob Frapples
                                </td>
                                <td>
                                    <div class="flex align-items-center list-user-action lh-1">
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Download" href="#"><i class="material-symbols-outlined">
                                       file_download
                                       </i></a>
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" href="#"><i class="material-symbols-outlined">
                                       delete
                                       </i></a>
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <img class="rounded-circle img-fluid avatar-40 me-2" src="{{asset('images/page-img/46.png')}}" alt="profile"> total comments
                                </td>
                                <td>Document</td>
                                <td>
                                    Mar 21, 2020
                                </td>
                                <td>500 kb</td>
                                <td>
                                    Barb Ackue
                                </td>
                                <td>
                                    <div class="flex align-items-center list-user-action lh-1">
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Download" href="#"><i class="material-symbols-outlined">
                                       file_download
                                       </i></a>
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" href="#"><i class="material-symbols-outlined">
                                       delete
                                       </i></a>
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <img class="rounded-circle img-fluid avatar-40 me-2" src="{{asset('images/page-img/47.png')}}" alt="profile"> popular events
                                </td>
                                <td>Pdf</td>
                                <td>
                                    Mar 24, 2020
                                </td>
                                <td>320 kb</td>
                                <td>
                                    Barb Ackue
                                </td>
                                <td>
                                    <div class="flex align-items-center list-user-action lh-1">
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Download" href="#"><i class="material-symbols-outlined">
                                       file_download
                                       </i></a>
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" href="#"><i class="material-symbols-outlined">
                                       delete
                                       </i></a>
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <img class="rounded-circle img-fluid avatar-40 me-2" src="{{asset('images/page-img/43.png')}}" alt="profile"> todo list
                                </td>
                                <td>excel</td>
                                <td>
                                    Mar 28, 2020
                                </td>
                                <td>600 kb</td>
                                <td>
                                    Ira Membrit
                                </td>
                                <td>
                                    <div class="flex align-items-center list-user-action lh-1">
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Download" href="#"><i class="material-symbols-outlined">
                                       file_download
                                       </i></a>
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" href="#"><i class="material-symbols-outlined">
                                       delete
                                       </i></a>
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class=" text-center">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <img class="rounded-circle img-fluid avatar-40 me-2" src="{{asset('images/page-img/45.png')}}" alt="profile"> music list
                                </td>
                                <td>pdf</td>
                                <td>
                                    Mar 30, 2020
                                </td>
                                <td>900 kb</td>
                                <td>
                                    Pete Sariya
                                </td>
                                <td>
                                    <div class="flex align-items-center list-user-action lh-1">
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Download" href="#"><i class="material-symbols-outlined">
                                       file_download
                                       </i></a>
                                       <a data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" href="#"><i class="material-symbols-outlined">
                                       delete
                                       </i></a>
                                    </div>
                                 </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>    

</x-app-layout>
