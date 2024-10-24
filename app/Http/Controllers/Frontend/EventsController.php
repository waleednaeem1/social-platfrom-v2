<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public static function chat_setup($data)
    {
        $resp_user_id = $ses_user_id = null;
        $return_data['enable_chat'] = false;

        if(isset($data['resp_user_id']))
        {
            $resp_user_id = $data['resp_user_id'];
            $chat_user_ids[] = $resp_user_id;
        }
            
        if(isset($data['ses_user_id']))
        {
            $ses_user_id = $data['ses_user_id'];
            $chat_user_ids[] = $ses_user_id;    
        }  
        
        if(!$resp_user_id)
        {
            if($data['chat_resp'])
            {
                //$return_data['chat_resp'] = $data['chat_resp'];
                if($data['chat_sender_user_type'] == 'exhibitor')
                {
                    $resp_user_id = $data['chat_resp']->vendor->user;
                    $chat_user_ids[] = $resp_user_id;
                }   
                else 
                {
                    $resp_user_id = $data['chat_resp']->user;
                    $chat_user_ids[] = $resp_user_id;
                }
            }
        }
        else
        {
            // need to do something here...
        }
        
        if(!$ses_user_id) // means we have to determine sender / logged in user id
        {
            if(session()->get('ses_user_id') != $resp_user_id)
            {
                $return_data['enable_chat'] = true;
                    
                $ses_user_id = session()->get('ses_user_id');

                $chat_user_ids[] = $ses_user_id ;
            }

            // if(session()->has('ses_exhibitor')) 
            // {
            //     if(session()->get('ses_user_id') != $resp_user_id)
            //     {
            //         $return_data['enable_chat'] = true;
                    
            //         $ses_user_id = session()->get('ses_exhibitor')['vendor_event']->vendor->user;

            //         $chat_user_ids[] = $ses_user_id ;
            //     }
            // }
            // else 
            // {
            //     if(session()->get('ses_user_id') != $resp_user_id)
            //     {
            //         $return_data['enable_chat'] = true;
                 
            //         $ses_user_id = session()->get('ses_exhibitor')['vendor_event']->vendor->user;

            //         $chat_user_ids[] = $ses_user_id ;
            //     }
            // }           
        }     
        
        sort($chat_user_ids);

        $return_data['chat_channel']        = Chat::getHash($chat_user_ids);
        $return_data['chat_user_ids']       = $chat_user_ids;

        $return_data['chat_resp']           = User::find($resp_user_id);
        $return_data['chat_sender']         = User::find($ses_user_id);

        $return_data['chat_resp_user_id']   = $resp_user_id;
        $return_data['chat_sender_user_id'] = $ses_user_id;

        $chat = Chat::where('channel', $return_data['chat_channel'])->first();
        if($chat)
        {
            $return_data['chat_id'] = $chat->id;
        }

        if(isset($data['start_chat']) && !isset($return_data['chat_id']))
        {
            $chat_data = ['channel' => $return_data['chat_channel'], 'user_ids' => implode(',', $chat_user_ids)];
            $chat = Chat::create($chat_data);
            $return_data['chat_id'] = $chat->id;
        }

        return $return_data;
    }
}
