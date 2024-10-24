<link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
<x-app-layout>
    <div class="d-flex justify-content-center">
        <div class="card" style="width: 40rem;">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Page Settings</h4>
                </div>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-setting-tab" data-bs-toggle="tab" data-bs-target="#nav-setting" type="button" role="tab" aria-controls="nav-setting" aria-selected="true">Settings</button>
                      {{-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> --}}
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-setting" role="tabpanel" aria-labelledby="nav-setting-tab">
                        <div class="d-flex justify-content-between">
                            <div class="py-2">
                                <p class="card-text">Delete "{{ $data['pageDetail'][0]->page_name }}" page.</p>
                            </div>
                            <div class="">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete-page" action="javascript:void();">Delete</button>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div> --}}
                  </div>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete-page" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="delete-page" aria-hidden="true" >
        <div class="modal-dialog   modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header" style="align-items: flex-start;">
                    <div class="modal-title text-dark" style="font-weight: bold;">
                        Delete Page?
                    </div>
                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="modal-body ">
                    <div class="d-flex align-items-center">
                        <p class="modal-title ms-3 " id="unfollow-modalLabel">Do you want to delete page?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center">
                        <form  method="POST" action="{{ route('deletePage', $data['pageDetail'][0]->id) }}">
                            @csrf
                            <button type="submit" data-bs-dismiss="modal" class="btn btn-primary me-2">Yes</button>
                            <a href="javascript:void(0);" class="btn btn-secondary me-2" data-bs-dismiss="modal" action="javascript:void();" role="button">
                                No
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
