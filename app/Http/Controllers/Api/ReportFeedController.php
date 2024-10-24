<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Feed;
use App\Models\FeedReport;
use App\Models\FeedReportType;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;

class ReportFeedController extends Controller
{
    public function reportUserFeed(Request $request){
        $reportingUser = Customer::find($request->reported_user_id);
        if(!$reportingUser){
            return response()->json(['success' => false, 'message'=> 'Reporting user does not exists'],201);
        }
        $feedUser = Customer::find($request->feed_user_id);
        if(!$feedUser){
            return response()->json(['success' => false, 'message'=> 'Feed user does not exists'],201);
        }
        $feed = Feed::find($request->feed_id);
        if(!$feed){
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }

        $data = $request->all();

        //check for already existing report against feed with given user
        $check = FeedReport::where(['feed_id' => $data['feed_id'], 'reported_user_id' => $data['reported_user_id'], 'feed_user_id' => $data['feed_user_id'] ])->first();
        if($check){
            return response()->json(['success' => false, 'message'=> 'Feed already reported'],201);
        }else{
            $reportData = FeedReport::create($data);
            $feed = Feed::find($data['feed_id']);
            $feed->report_count = $feed->report_count+ 1;
            if($feed->report_count > 5){
                $feed->status = 'N';
                $feed->blocked = 'Y';
                $feed->is_deleted = 1;
            }
            $feed->save(); 
            $reportType = FeedReportType::find($data['feed_reported_type_id']);
            $reportingUser = User::find($data['reported_user_id']);
            //creating notiifcation against feed user for feed report
            if($feed->user_id != $reportingUser->id){
                $notificationMessage =' reported your post as '. $reportType->feed_report;
                Notifications::sendFeedReportNotification($feed->user_id, $reportingUser->id, $feed->id, 'feed-report/'.$feed->user_id.'/'.$reportingUser->id.'/'.$feed->id, 'User Feed Report', 'feed_report', $notificationMessage);
            }
            return response()->json(['data'=> $reportData, 'feedReportCounts' =>$feed->report_count  ,'success' => true, 'message'=> 'Feed reported successfully'],200);
        }
    }

    public function reportTypes(){
        $types = FeedReportType::all();
        return response()->json(['reportTypes'=> $types ,'success' => true],200);
    }
}
