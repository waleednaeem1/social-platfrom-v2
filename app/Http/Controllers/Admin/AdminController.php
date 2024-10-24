<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\Appointment;
use App\Models\Assistant;
use App\Models\Department;
use App\Models\Deposit;
use App\Models\Doctor;
use App\Models\Group;
use App\Models\Location;
use App\Models\Page;
use App\Models\GeneralSetting;
use App\Models\Staff;
use App\Models\Subscriber;
use App\Models\SupportTicket;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        // $general = GeneralSetting::first();

        // $widget['total_departments']       = Department::count();
        // $widget['total_groups']       = Group::count();
        // $widget['total_pages']       = Page::count();
        // $widget['total_subscribers']         = Subscriber::count();
        // $widget['total_users']         = User::count();

        $widget['total_departments']       = 0;
        $widget['total_groups']       = 0;
        $widget['total_pages']       = 0;
        $widget['total_subscribers']         = 0;
        $widget['total_users']         = User::count();
        // $widget['total_new_appointments']  = Appointment::newAppointment()->count();
        // $widget['total_done_appointments'] = Appointment::completeAppointment()->count();

        // $widget['total_doctors']    = Doctor::count();
        // $widget['total_staff']      = Staff::count();
        // $widget['total_assistants'] = Assistant::count();
        // $widget['total_pending_support_tickets'] = SupportTicket::whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count();

        // $widget['total_locations']         = 0;
        // $widget['total_new_appointments']  = 0;
        // $widget['total_done_appointments'] = 0;

        $widget['total_doctors']    = 0;
        $widget['total_staff']      = 0;
        $widget['total_assistants'] = 0;
        $widget['total_pending_support_tickets'] = 0;

        // $deposit['total_deposit_amount']   = Deposit::successful()->sum('amount');
        // $deposit['total_deposit_pending']  = Deposit::pending()->count();
        // $deposit['total_deposit_rejected'] = Deposit::rejected()->count();
        // $deposit['total_deposit_charge']   = Deposit::successful()->sum('charge');

        $deposit['total_deposit_amount']   = 0;
        $deposit['total_deposit_pending']  = 0;
        $deposit['total_deposit_rejected'] = 0;
        $deposit['total_deposit_charge']   = 0;

        // $appointment['date'] = collect([]);

        // $appointmentCount = Appointment::where('try', Status::YES)->where('booking_date', '>=', Carbon::now()->subDays(30))
        //     ->selectRaw("SUM(try) as appointmentTry, DATE_FORMAT(booking_date,'%Y-%m-%d') as date")
        //     ->orderBy('created_at')
        //     ->groupBy('date')
        //     ->get();

        // $appointmentCount->map(function ($appointmentData) use ($appointment) {
        //     $appointment['date']->push($appointmentData->date);
        // });

        // $appointment['date'] = dateSorting($appointment['date']->unique()->toArray());
        // $appointmentChart = [];
        // foreach ($appointment['date'] as $bookingDate) {
        //     $appointmentChart[] =   @$appointmentCount->where('date', $bookingDate)->first()->appointmentTry ?? 0;
        // }

        // // Monthly Deposit Report Graph
        // $report['months'] = collect([]);
        // $report['deposit_month_amount'] = collect([]);

        // $depositsMonth = Deposit::where('created_at', '>=', Carbon::now()->subYear())
        //     ->where('status', Status::PAYMENT_SUCCESS)
        //     ->selectRaw("SUM( CASE WHEN status = " . Status::PAYMENT_SUCCESS . " THEN amount END) as depositAmount")
        //     ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
        //     ->orderBy('created_at')
        //     ->groupBy('months')->get();

        // $depositsMonth->map(function ($depositData) use ($report) {
        //     $report['months']->push($depositData->months);
        //     $report['deposit_month_amount']->push(getAmount($depositData->depositAmount));
        // });

        // $months = $report['months'];

        // for ($i = 0; $i < $months->count(); ++$i) {
        //     $monthVal      = Carbon::parse($months[$i]);
        //     if (isset($months[$i + 1])) {
        //         $monthValNext = Carbon::parse($months[$i + 1]);
        //         if ($monthValNext < $monthVal) {
        //             $temp = $months[$i];
        //             $months[$i]   = Carbon::parse($months[$i + 1])->format('F-Y');
        //             $months[$i + 1] = Carbon::parse($temp)->format('F-Y');
        //         } else {
        //             $months[$i]   = Carbon::parse($months[$i])->format('F-Y');
        //         }
        //     }
        // }
        // return view('admin.dashboard', compact('pageTitle', 'widget', 'deposit', 'report', 'depositsMonth', 'months', 'appointment', 'appointmentCount','appointmentChart'));
        // return view('admin.dashboard', compact('pageTitle', 'widget', 'deposit', 'user','general'));
        return view('admin.dashboard', compact('pageTitle', 'widget', 'deposit', 'user'));
    }

    public function profile()
    {
        $pageTitle = 'Profile';
        // $admin = auth('admin')->user();
        $admin = auth()->user();

        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        // $user = auth('admin')->user();
        $user = auth()->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->avatar_location = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $pageTitle = 'Password Setting';
        // $admin = auth('admin')->user();
        $admin = auth()->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    // public function notifications()
    // {
    //     $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
    //     $pageTitle = 'Notifications';
    //     return view('admin.notifications', compact('pageTitle', 'notifications'));
    // }


    // public function notificationRead($id)
    // {
    //     $notification = AdminNotification::findOrFail($id);
    //     $notification->is_read = Status::YES;
    //     $notification->save();
    //     $url = $notification->click_url;
    //     if ($url == '#') {
    //         $url = url()->previous();
    //     }
    //     return redirect($url);
    // }

    // public function requestReport()
    // {
    //     $pageTitle = 'Your Listed Report & Request';
    //     $arr['app_name'] = systemDetails()['name'];
    //     $arr['app_url'] = env('APP_URL');
    //     $arr['purchase_code'] = env('PURCHASE_CODE');
    //     $url = "https://license.viserlab.com/issue/get?" . http_build_query($arr);
    //     $response = CurlRequest::curlContent($url);
    //     $response = json_decode($response);
    //     if ($response->status == 'error') {
    //         return to_route('admin.dashboard')->withErrors($response->message);
    //     }
    //     $reports = $response->message[0];
    //     return view('admin.reports', compact('reports', 'pageTitle'));
    // }

    // public function reportSubmit(Request $request)
    // {
    //     $request->validate([
    //         'type' => 'required|in:bug,feature',
    //         'message' => 'required',
    //     ]);
    //     $url = 'https://license.viserlab.com/issue/add';

    //     $arr['app_name'] = systemDetails()['name'];
    //     $arr['app_url'] = env('APP_URL');
    //     $arr['purchase_code'] = env('PURCHASE_CODE');
    //     $arr['req_type'] = $request->type;
    //     $arr['message'] = $request->message;
    //     $response = CurlRequest::curlPostContent($url, $arr);
    //     $response = json_decode($response);
    //     if ($response->status == 'error') {
    //         return back()->withErrors($response->message);
    //     }
    //     $notify[] = ['success', $response->message];
    //     return back()->withNotify($notify);
    // }

    // public function readAll()
    // {
    //     AdminNotification::where('is_read', Status::NO)->update([
    //         'is_read' => Status::YES
    //     ]);
    //     $notify[] = ['success', 'Notifications read successfully'];
    //     return back()->withNotify($notify);
    // }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}
