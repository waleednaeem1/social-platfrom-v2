@php
    $user = auth()->user();
@endphp
<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                @foreach ($data['feeds'] as $feed)
                    @include('partials/_feed')
                @endforeach
                @if($data['feeds']->count() <= 0)
                    <div class="card">
                        <div class="card-body p-0">
                            <div class=" card-body text-center justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;" >
                                <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="40" fill="#8c68cd">
                                    <path d="M140-120q-24.75 0-42.375-17.625T80-180v-660l67 67 66-67 67 67 67-67 66 67 67-67 67 67 66-67 67 67 67-67 66 67 67-67v660q0 24.75-17.625 42.375T820-120H140Zm0-60h310v-280H140v280Zm370 0h310v-110H510v110Zm0-170h310v-110H510v110ZM140-520h680v-120H140v120Z"/>
                                </svg>
                                <div>
                                    <p class="fw-semibold" style="max-height: 10px;">No Post Yet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="modal fade" id="feed_likes_modal_popup">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-scrollable-feeds  modal-md" style="top:4rem">
                        <div class="modal-content">
                            <div class="card p-4 feed_likes_modal_loder d-none">
                                <h5 class="card-title">
                                    <div class="row flex-lg-nowrap">
                                        <span class="avatar-65 col-2 placeholder rounded-5"></span>
                                        <div>
                                            <span class="placeholder col-7 mt-2 mb-2"></span>
                                            <span class="placeholder col-5"></span>
                                        </div>
                                    </div>
                                </h5>
                                <div class="card-img-top bg-soft-light placeholder-img"></div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <span class="placeholder py-3"></span>
                                        </div>
                                        <div class="col-4">
                                            <span class="placeholder py-3"></span>
                                        </div>
                                        <div class="col-4">
                                            <span class="placeholder py-3"></span>
                                        </div>
                                    </div>
                                    <p class="card-text">
                                        <span class="placeholder"></span>
                                        <span class="placeholder"></span>
                                        <span class="placeholder"></span>
                                        <span class="placeholder"></span>
                                        <span class="placeholder"></span>
                                    </p>
                                </div>
                            </div>
                            <div id="feedModalHeader" class="modal-header d-none">
                                <h1 id="feedModalHeading" class="modal-title fs-5"></h1>
                                <span id="feedModalClose" type="button" class="btn-close"></span>
                            </div>
                            <div class="modal-body ">
                                <div id="feedModalBodyContent" class="modal-content border-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/feedModal.js?version=0.36') }}"></script>
    @endpush
    <script>
        function removeFavoritePost(feedId) {
        $.ajax({
            method: 'GET',
            url: '/removePost/'+ feedId,
            data: {
                feedId: feedId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            if(response.status == 1){
                $('#removeFavoritePostDiv_'+feedId).addClass('d-none');
            }
        });
    }
    </script>
</x-app-layout>
