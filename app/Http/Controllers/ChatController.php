<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserProfileDetails;
use App\Models\Chat;
use App\Models\ChatMessage;



class ChatController extends Controller
{
    public function chats(Request $request)
    {
        $user = auth()->user();

        $userProfileDetails = UserProfileDetails::firstOrCreate([
            'user_id' => $user->id,
         ]);

         $data['allChats'] = Chat::getChats($user->id);
         $data['userTotalChats'] = Chat::getChatsNewCount();
        return view('dashboards.chat', compact('data'));
    }

    public function storeChat(Request $request)
    {
        $chatExist = Chat::where('user_ids', 'like', '%'. $request->userSenderId.'%')->where('user_ids', 'like', '%'. $request->userRecieverId.'%')->first();

        if(isset($chatExist) && $chatExist->channel !== ''){
            Chat::where('user_ids', 'like', '%'. $request->userSenderId.'%')->where('user_ids', 'like', '%'. $request->userRecieverId.'%')->update(['last_message' => $request->message]);
        }
        else{
            $hashChat_user_ids[] = $request->userSenderId;
            $hashChat_user_ids[] = $request->userRecieverId;

            $chat_user_ids[] = $request->userSenderId;
            $chat_user_ids[] = $request->userRecieverId;

            sort($chat_user_ids);

            $channel = Chat::getHash($hashChat_user_ids);
            $chat = new Chat;
            $chat->channel = $channel;
            $chat->user_ids = implode(',', $chat_user_ids);
            $chat->un_read_chats = '0';
            $chat->status = 'Y';
            $chat->last_message = $request->message;
            $chat->sender_id = $request->userSenderId;
            $chat->save();
            $chat->refresh();
        }
        $chatMessage = new ChatMessage();
        if(isset($chatExist) && $chatExist->id !== ''){
            $chatMessage->chat_id = $chatExist->id;
        }
        else{
            $chatMessage->chat_id = $chat->id;
        }
        $chatMessage->user_id = $request->userSenderId;
        $chatMessage->resp_user_id = $request->userRecieverId;
        $chatMessage->message = $request->message;
        $chatMessage->message_type = $request->message_type;
        $chatMessage->user_type = $request->userSenderId;

        $userIdsArray = explode(',', $chatExist->user_ids);
        sort($userIdsArray);
        if($chatExist->sender_id == auth()->user()->id){
            $chatMessage->responseUserNewMsg = 0;
            $chatMessage->responseUserNewMsgBadge = 0;
        }else{
            $chatMessage->senderUserNewMessage = 0;
            $chatMessage->senderUserNewMessageBadge = 0;
        }
        $chatMessage->save();
        if(isset($chatExist) && $chatExist->id !== ''){
            $date = date("h:i A", strtotime($chatMessage->created_at));
            return response()->json(['message' => $request->message, 'time' => $date], 200);
        }
        $date = date("h:i A", strtotime($chat->created_at));
        return response()->json(['message' => $chat->last_message, 'time' => $date], 200);
    }

    public function fetchChats(Request $request)
    {
        $chatId = $request->id;
        if($chatId){
            $user = auth()->user();

            $userChatBodyHeader['userChats'] =  Chat::whereHas('chatmessages')->with('chatmessages', function ($query){
                $query->where('message_type', 'User')->with('user_data')->with('resp_user_data');
            })->where('user_ids', 'like', '%'. $user->id.'%')->where('last_message', '!=', null)->where('id', $chatId)->orderBy('id', 'desc')->get();

            foreach($userChatBodyHeader['userChats'] as $key => $userChatsSingle){
                if(isset($userChatsSingle)){
                    if(isset($userChatsSingle->sender_id) && $userChatsSingle->sender_id == $user->id && isset($userChatsSingle['chatmessages']->chat_id) && $userChatsSingle->id == $userChatsSingle['chatmessages']->chat_id){
                        $data['allChats'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('senderUserNewMessage',0)->orderBy('id','desc')->update(['senderUserNewMessage' => 1,'senderUserNewMessageBadge' => 1]);
                    }else{
                        $data['allChats'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('responseUserNewMsg',0)->orderBy('id','desc')->update(['responseUserNewMsg' => 1, 'responseUserNewMsgBadge' => 1]);

                    }
                }
            }
        }
        $completeChat = Chat::chatList($chatId);

        return response()->json(['chat' => $completeChat], 200);
    }

    public function createAndFetchChats(Request $request)
    {
        $chatId = $request->chatId;
        $userId = $request->userId;
        $loggedInUserId = auth()->user()->id;
        // $channel = md5($loggedInUserId ."-". $userId);
        $hashChat_user_ids[] = $userId;
        $hashChat_user_ids[] = $loggedInUserId;
        $chat_user_ids[] = $loggedInUserId;
        $chat_user_ids[] = $userId;

        sort($hashChat_user_ids);
        $channel = Chat::getHash($hashChat_user_ids);

        $chatExist = Chat::where('user_ids', 'like', '%'. $loggedInUserId.'%')->where('user_ids', 'like', '%'. $userId.'%')->first();

        if(isset($chatExist) && $chatExist->channel !== ''){
            $fetchChat = Chat::where('user_ids', 'like', '%'. $loggedInUserId.'%')->where('user_ids', 'like', '%'. $userId.'%')->first();
        }
        else{
            $chat = new Chat;
            $chat->id = $chatId;
            $chat->channel = $channel;
            $chat->user_ids = implode(',', $chat_user_ids);
            $chat->status = 'Y';
            $chat->un_read_chats = '0';
            $chat->sender_id = $loggedInUserId;
            $chat->save();

            $fetchChat = Chat::find($chatId);
        }

        return response()->json(['fetchChat' => $fetchChat], 200);
    }

    public function chatreadbadge(Request $request)
    {
        $user = auth()->user();

        $userChatBodyHeader['userChats'] =  Chat::whereHas('chatmessages')->with('chatmessages', function ($query){
            $query->where('message_type', 'User')->with('user_data')->with('resp_user_data');
        })->where('user_ids', 'like', '%'. $user->id.'%')->where('last_message', '!=', null)->orderBy('id', 'desc')->get();

        foreach($userChatBodyHeader['userChats'] as $key => $userChatsSingle){
            if($userChatsSingle){
                if(isset($userChatsSingle->sender_id) && $userChatsSingle->sender_id == $user->id && isset($userChatsSingle['chatmessages']->chat_id) && $userChatsSingle->id == $userChatsSingle['chatmessages']->chat_id){
                    $data['allChats'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('senderUserNewMessageBadge',0)->orderBy('id','desc')->update(['senderUserNewMessageBadge' => 1]);
                }else{
                    $data['allChats'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('responseUserNewMsgBadge',0)->orderBy('id','desc')->update(['responseUserNewMsgBadge' => 1]);

                }
            }
        }
        return response()->json('success', 200);
    }

    public function deleteMessage($messageId){
        $userId = auth()->user()->id;
        $message = ChatMessage::find($messageId);

        if ($message == null || empty($message)) {
            return response()->json(['success' => false, 'message' => 'Message does not exists'], 201);
        }else{
            $chatId = $message->chat_id;
            $data['user_chat'] = ChatMessage::where([['chat_id', $chatId]])->with('user_data')->with('resp_user_data')->orderBy('id', 'DESC')->get();
            if($message->user_id == $userId){
                $message->deleted_from_sender = 'Y';
            }elseif($message->resp_user_id == $userId){
                $message->deleted_from_receiver = 'Y';
            }
            $message->save();
            return response()->json(['success' => true, 'message' => 'message deleted successfully','data' => $data], 200);
        }
    }
}
