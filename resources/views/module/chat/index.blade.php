@php
    $user = auth()->user();
    $value = session()->get('chatId');
    setcookie('chatId', $value, time() + (86400 * 30), "/"); // 86400 = 1 day
@endphp

<x-app-layout layout="chatlayout" :assets="$assets ?? []"  :groupImages="false" >
    {{-- @php
        echo "<pre>";
        print_r($assets);
        die;
    @endphp --}}
    <div class="tab-content" id="myTabContent">

        {{-- <div class="card tab-pane mb-0 fade show active" id="user-content-101" role="tabpanel">
            <x-modules.chat.widgets.chat-header userName="Team Discussions" userProfileImg="avatar/01.png" status="Online" statusidentify="online" />
                <div class="card-body chat-body bg-body">
                    <div class="chat-day-title">
                        <span class="main-title">Feb 1,2021</span>
                    </div>


                    <x-modules.chat.widgets.right-chat username="" messageTime="16:34" userImg="avatar/01.png"  message="How can we help? We're here for you! 😄" />

                    <x-modules.chat.widgets.left-chat username="" messageTime="16:40" userImg="avatar/05.png" message="Hey John, I am looking for the best admin template." />

                    <x-modules.chat.widgets.right-chat username="" messageTime="16:42" userImg="avatar/01.png" message="Absolutely Yes! Hope-UI is the Responsive Bootstrap 5 Admin Dashboard Template😄" />

                    <x-modules.chat.widgets.left-chat username="" messageTime="17:00" userImg="avatar/05.png"  message="Looks clean and fresh UI."/>
                    <x-modules.chat.widgets.left-chat username="" messageTime="17:01" userImg="avatar/01.png" messsage="I will purchase it for sure. 👍" />

                    <x-modules.chat.widgets.right-chat username="" messageTime="17:10" userImg="avatar/01.png" message="Okay Thanks.."/>

                    <div class="chat-day-title">
                        <span class="main-title">Today</span>
                    </div>

                    <x-modules.chat.widgets.right-chat username="" messageTime="08:00" userImg="avatar/01.png" Image='true' groupImages='true' message="How can we help? We're here for you! 😄" />

                    <x-modules.chat.widgets.left-chat username="" messageTime="12:00" userImg="avatar/05.png" message="How can we help? We're here for you! 😄" />
                    <x-modules.chat.widgets.left-chat username="" messageTime="12:05" userImg="avatar/01.png" message="Hey John, I am looking for the best admin template.
                    Could you please help me to find it out? 🤔" />

                    <x-modules.chat.widgets.right-chat username="" messageTime="13:10" userImg="avatar/01.png"  message="Absolutely Yes! Hope-UI is the Responsive Bootstrap 5 Admin Dashboard Template."  />
                    <div></div>
                    <x-modules.chat.widgets.left-chat username="" messageTime="15:00" userImg="avatar/01.png" Image='true' singleImage='true'  />
                </div>
            <x-modules.chat.widgets.chat-footer />
        </div> --}}
        <div class="card tab-pane mb-0 fade user-message-check" id="user-content-{{$value}}" role="tabpanel">
        {{-- <div class="card tab-pane mb-0 fade user-message-check" id="user-content-1" role="tabpanel"> --}}
            <x-modules.chat.widgets.chat-header userName="Usman Mahmood" userProfileImg="avatar/06.png" status="Last seen 10 min ago" statusidentify="offline" />
            <div class="card-body chat-body bg-body" style="margin-left:6rem">
                <div class="chat-day-title">
                    <span class="main-title">Feb 14,2023</span>
                </div>
                <div class="reciever ">
                    <div class="msg rounded" id="messagess">
                       hi therw hi therw hi therw
                    </div>
                    <div class="time">
                       @php
                          $date = date('d-m-y h:i:s');
                          echo $date;
                       @endphp
                    </div>
                 </div>
                 <div class="sender" id="masterdiv">
                    {{-- <div class="msg rounded" id="messagess">
                        hi therw hi therw hi therw
                     </div>
                     <div class="time">
                        @php
                           $date = date('d-m-y h:i:s');
                           echo $date;
                        @endphp
                     </div> --}}
                 </div>
            </div>
            {{-- <x-modules.chat.widgets.chat-footer /> --}}
            <div class="card-footer px-3 py-3 border-top rounded-0" style="margin-left: 6rem">
               <form>
                @csrf
               <div class="d-flex align-items-center">
                  <input type="hidden" value={{$user->id}} name="userSenderId" id="userSenderId" class="form-control rounded" />
                  <input type="hidden" value=555 name="userRecieverId" id="userRecieverId" class="form-control rounded" />
                  <input type="hidden" value="Mine" name="message_type" id="message_type" class="form-control rounded" />
                  <div class="like-data">
                    <div class="dropdown">
                       <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                          {{-- <img src="{{asset('images/icon/1.png')}}" alt="story-img" class="img-fluid" class="img-fluid" alt=""> --}}
                          <a href="#" class="d-flex align-items-center pe-3"> <svg class="icon-24" width="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_156_599)">
                                <path d="M20.4853 4.01473C18.2188 1.74823 15.2053 0.5 12 0.5C8.79469 0.5 5.78119 1.74823 3.51473 4.01473C1.24819 6.28119 0 9.29469 0 12.5C0 15.7053 1.24819 18.7188 3.51473 20.9853C5.78119 23.2518 8.79469 24.5 12 24.5C15.2053 24.5 18.2188 23.2518 20.4853 20.9853C22.7518 18.7188 24 15.7053 24 12.5C24 9.29469 22.7518 6.28119 20.4853 4.01473ZM12 23.0714C6.17091 23.0714 1.42856 18.3291 1.42856 12.5C1.42856 6.67091 6.17091 1.92856 12 1.92856C17.8291 1.92856 22.5714 6.67091 22.5714 12.5C22.5714 18.3291 17.8291 23.0714 12 23.0714Z" fill="currentcolor"></path>
                                <path d="M9.40398 9.3309C8.23431 8.16114 6.33104 8.16123 5.16136 9.3309C4.88241 9.60981 4.88241 10.0621 5.16136 10.3411C5.44036 10.62 5.89266 10.62 6.17157 10.3411C6.78432 9.72836 7.78126 9.7284 8.39392 10.3411C8.53342 10.4806 8.71618 10.5503 8.89895 10.5503C9.08171 10.5503 9.26457 10.4806 9.40398 10.3411C9.68293 10.0621 9.68293 9.60986 9.40398 9.3309Z" fill="currentcolor"></path>
                                <path d="M18.8384 9.3309C17.6688 8.16123 15.7655 8.16114 14.5958 9.3309C14.3169 9.60981 14.3169 10.0621 14.5958 10.3411C14.8748 10.62 15.3271 10.62 15.606 10.3411C16.2187 9.72836 17.2156 9.72831 17.8284 10.3411C17.9679 10.4806 18.1506 10.5503 18.3334 10.5503C18.5162 10.5503 18.699 10.4806 18.8384 10.3411C19.1174 10.0621 19.1174 9.60986 18.8384 9.3309Z" fill="currentcolor"></path>
                                <path d="M18.3335 13.024H5.6668C5.2723 13.024 4.95251 13.3438 4.95251 13.7383C4.95251 17.6243 8.11409 20.7859 12.0001 20.7859C15.8862 20.7859 19.0477 17.6243 19.0477 13.7383C19.0477 13.3438 18.728 13.024 18.3335 13.024ZM12.0001 19.3573C9.14366 19.3573 6.77816 17.215 6.42626 14.4525H17.574C17.2221 17.215 14.8566 19.3573 12.0001 19.3573Z" fill="currentcolor"></path>
                            </g>
                            <defs>
                                <clipPath>
                                    <rect width="24" height="24" fill="white" transform="translate(0 0.5)"></rect>
                                </clipPath>
                            </defs>
                            </svg>
                        </a>
                       </span>
                       <div class="dropdown-menu py-2 emojis">
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#x1F600;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128513;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128514;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128515;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128516;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128517;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128518;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128519;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128520;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128521;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128522;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128523;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128524;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128525;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128526;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128527;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128528;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128529;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128530;</p></a>
                          <a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title=""><p style="font-size: 30px">&#128531;</p></a>
                       </div>
                    </div>
                 </div>
                {{-- <a href="#" class="d-flex align-items-center pe-3">
                    <svg class="icon-24" width="18" height="23" viewBox="0 0 18 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.00021 21.5V18.3391" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.00021 14.3481V14.3481C6.75611 14.3481 4.9384 12.5218 4.9384 10.2682V5.58095C4.9384 3.32732 6.75611 1.5 9.00021 1.5C11.2433 1.5 13.061 3.32732 13.061 5.58095V10.2682C13.061 12.5218 11.2433 14.3481 9.00021 14.3481Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M17 10.3006C17 14.7394 13.418 18.3383 9 18.3383C4.58093 18.3383 1 14.7394 1 10.3006" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M11.0689 6.25579H13.0585" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.0704 9.59344H13.0605" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a> --}}
                  <input class="form-control  message_field" name="message" id="message" placeholder="Type something ..." />
                      {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="#418ffe">
                         <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                      </svg> --}}
                      <button type="submit" class="btn btn-primary d-flex align-items-center" style="margin-left:10px">
                        <svg class="icon-20" width="18" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.8325 6.67463L8.10904 12.4592L1.59944 8.38767C0.66675 7.80414 0.860765 6.38744 1.91572 6.07893L17.3712 1.55277C18.3373 1.26963 19.2326 2.17283 18.9456 3.142L14.3731 18.5868C14.0598 19.6432 12.6512 19.832 12.0732 18.8953L8.10601 12.4602" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="d-none d-lg-block ms-1">Send</span>
                    </button>
                </span>
                </div>
             </form>
            </div>
        </div>
    </div>
    
</x-app-layout>

<script>
    // $(document).ready(function() {
    //     @php echo "var id = '" .$value . "'"; @endphp
    //     // alert(id);
    //     // return false;
    //     fetchChats(id);
    // });

    function fetchChats(id) 
    {
        // var test = 'user-content-'+id;
        // var updateDone = document.getElementsByClassName("user-message-check").id = 'user-content-'+id;

        // jQuery(this).prev("user-message-check").attr("id",'user-content-'+id);
        // console.log(test)
        // alert(id);
        // var updateDone = document.getElementsByClassName('user-message-check').setAttribute('id', test);
        // alert(updateDone);
        // if(updateDone){
        //     alert('done');
        //     return false;
        // }
        // else{
        //     alert('not done');
        //     return false;
        // }
        // document.querySelector('.user-message-check').setAttribute('id', test);
        // document.querySelector(".example");
        $.ajax({
            method: 'POST',
            url: '/fetchChats',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id},
            success: function (data) {
                document.getElementsByClassName("user-message-check").id = 'user-content-'+id;
                $('#masterdiv').empty(); 
                var userName = data.chat.original.user_chat[0].first_name+' '+data.chat.original.user_chat[0].last_name;
                let messages = data.chat.original.user_chat;
                $(".chat-caption h5").html(userName);
                // if(messages[0].avatar_location && messages[0].avatar_location !== '')
                // {
                //     document.getElementById("chatUserId").src="http://127.0.0.1:8000/storage/images/user/userProfileandCovers/"+messages[0].id+'/'+messages[0].avatar_location;
                // }
                // else{
                //     document.getElementById("chatUserId").src="http://127.0.0.1:8000/images/user/1.jpg";
                // }
                for (let i = 0; i < messages.length; i++) {
                    $('.sender').append('<div class="msg rounded sender_messages">'+data.chat.original.user_chat[i].message+'</div><br><div class="time message_time">'+data.chat.original.user_chat[i].updated_at+'</div>').addClass('msg rounded sender_messages');
                }
                // setInterval(this.refreshChats(id), 3000);
            }
        });
    }

    // function refreshChats(chatId) {
    //     this.fetchChats(chatId);
    // }

    $("form").on("submit", function(event){
         event.preventDefault();
         var form = $(this);
         var getValue= document.getElementById("message");
         $.ajax({
            method: 'POST',
            url: '/storeChat',
            data: form.serialize(),
            success: function (data) { 
               console.log(data);
               $('.sender').append('<div class="msg rounded sender_messages">'+data.message+'</div><br><div class="time message_time">'+data.time+'</div>').addClass('msg rounded sender_messages');
               getValue.value = "";
            }
         });
    });
</script>
