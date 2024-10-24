<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\Contact\SendContact;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function userContactSupport(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required|max:13',
            'message' => 'required',
        ]);
        
        if ($validator->fails()) {
            $error = $validator->messages()->toArray();
            return response()->json(['message' => $error,'success' =>false], 201);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'message' => $request->message,
        ];
        
        Contact::create($data);

        try {
            Mail::send(new SendContact($request));
        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage(),'success' =>false], 201);
        }
        return response()->json(['success' =>true, 'message' => 'Message sent successfully.'],200);
    }
}
