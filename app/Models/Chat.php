<?php

namespace App\Models;

use App\Models\Attendee;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Chat extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chats';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['channel','user_ids', 'last_message', 'sender_id', 'status'];

    public static function getHash(Array $users = [])
    {
        if(count($users) > 1)
        {
            sort($users);
            $users = implode(',', $users);
            return md5($users);
        }
        return null;
    }

    public static function getIdByHash($channel)
    {
        $chat = self::where('channel', $channel)->first();
        return $chat->id;
    }

    public static function getMessages($channel)
    {
        $chat = self::select('id')->where('channel', $channel)->first();        
        if($chat)
        {
            $messages = ChatMessage::where('chat_id', $chat->id)->get();
            return $messages;
        }
        return null;
    }

    public static function getChats($user_id)
    {
        $user = auth()->user();

        $userChatBodyHeader['userChats'] =  self::whereHas('chatmessages')->with('chatmessages', function ($query){
            $query->where('message_type', 'User')->with('user_data')->with('resp_user_data');
        })->where('user_ids', 'like', '%'. $user_id.'%')->where('last_message', '!=', null)->orderBy('updated_at', 'desc')->get();
        foreach($userChatBodyHeader['userChats'] as $key => $userChatsSingle){
            if(isset($userChatsSingle) && isset($userChatsSingle['chatmessages'])){
                $userChatBodyHeader['chatFirstMessage'] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->orderBy('id','ASC')->first();
                if($userChatsSingle->sender_id == $user->id && $userChatsSingle->id == $userChatsSingle['chatmessages']->chat_id){
                    $userChatBodyHeader['chatMessages'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('senderUserNewMessage',0)->orderBy('id','desc')->first();
                }else{
                    $userChatBodyHeader['chatMessages'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('responseUserNewMsg',0)->orderBy('id','desc')->first();
                }
            }
        }
        return $userChatBodyHeader;
    }

    public static function getChatsNewCount()
    {
        $user = auth()->user();
        $userChatBodyHeader['userChats'] =  self::whereHas('chatmessages')->with('chatmessages', function ($query){
            $query->where('message_type', 'User')->with('user_data')->with('resp_user_data');
        })->where('user_ids', 'like', '%'. $user->id.'%')->where('last_message', '!=', null)->orderBy('id', 'desc')->get();

        if($userChatBodyHeader['userChats']->count() <= 0 ){
            $data['allChats'] = self::whereHas('chatmessages')->with('chatmessages', function ($query){
                $query->where('message_type', 'User')->with('user_data')->with('resp_user_data');
            })->where('user_ids', 'like', '%'. 'noChats' .'%')->where('last_message', '!=', null)->orderBy('id', 'desc')->get(); 
        }

        foreach($userChatBodyHeader['userChats'] as $key => $userChatsSingle){
            if(isset($userChatsSingle) && isset($userChatsSingle['chatmessages'])){
                $userChatBodyHeader['chatFirstMessage'] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->orderBy('id','ASC')->first();
                if($userChatsSingle->sender_id == $user->id && $userChatsSingle->id == $userChatsSingle['chatmessages']->chat_id){
                    $data['allChats'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('senderUserNewMessageBadge',0)->orderBy('id','desc')->first();
                }else{
                    $data['allChats'][$key] = ChatMessage::where(['chat_id' => $userChatsSingle->id])->where('responseUserNewMsgBadge',0)->orderBy('id','desc')->first();
                }
            }
        }
        $userAllChatscount = 0;
        if(isset($data)){
            foreach ($data['allChats'] as $chat) {
                if ($chat != null) {
                    $userAllChatscount++;
                }
            }
        }
        return  $userAllChatscount;
    }

    public static function chatsId($user_id)
    {
        $loggedUserId = auth()->user()->id;
        return self::whereRaw("FIND_IN_SET(". $user_id .", user_ids)")->whereRaw("FIND_IN_SET(". $loggedUserId .", user_ids)")->orderBy('updated_at', 'desc')->first();
    }

    public static function chatsIdNull()
    {
        $lastChat = self::orderBy('id', 'desc')->first();
        $newId = $lastChat ? $lastChat->id + 1 : 1;
        return $newId;
    }

    public static function getChatSender($user_ids)
    {
        $logged_in_user = session()->get('ses_user_id');
        
        if(!is_array($user_ids))
            $user_ids = explode(',', $user_ids);

        $sender = array_values(array_diff($user_ids, [$logged_in_user]));//(Int)str_replace(',', '', str_replace($logged_in_user, '', $user_ids));
        if(is_array($sender) && count($sender) > 0)
        {
            // ->where('last_message' === null)->first()
            if($sender[0] == auth()->user()->id){
                $sender = $sender[1];
            }else{

                $sender = $sender[0];   
            }
            $sender = User::find($sender);
            if($sender)
            {
                return $sender;
            }
        }   
    }

    public function chatmessages()
    {
        return $this->hasOne(ChatMessage::class, 'chat_id')->orderBy('id', 'DESC');
    }

    public static function chatList($chatId)
    {
        $checkUserChat = DB::table('chats')
        ->select('users.*','chats.*','chat_messages.chat_id','chat_messages.chat_id','chat_messages.user_id','chat_messages.resp_user_id','chat_messages.deleted_from_receiver','chat_messages.deleted_from_sender','chat_messages.is_seen','chat_messages.message','chat_messages.message_type','chat_messages.created_at as chat_message_create_at')
        ->join('chat_messages', 'chat_messages.chat_id', '=', 'chats.id')
        ->join('users', 'chat_messages.resp_user_id', '=', 'users.id')
        ->where(['chats.id' => $chatId, 'chats.status' => 'Y'])
        ->first();
        $user_chat_Get_userdata = DB::table('chats')
                ->where(['chats.id' => $chatId, 'chats.status' => 'Y'])
                ->first();
        $userIdsArray = explode(',', $user_chat_Get_userdata->user_ids);
        if($userIdsArray[0] == auth()->user()->id){
            $data['user_data_1'] = DB::table('users')->where('id', $userIdsArray[1])->first();
        }else{
            $data['user_data_1'] = DB::table('users')->where('id', $userIdsArray[0])->first();
        }
        
        if($checkUserChat === null){
            $data['user_chat'] = DB::table('chats')
                ->join('users', 'users.id', '=', 'chats.user_ids')
                ->where(['chats.id' => $chatId, 'chats.status' => 'Y'])
                ->get();
        }else{
            $data['user_chat'] = DB::table('chats')
            ->select('users.*','chats.*','chat_messages.chat_id','chat_messages.chat_id','chat_messages.user_id','chat_messages.resp_user_id','chat_messages.deleted_from_receiver','chat_messages.deleted_from_sender','chat_messages.is_seen','chat_messages.message','chat_messages.message_type','chat_messages.id as chat_message_id','chat_messages.created_at as chat_message_create_at','chat_messages.user_type')
            ->join('chat_messages', 'chat_messages.chat_id', '=', 'chats.id')
            ->join('users', 'chats.user_ids', '=', 'users.id')
            ->where(['chats.id' => $chatId, 'chats.status' => 'Y'])
            ->orderBy('chat_messages.id', 'asc')
            ->get();

        }
        return response()->json($data, 200);
    }

}
