<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\EventsController;
use App\Models\Chat;
use App\Models\ChatMessage;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\User;


class ChatBoxController extends Controller
{

    public function getChatId($vendor_user_id, $loggedIn_user_id)
    {
        $resp = EventsController::chat_setup(
            [
                'resp_user_id' => $vendor_user_id,
                'ses_user_id' => $loggedIn_user_id,
                'start_chat' => true
            ]
        );

        return $resp['chat_id'];
    }

    /*
    |-Devsinc Chat APIs
    |--------------------------------------------------------------------------
    */

    public function getChatUserList($user_id)
    {
        try{
            $data['user_chat'] = Chat::whereHas('chatmessages', function ($query){
                $query->where('message_type', 'user')->with('user_data')->with('resp_user_data');
            })->where('user_ids', 'like', '%'. $user_id.'%')->where('last_message', '!=', null)->orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            return response()->json(['error' =>$th->getMessage()],201);
        }
        //removing self user records from chat
        foreach($data['user_chat'] as $user_chat){

            if($user_id == @$user_chat->chatmessages->user_data->id ){
                unset($user_chat->chatmessages->user_data);
                $user_chat->chatmessages->user_data =$user_chat->chatmessages->resp_user_data;
                unset($user_chat->chatmessages->resp_user_data);
            }elseif($user_id == @$user_chat->chatmessages->resp_user_data->id ){
                unset($user_chat->chatmessages->resp_user_data);
            }
            if( $user_chat->un_read_chats == null ){
                $user_chat->un_read_chats = '1';
            }

        }
        return response()->json($data, 200);
    }

    public function storeChat(Request $request)
    {


        $newChat = new ChatMessage();
        $chat_id = $this->getChatId($request->user_id, $request->customer_id);
        $newChat->user_id = $request->customer_id;
        $newChat->resp_user_id = $request->user_id;
        $newChat->chat_id = $chat_id;
        $newChat->message = $request->message;
        $chatExist = Chat::where('user_ids', 'like', '%'. $request->user_id.'%')->where('user_ids', 'like', '%'. $request->customer_id.'%')->first();

        if($chatExist->sender_id == $request->customer_id){
            $newChat->responseUserNewMsg = 0;
            $newChat->responseUserNewMsgBadge = 0;
        }else{
            $newChat->senderUserNewMessage = 0;
            $newChat->senderUserNewMessageBadge = 0;
        }

        $newChat->message_type = $request->message_type;
        $newChat->user_type = $request->customer_id;
        $newChat->save();

        $chat = Chat::find($chat_id);
        $chat->last_message = $request->message;
        $chat->sender_id = $request->customer_id;
        $chat->un_read_chats = '1';
        $chat->save();
        return response()->json(['chat' => $newChat, 'message' => 'message send successfully'], 200);
    }

    public function user_chat_list($chatId, $userId = null)
    {
        if($chatId){
            $user = User::find($userId);

            $userChatBodyHeader['userChats'] =  Chat::whereHas('chatmessages')->with('chatmessages', function ($query){
                $query->where('message_type', 'User')->with('user_data')->with('resp_user_data');
            })->where('id', $chatId)->orderBy('id', 'desc')->get();

            foreach($userChatBodyHeader['userChats'] as $key => $userChatsSingle){
                if(isset($userChatsSingle)){
                    if(isset($userChatsSingle->sender_id) && $userChatsSingle->sender_id == $user->id && isset($userChatsSingle['chatmessages']->chat_id) && $userChatsSingle->id == $userChatsSingle['chatmessages']->chat_id){
                        $readChatMessages[$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('senderUserNewMessage',0)->orderBy('id','desc')->update(['senderUserNewMessage' => 1,'senderUserNewMessageBadge' => 1]);
                    }else{
                        $readChatMessages[$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('responseUserNewMsg',0)->orderBy('id','desc')->update(['responseUserNewMsg' => 1, 'responseUserNewMsgBadge' => 1]);

                    }
                }
            }
        }

        $data['user_chat'] = ChatMessage::where([['chat_id', $chatId]])->with('user_data')->with('resp_user_data')->orderBy('id', 'DESC')->get();
        // foreach($data['user_chat'] as $key => $userChat){
            //removing dleeted messages form chat record
            // if($userChat->user_id == $userId){
            //     if($userChat->deleted_from_sender == 'Y'){
            //        unset($data['user_chat'][$key]);
            //     }
            // }elseif($userChat->resp_user_id == $userId){
            //     if($userChat->deleted_from_receiver == 'Y'){
            //         unset($data['user_chat'][$key]);
            //      }
            // }
        // }
        return response()->json($data, 200);
    }

    public function deleteMessage($messageId,$userId){
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

    public function deleteChat($chatId){
        $chat = Chat::find($chatId);

        if ($chat == null || empty($chat)) {
            return response()->json(['success' => false, 'message' => 'Chat does not exists'], 201);
        }else{
            $chat->delete();
            return response()->json(['success' => true, 'message' => 'Chat deleted successfully'], 200);
        }
    }

    public function readChat($chatId){
        $chat = Chat::find($chatId);
        if(!$chat){
            return response()->json(['success' => false, 'message' => 'Chat deos not exists.'], 201);
        }else{
            $chat->un_read_chats = '0';
            $chat->save();
            return response()->json(['success' => true, 'message' => 'Chat read successfully.'], 200);
        }
    }

    public function chatreadbadge($user_id)
    {
        $user = User::find($user_id);
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

        return response()->json(['success' => True, 'message' => 'All chats read successfully'], 200);
    }
}
