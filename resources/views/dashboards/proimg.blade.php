{{-- @php  


echo "<pre>";
   print_r($data);
   die;

@endphp --}}

<x-app-layout>
    {{-- <div class="header-for-bg">
        <div class="background-header position-relative">
            @if (isset($data['user'][0]) && $data['user'] !== '')
                        <img src="{{asset('images/profile-img/'.$data['user'][0]->image_path)}}" class="img-fluid rounded w-100 rounded rounded" alt="profile-bg">
                     @else
                     <img src="{{asset('images/profile-img/profile-bg5.jpg')}}" class="img-fluid rounded w-100 rounded rounded" alt="profile-bg">
                     @endif
                <div class="title-on-header">
                    <div class="data-block">
                        <h2>Your Photos</h2>
                    </div>
                </div>
        </div>
    </div> --}}
    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
               @foreach ($data['user'] as $img)
                  <div class="col-lg-4 col-md-6">
                     <div class="user-images position-relative overflow-hidden mb-3">
                        @if (isset($img) && $img !== '')
                           <a data-fslightbox="gallery" href="{{asset('storage/images/user/userProfileandCovers/'. $img->user_id.'/'.$img->image_path)}}">
                              <img src="{{asset('storage/images/user/userProfileandCovers/'. $img->user_id.'/'.$img->image_path)}}" class="img-fluid rounded" alt="Responsive image">
                           </a>
                        @else
                           <img src="{{asset('images/page-img/51.jpg')}}" class="img-fluid rounded" alt="Responsive image">
                        @endif
                        {{-- <div class="image-hover-data">
                           <div class="product-elements-icon">
                                 <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                    <li><a href="#" class="pe-3 text-white d-flex align-items-center"> 60 <i class="material-symbols-outlined md-14 ms-1">
                                       thumb_up
                                       </i> </a>
                                    </li>
                                    <li><a href="#" class="pe-3 text-white d-flex align-items-center"> 30 <span class="material-symbols-outlined  md-14 ms-1">
                                       chat_bubble_outline
                                       </span> </a>
                                    </li>
                                    <li><a href="#" class="pe-3 text-white d-flex align-items-center"> 10 <span class="material-symbols-outlined md-14 ms-1">
                                       forward
                                       </span></a>
                                    </li>
                                 </ul>
                              </div>
                        </div> --}}
                        {{-- <a href="#" class="image-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove">
                           drive_file_rename_outline
                        </a> --}}
                     </div>
                  </div>
               @endforeach
            </div>
        </div>
    </div>
</x-app-layout>