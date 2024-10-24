<style>
    .modal {
    --bs-modal-width: 800px !important;
}
</style>
<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="row">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Pet of the Month</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="petOfTheMonth">
                    @if(count($data['pets']) > 0)
                        @foreach($data['pets'] as $pet)
                            <div class="col-md-6 mt-3">
                                {{-- <a href="{{route('pet.petdetail',  ['slug' => $pet->slug])}}" > --}}
                                        <div class="petOfTheMonthImage">
                                            @if(isset($pet['images'][0]->pet_image) && $pet['images'][0]->pet_image !== '')
                                                <img src="https://web.dvmcentral.com/up_data/pets-of-the-month/images/{{$pet['images'][0]->pet_image}}" style="width:100%" />
                                            @else
                                                <img src="{{asset('images/user/Users_150x150.png')}}" alt="frame" />
                                            @endif
                                        </div>
                                        <div class="petOfTheMonthHeading">
                                            <p class="petOfTheMonthName m-0">{{$pet->pet_name}}</p>
                                            <p class="petOfTheMonthDetail m-0">(Pet of the Month's of {{ date('F Y') }})</p>
                                        </div>
                                        {{-- <h5 style="color:blueviolet; text-align:center; padding-top: 10px;">Pet of the Month {{$pet->created_at->diffForHumans()}}</h5> --}}
                                {{-- </a> --}}
                            </div>
                        @endforeach
                    @else
                        <h2 style="color:blueviolet; text-align:center;">No pet available.</h2>
                    @endif
                </div>
                {{-- @php
                    $currentDate = now();
                    $startOfMonth = now()->startOfMonth();
                    $startOf21stDay = now()->startOfMonth()->addDays(20)->addDay(); // Start of the 21st day
                    $endOfMonth = now()->endOfMonth();
                @endphp
                @if ($currentDate >= $startOf21stDay && $currentDate <= $endOfMonth)
                    <div class="row mt-5">
                        <div class="card p-5">
                            <div class="header-title poll-title p-4">
                                <div class="poll-question">Select one Pet for Pet of the Month.</div>
                            </div>
                            <div class="card-body">
                                <div class="poll-container">
                                    <form id="yourForm" action="{{ route('pet.polling') }}" method="post" class="vottingForm" onsubmit="return validateForm()">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                        <section class="radio-section">
                                            <div class="radio-list w-100">
                                                @forelse ($data['petOfTheMonthPoll'] as $request)
                                                    <div class="d-flex justify-content-between radio-item" onclick="selectOption('{{$request['getPet']->id}}')">
                                                        <input type="radio" name="petofthemonth" id="{{$request['getPet']->id}}" value="{{$request['getPet']->id}}" {{ isset($data['petPollingData']) && $data['petPollingData']->pet_id == $request['getPet']->id ? 'checked' : '' }}>
                                                        <label for="{{$request['getPet']->name}}">{{$request['getPet']->name}}</label>
                                                        <div class="votecount">{{$request['getPet']->vote_count == 0 ? '' : ($request['getPet']->vote_count <= 1 ? $request['getPet']->vote_count.' Vote' : $request['getPet']->vote_count.' Votes')}}</div>
                                                    </div>
                                                @empty
                                                    No Pet Found!
                                                @endforelse
                                            </div>
                                        </section>
                                        <input type="submit" class="vottingBtn mt-3" value="Vote">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('input[type="file"]').change(function () {
                var inputId = $(this).attr('id');
                var file = $(this)[0].files[0];

                if (file) {
                    var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (inputId === 'images' && !allowedTypes.includes(file.type)) {
                        $('.image-error').html('Please select a valid image file jpg, jpeg, png etc.');
                        $(this).val(''); 
                    }
                    else if (inputId === 'video' && !file.type.startsWith('video/')) {
                        $('.vedio-error').html('Please select a valid video file.');
                        $(this).val(''); 
                    }
                    else {
                        $('.image-error').html('');
                        $('.vedio-error').html('');
                    }
                }
            });
        });

        $(document).on('submit', 'form.update-on-ajax', function(e) {
            var id = $(this).attr('id');
            
            if(id == undefined)
                $('.cover_spin_ProfilePhotoUpdate').show();

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.type === 'petBadgeRequest') {
                        var button = $('.pet-badge-btn-'+id);
                        button.html('Request Sent Successfully');
                        button.removeClass('btn-primary');
                        button.addClass('btn-success');
                        button.prop('disabled', true);
                        return;
                    }else{
                        $("#petOfTheMonth").hide().load(" #petOfTheMonth"+"> *").fadeIn(0);
                        $('.cover_spin_ProfilePhotoUpdate').hide();
                    }
                },
                complete: function() {
                    if(id == undefined){
                        $('.bd-example-modal-xl').modal('hide');
                        $('.update-on-ajax-reset')[0].reset();
                    }
                },
            
            });

        });
    </script>
</x-app-layout>
