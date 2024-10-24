<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AdminPetMail;
use App\Mail\AdminPetResponse;
use App\Mail\petBadgeRequest;
use App\Models\Pet;
use App\Models\UserPets;
use App\Models\PetType;
use App\Models\PetAttachment;
use App\Models\PetsImage;
use App\Models\State;
use App\Models\Page;
use App\Models\Speaker;
use App\Models\UserProfileDetails;
use App\Models\Country;
use App\Models\PetPollingResult;
use App\Models\PetOfTheMonthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PetOfTheMonthController extends Controller
{
    public function index()
    {
        $data['pets'] = UserPets::with('petAttachments', 'getUser')->where('user_id', auth()->user()->id)->get();
        $pet_type = PetType::all();
        return view('dashboards.pet',compact('data','pet_type'));
    }

    public function petOfTheMonth()
    {
        $data['pets'] = Pet::where('status', 1)->get(array('id','pet_name','pet_age','slug','city','country','description','created_at','thumbnail','meta_title','meta_keywords','meta_description','pet_created_time'));
        foreach($data['pets'] as $pet) {
            $pet['images'] = PetsImage::where('pet_id', $pet->id)->get();
        }
        // $lastMonthStartDate = now()->subMonth()->startOfMonth();
        // $lastMonthEndDate = now()->subMonth()->endOfMonth();

        // $data['petOfTheMonthPoll'] = PetOfTheMonthRequest::with('getPet')
        // ->whereMonth('created_at', now()->subMonth()->month)
        // ->whereDay('created_at', '>=', 21)
        // ->whereDay('created_at', '<=', $lastMonthEndDate->day)
        // ->take('10')->get();
        // $data['petPollingData'] = PetPollingResult::where('user_id', Auth::user()->id)->first();
        // $data['petPollingCount'] = PetPollingResult::all();
        return view('dashboards.petOfTheMonth',compact('data'));
    }

    

    public function petDetail($id)
    {
        if(isset($id) && $id !== ''){
            $data['pet'] = UserPets::with('petAttachments')->where('id', $id)->get();
            $all_pet_types = PetType::all();
            $pet_type = PetType::find($data['pet'][0]->pet_type_id);
            if(isset($data['pet']) && count($data['pet']) > 0){
                $user = auth()->user();
                $id  = $user->id;
                $users = UserProfileDetails::where('user_id',  $id)->first();
                $slugName = $data['pet'][0]->pet_name;
                $species = $pet_type->name;
                $data['images'] = PetsImage::where('pet_id', $data['pet'][0]->id)->get();
                $data['relatedPets'] = UserPets::with('petAttachments')->where([['id', '!=', $id]])->get();
                $data['page_type']    = 'pet_detail';
                return view('pet.petdetail',compact('users', 'data','user','species', 'all_pet_types'));
            }
        }
    }

    public function sharePet(Request $request)
    {
        $notification       = 'Pet added successfully';
        $user_id = auth()->user()->id;
        if ($request->petId) {
            // Update existing pet
            $user_pets = UserPets::findOrFail($request->petId);
            $status = 'updated';
            $notification = 'Pet updated successfully';
        } else {
            // Create a new pet
            $user_pets = new UserPets();
            $status = 'added';
            $notification = 'Pet shared successfuly';
        }
        // $user_pets = new UserPets();
        $user_pets->user_id                 = $user_id;
        $user_pets->name                    = $request->name;
        $user_pets->age                     = $request->age;
        $user_pets->age_in                  = $request->age_in;
        $user_pets->slug                    = Str::slug($request->name);
        $user_pets->breed                   = $request->breed;
        $user_pets->weight                  = $request->weight;
        $user_pets->unit                    = $request->unit;
        $user_pets->gender                  = $request->gender;
        $user_pets->short_description       = $request->short_description;
        $user_pets->pet_type_id             = $request->pet_type_id;
        $user_pets->save();
        
        if (isset($request->images) && isset($_FILES['images']) && $_FILES['images']['name']) {
            foreach($_FILES['images']['name'] as $key => $file){

                $ext = explode('.', $file);
                $ext = end($ext);

                $userId = auth()->user()->id;
                $imagePath = $userId .'-'.time().'-'.rand(10000,10000000). '.' . $ext;

                $path = dirname(getcwd()) . '/public/up_data/pets-of-the-month/'.$userId.'//images/'.$imagePath; 
                $imageDir = dirname(getcwd()) .'/public/up_data/pets-of-the-month/'.$userId.'//images/';

                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }

                $uploaded = move_uploaded_file($_FILES['images']['tmp_name'][$key], $path);

                $PetAttachment = new PetAttachment();
                $PetAttachment->pet_id = $user_pets->id;
                $PetAttachment->user_id = $user_id;
                $PetAttachment->attachment_type = 'image';
                $PetAttachment->attachment = $imagePath;
                $PetAttachment->save();
            }
        }
        if (isset($request->video) && isset($_FILES['video']) && $_FILES['video']['name']) {
            $file = $_FILES['video']['name'];
            foreach($_FILES['video']['name'] as $key => $file){
               
                $ext = explode('.', $file);
                $ext = end($ext);

                $userId = auth()->user()->id;
                $vedioPath = $userId .'-'.time().'-'.rand(10000,10000000). '.' . $ext;

                $path = dirname(getcwd()) . '/public/up_data/pets-of-the-month/'.$userId.'//videos/'.$vedioPath; 
                $vedioDir = dirname(getcwd()) .'/public/up_data/pets-of-the-month/'.$userId.'//videos/';

                if(!is_dir($vedioDir))
                {
                    mkdir($vedioDir, 0777, true);
                }

                $uploaded = move_uploaded_file($_FILES['video']['tmp_name'][$key], $path);
               
                $PetAttachment = new PetAttachment();
                $PetAttachment->pet_id = $user_pets->id;
                $PetAttachment->user_id = $user_id;
                $PetAttachment->attachment_type = 'video';
                $PetAttachment->attachment = $vedioPath;
                $PetAttachment->save();
            }
        }
        return response()->json(['success' => true, 'message' => $notification, 'status' => $status], 200);
    }

    public function sharePageMets()
    {
        $page = Page::find(62);

        $data['meta_title']     = $page->meta_title;
        $data['meta_keywords']     = $page->meta_keywords;
        $data['meta_description']     = $page->meta_description;

        return response()->json($data, 200);
    }

    public function petBadgeRequest($slug){
        if(isset($slug) && $slug !== ''){
            $pet = UserPets::with('petAttachments')->where('slug', $slug)->first();
            $pet_type = PetType::find($pet->pet_type_id);
            $pet->species = $pet_type->name;
            Mail::send(new petBadgeRequest($pet, $pet->id, $pet['petAttachments']));
            return response()->json(['success' => true, 'type' => 'petBadgeRequest', 'message' => 'Badge request send successfully'], 200);
        }
    }
    public function petOfTheMonthRequest(Request $request, $id){
        $already_pet = PetOfTheMonthRequest::where(['user_id' => $request->user_id, 'pet_id' => $id])->first();
        if($already_pet){
            return back()->with('error', 'Pet of the Month Request already Sended');
        }else{
            $pet = new PetOfTheMonthRequest();
            $pet->user_id = $request->user_id;
            $pet->pet_id = $id;
            $pet->approved_by_admin = '0';
            $pet->save();
            return back()->with('success', 'Pet of the Month Request Send Successfully');
        }
    }
    public function petPolling(Request $request){
        $already_entry = PetPollingResult::where(['user_id' => $request->user_id])->first();

        if ($already_entry) {
            if ($already_entry->pet_id == $request->petofthemonth && $already_entry->user_id == $request->user_id) {
                return response()->json(['success' => false, 'message' => 'Entry Already Added.'], 200);
            } else {
                PetPollingResult::where(['user_id' => $request->user_id])->update(['pet_id' => $request->petofthemonth]);
                // UserPets::where(['id' => $request->petofthemonth])->update(['vote_count' => DB::raw('vote_count + 1')]);
                return response()->json(['success' => true, 'message' => 'Entry Updated Successfully.'], 200);
            }
        } else {
            $data = [
                'user_id' => $request->user_id,
                'pet_id' => $request->petofthemonth,
                'month' => Carbon::now()->format('F'),
                'year' => Carbon::now()->format('Y'),
            ];
            
            $petPollingEntry = PetPollingResult::create($data);
            // $petPollingEntryCountUpdate = UserPets::where('id', $request->petofthemonth)->update(['vote_count' => DB::raw('vote_count + 1')]);

            return response()->json(['success' => true, 'message' => 'Entry added successfully'], 200);
        }

    }
}