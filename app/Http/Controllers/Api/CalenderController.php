<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CalenderEvents;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function calender($user_id,$date)
    {
        // $date = date('y-m-d');
        // $tomorrowDate = Carbon::createFromFormat('y-m-d', $date)->addDay()->format('y-m-d');
        $data = CalenderEvents::where(['user_id' =>  $user_id, 'event_date' => $date])->get();
        
        return response()->json(['success' => true, 'calender_events'=> $data] ,200);
    }

    public function addEvent(Request $request)
    {
        $data = [
            'id' =>  $request->id,
            'user_id' => $request->user_id,
            'event_name' => $request->event_name,
            'address' => $request->address,
            'description' => $request->description,
            'event_start_time' => $request->event_start_time,
            'other_requirements' => $request->other_requirements,
            'event_date' => $request->event_date,
            'status' => 'Y',
        ];
        if(isset($request->id) && $request->id != ''){
            $eventData = CalenderEvents::where('id', $request->id)->update($data);
            return response()->json(['success' => true,'check' => 'update','message' => 'Event updated successfully', 'eventData' => $eventData], 200);
        }else{
            $eventData = CalenderEvents::create($data);
            return response()->json(['success' => true,'check' => 'add','message' => 'Event added successfully',  'eventData' => $eventData], 200);
        }
        // return redirect()->route('calender');
    }

    public function deleteScheduleEvent($id){
        $eventData = CalenderEvents::find($id);
        if($eventData){
            $user_id = $eventData->user_id;
            $eventData->delete();
            $date = date('y-m-d');
            $tomorrowDate = Carbon::createFromFormat('y-m-d', $date)->addDay()->format('y-m-d');
            $data['today_schedule'] = CalenderEvents::where(['user_id' =>  $user_id, 'event_date' => $date])->get();
            $data['tomorrow_schedule'] = CalenderEvents::where(['user_id' =>  $user_id, 'event_date' => $tomorrowDate])->get();
            return response()->json(['success' => true,'message' => 'Event deleted successfully.', 'calender_events'=> $data], 200);
        }else{
            return response()->json(['success' => false,'message' => 'Event not found.'], 201);
        }
    }


}
