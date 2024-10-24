<x-app-layout>
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-body chat-page p-0">
                  <div class="chat-data-block">
                     <div class="row">
                        <div id="allChatsUsersChat" class="col-lg-12">
                           <div class="chat-search pt-3 px-3">
                              <div class="chat-searchbar mt-4">
                                 <div class="form-group chat-search-data m-0">
                                    <input type="text" class="form-control round" id="chat-search" placeholder="Search">
                                    <i class="material-symbols-outlined">
                                    search
                                    </i>
                                 </div>
                              </div>
                           </div>
                           <div class="chat-sidebar-channel scroller mt-4 ps-3">
                              <h5 class="">Chats</h5>
                              <ul class="iq-chat-ui nav flex-column nav-pills">
                                 @foreach ($data['allChats']['userChats'] as $chat)
                                    @php
                                       $userIdsArray = explode(',', $chat->user_ids);
                                       $sender_info = \App\Models\Chat::getChatSender($chat->user_ids);
                                       $message = $chat->last_message;
                                       if(strlen($message) > 40)
                                          $message = substr($message, 0, 40).' ...';
                                    @endphp
                                    @if(isset($sender_info->first_name) && isset($sender_info->last_name))
                                       <li>
                                          <a href="javascript:void(0);" class="" class="open-button" onclick="openFormChats({{$chat->id, $chat->user_id}})">
                                             <div class="d-flex align-items-center">
                                                <div class="avatar me-2">
                                                   @if(isset($sender_info->avatar_location) && $sender_info->avatar_location !== '')
                                                      <img class="avatar-50" src="{{asset('storage/images/user/userProfileandCovers/'. $sender_info->id.'/'.$sender_info->avatar_location)}}" alt="" loading="lazy">
                                                   @else
                                                      <img src="{{asset('images/user/05.jpg')}}" alt="" class="avatar-50" loading="lazy">
                                                   @endif
                                                   <span class="avatar-status">
                                                      <i class="material-symbols-outlined filled text-success md-14">
                                                         circle
                                                      </i>
                                                   </span>
                                                </div>
                                                <div class="chat-sidebar-name">
                                                   <h6 class="mb-0">{{$sender_info->first_name}} {{$sender_info->last_name}}</h6>
                                                   <span>{{ $message }}</span>
                                                </div>
                                                <div class="chat-meta float-right text-center mt-2 me-1">
                                                   @if(isset($data['allChats']['chatMessages']))
                                                      @for($i = count($data['allChats']['chatMessages']) - 1; $i >= 0; $i--)
                                                         @if(isset($data['allChats']['chatMessages'][$i]) && $data['allChats']['chatMessages'][$i] !== null)
                                                            @if($chat->id == $data['allChats']['chatMessages'][$i]->chat_id)
                                                               @if( $chat['chatmessages']->resp_user_id == auth()->user()->id)
                                                                  @if( $chat['chatmessages']->resp_user_id == auth()->user()->id && $chat['chatmessages']->responseUserNewMsg == 0)
                                                                     <div class="chat-msg-counter bg-primary text-white">20</div>
                                                                  @endif
                                                                  @if( $chat['chatmessages']->resp_user_id == auth()->user()->id && $chat['chatmessages']->senderUserNewMessage == 0)
                                                                     <div class="chat-msg-counter bg-primary text-white">20</div>
                                                                  @endif
                                                               @endif
                                                            @endif
                                                         @endif
                                                      @endfor
                                                   @endif
                                                   <span class="text-nowrap">{{ $chat->updated_at->diffForHumans() }}</span>
                                                </div>
                                             </div>
                                          </a>
                                       </li>
                                    @endif
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                        <div  id="allChatsUsersMessages" class="col-lg-12 p-0 ">
                           <div class="border border-2 border-bottom-0 border-light border-top-0" id="myFormChat" style="display: none">
                              <div id="cover-spin-Chat"></div>
                              <div class="form-container w-100" style="max-width: none">
                                 <div class="modal-header top_chat_header">
                                    <div class="d-flex align-items-center">
                                       <div class="chat-profile me-3">
                                          <img src="/images/user/Users_40x40.png" id="chatUserIdChats" alt="chat-user" class="avatar-60 rounded-circle img-fluid">
                                       </div>
                                       <div class="chat-caption">
                                          <a href="" id="chatReciverIdChat"><h5 class="mb-0"></h5></a>
                                       </div>
                                    </div>
                                    <a class="lh-1" style="cursor: pointer" onclick="closeForm()">
                                       <span class="material-symbols-outlined">close</span>
                                    </a>
                                 </div>
                                 <div class="chat_wrapper_messages overflow-auto" id="refreshChatMessages" style=" min-height: 59vh; max-height: 60vh;">

                                 </div>
                                 <form>@csrf
                                    <div class="align-items-center d-flex ">
                                       <div class="like-data">
                                          <div class="dropdown">
                                             <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                <a href="javascript:void(0);" class="material-symbols-outlined  me-3">
                                                   sentiment_satisfied
                                                </a>
                                             </span>
                                             <div class="dropdown-menu py-2 emojis">
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#x1F600;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128513;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128514;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128515;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128516;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128517;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128518;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128519;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128520;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128521;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128522;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128523;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128524;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128525;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128526;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128527;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128528;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128529;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128530;</a>
                                                <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128531;</a>
                                             </div>
                                          </div>
                                       </div>
                                          <div class="rounded message_wrapper " style="width: 90%">
                                             <input type="hidden" value={{auth()->user()->id}} name="userSenderId" id="userSenderIdChat" class="form-control rounded">
                                             <input type="hidden" value="" name="userRecieverId" id="userRecieverIdChat" class="form-control rounded">
                                             <input type="hidden" value="User" name="message_type" id="message_typeChat" class="form-control rounded">
                                             <input class="form-control  message_field" name="message" id="messageChat" placeholder="Type something ..."/>
                                             <button type="submit" class="border-0 bg-transparent">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="#418ffe">
                                                   <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                                </svg>
                                             </button>
                                          </div>
                                    </div>
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
   <script>
      $(function() {
          $(".emojisStyleChat").click(function() {
             $('#messageChat').val($('#messageChat').val() + $(this).html());
          });
       });

      function openFormChats(chatId, userId) {
         $('#allChatsUsersChat').hide();
         if (typeof fetchchatInterval !== "undefined") {
            $('#refreshChatMessages').scrollTop(0);
            clearInterval(fetchchatInterval);
         }
         document.getElementById("myFormChat").style.display = "block";
         $('#cover-spin-Chat').show();
         $('#message').focus();
         var scrollPos = $('#refreshChatMessages').prop('scrollHeight');
         fetchchatInterval = setInterval(function() {
            var scrollPos = $('#refreshChatMessages').scrollTop();
            fetchChatsChat(chatId,scrollPos);
            $('#refreshChatMessages').scrollTop(scrollPos);
         }, 5000);
         var scrollPos = $('#refreshChatMessages')[0].scrollHeight;
         this.fetchChatsChat(chatId,scrollPos);
      }

      let messageLengthChats = 0;
      function fetchChatsChat(id,scrollPos) {
         $.ajax({
            method: 'POST',
            url: '/fetchChats',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id},
            success: function (data) {
               let messages = data.chat.original.user_chat;
               let newmessageLengthChats = messages.length;
               if (newmessageLengthChats != messageLengthChats) {
                  $('#cover-spin-Chat').hide();
                  $("#refreshChatMessages").empty();
                  var userdata = data.chat.original.user_chat[0];
                  var user_data_1 = data.chat.original.user_data_1;
                  var userName = data.chat.original.user_data_1.first_name+' '+data.chat.original.user_data_1.last_name;
                  const userIDs = userdata.user_ids.split(',');
                  var userId1 = userIDs[0];
                  var userId2 = userIDs[1];
                  var authUserId = {!! auth()->user()->id !!};
                  var userRecieverId = document.getElementById("#userRecieverIdChat");
                  if(authUserId == userId1){
                     $("#userRecieverIdChat").val(userId2);
                  }else{
                     $("#userRecieverIdChat").val(userId1);
                  }
                  $(".chat-caption h5").html(userName);
                  document.getElementById("chatReciverIdChat").href="/profile/"+user_data_1.username;
                  if(user_data_1.avatar_location && user_data_1.avatar_location !== '')
                  {
                     document.getElementById("chatUserIdChats").src="/storage/images/user/userProfileandCovers/"+user_data_1.id+'/'+user_data_1.avatar_location;
                  }
                  else{
                     document.getElementById("chatUserIdChats").src="/images/user/Users_100x100.png";
                  }
                  var today = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                  var lastDateDisplayed = null;
                  messages.forEach(function (message) {
                     if (message.last_message !== null && message.message !== undefined ) {
                        var messageDate = new Date(message.chat_message_create_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                        if (messageDate !== lastDateDisplayed) {
                           $('.chat_wrapper_messages').append('<div class="date text-center">' + (messageDate == today ? 'Today' : messageDate) + '</div>');
                           lastDateDisplayed = messageDate;
                        }
                        if (authUserId == message.user_id) {
                           if(message.deleted_from_sender !== 'Y'){
                              $('.chat_wrapper_messages').append('<div class="sender align-items-stretch senderdiv chat_message_id_' + message.chat_message_id + '"><div class="dropdown delete_message_hover" ><button class="border-0 bg-transparent" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg height="22px" viewBox="0 0 22 22" width="22px"><circle cx="11" cy="6" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="11" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="16" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle></svg></button><ul class="dropdown-menu p-1" style="min-width:auto" aria-labelledby="dropdownMenuButton"><li><button class="btn btn-primary dropdown-item m-0 px-1 py-0" type="submit" onclick="delete_chat_message('+ message.chat_message_id +')">Remove</button></li></ul></div><div  style=""><div class="msg rounded sender_messages">' + message.message + '</div><div class="time message_time text-end">' +  new Date(message.chat_message_create_at).toLocaleTimeString([], {hour12: true, hourCycle: 'h23', hour: '2-digit', minute:'2-digit'}) + '</div></div></div>');
                              $('.sender').hover(function() {
                                 $(this).find('.delete_message_hover').show();
                              }, function() {
                                 $(this).find('.delete_message_hover').hide();
                              });
                           }
                        } else {
                           if(message.deleted_from_receiver !== 'Y'){
                              $('.chat_wrapper_messages').append('<div class="reciever ms-5 recieverdiv chat_message_id_' + message.chat_message_id + '"><div><div class="msg rounded sender_messages">' + message.message + '</div><div class="time message_time ">' +  new Date(message.chat_message_create_at).toLocaleTimeString([], {hour12: true, hourCycle: 'h23', hour: '2-digit', minute:'2-digit'}) + '</div></div></div>');

                           }
                        }
                     }
                  });
                  messageLengthChats = newmessageLengthChats;
               }


               $('#refreshChatMessages').scrollTop(scrollPos);
            }
         });
         // setInterval(refreshChats(id), 5000);
      }

       function refreshChats(chatId) {
          setInterval(fetchChatsChat(chatId), 5000);
       }

       function closeForm() {
            $('#allChatsUsersChat').show();
            $("#myFormChat").hide().load(" #myFormChat"+"> *").fadeIn(0);
            document.getElementById("myFormChat").style.display = "none";
            clearInterval(fetchchatInterval);
       }

         $("form").on("submit", function(event){
            event.preventDefault();
            var form = $(this);
            var getValue= document.getElementById("messageChat");
            if(getValue.value != null && getValue.value.trim() !== ''){
               $.ajax({
                  method: 'POST',
                  url: '/storeChat',
                  data: form.serialize(),
                  success: function (data) {
                     $('.chat_wrapper_messages').append('<div class="sender align-items-stretch senderdiv chat_message_id_' + data.id  + '"><div class="dropdown delete_message_hover"><button class="border-0 bg-transparent" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg height="22px" viewBox="0 0 22 22" width="22px"><circle cx="11" cy="6" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="11" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="16" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle></svg></button><ul class="dropdown-menu p-1" style="min-width:auto" aria-labelledby="dropdownMenuButton"><li><button class="btn btn-primary dropdown-item m-0 px-1 py-0" type="submit" onclick="delete_chat_message('+ data.id +')">Remove</button></li></ul></div><div  style=""><div class="msg rounded sender_messages">' + data.message + '</div><div class="time message_time text-end">' +  data.time + '</div></div></div>');
                     $('.sender').hover(function() {
                     $(this).find('.delete_message_hover').show();
                     }, function() {
                     $(this).find('.delete_message_hover').hide();
                     });
                     $('#refreshChatMessages').scrollTop($('#refreshChatMessages').prop('scrollHeight'));
                     getValue.value = "";
                  }
               });
            }
         });
   </script>
</x-app-layout>