<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AdminPetMail;
use App\Mail\AdminPetResponse;
use App\Mail\petBadgeRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\UserPets;
use App\Models\PetType;
use App\Models\PetAttachment;
use App\Models\PetsImage;
use App\Models\State;
use App\Models\Page;
use App\Models\Speaker;
use App\Models\UserProfileDetails;
use App\Models\Country;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class PetOfTheMonthController extends Controller
{
    public function index($userId)
    {
        $data['pets'] = UserPets::with('petAttachments')->where('user_id', $userId)->get();
        $data['petType'] = PetType::all();

        foreach($data['pets'] as $pets){
            foreach($pets['petAttachments'] as $petAttachments){
                if($petAttachments->attachment_type == 'image'){
                    $petAttachments->image_url = 'https://www.vtfriends.com/up_data/pets-of-the-month/'.$userId.'//images/';
                }elseif($petAttachments->attachment_type == 'video'){
                    $petAttachments->vedio_url = 'https://www.vtfriends.com/up_data/pets-of-the-month/'.$userId.'//videos/';
                }
            }
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function petOfTheMonthdata()
    {
        $data['pets'] = Pet::where('status', 1)->get(array('id','pet_name','pet_age','slug','city','country','description','created_at','thumbnail','meta_title','meta_keywords','meta_description','pet_created_time'));
        foreach($data['pets'] as $pet) {
            $pet['images'] = PetsImage::where('pet_id', $pet->id)->get();
        }

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function petDetail($slug)
    {
        if(isset($slug) && $slug !== ''){
            $data['pet'] = UserPets::with('petAttachments')->where('slug', $slug)->first();
            $pet_type = PetType::find($data['pet']->pet_type_id);
            $data['pet']->species = $pet_type->name;

            foreach($data['pet']['petAttachments'] as $petAttachments){
                if($petAttachments->attachment_type == 'image'){
                    $petAttachments->image_url = 'https://www.vtfriends.com/up_data/pets-of-the-month/'.$data['pet']->user_id.'//images/';
                }elseif($petAttachments->attachment_type == 'video'){
                    $petAttachments->vedio_url = 'https://www.vtfriends.com/up_data/pets-of-the-month/'.$data['pet']->user_id.'//videos/';
                }
            }

            return response()->json(['success' => true, 'data' => $data], 200);
        }
    }

    public function addPet(Request $request)
    {
        $notification       = 'Pet added successfully';
        $user_id = $request->user_id;
        $user_pets = new UserPets();
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

        $UserPets = UserPets::find($user_pets->id);
        $UserPets->update(['slug' => Str::slug($user_pets->id.'-'.$request->name)]);
        if ($request->hasFile('attachment_1')) {
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^attachment_\d+$/', $key) && $request->hasFile($key)) {
                    try
                    {
                        $file = $request->file($key);
                        $ext = $file->getClientOriginalExtension();
                        $videoType = ['mp4', 'mov', 'wmv', 'avi', 'mkv', 'flv', 'webm'];

                        if (in_array($ext, $videoType)) {
                            $attachment_type = 'video';
                        }else{
                            $attachment_type = 'image';
                        }

                        if($attachment_type == 'image'){
                            $imagePath = $user_id .'-'.time().'-'.rand(10000,10000000). '.' . $ext;

                            $path = dirname(getcwd()) . '/public/up_data/pets-of-the-month/'.$user_id.'//images/'.$imagePath;
                            $imageDir = dirname(getcwd()) .'/public/up_data/pets-of-the-month/'.$user_id.'//images/';

                            if(!is_dir($imageDir))
                            {
                                mkdir($imageDir, 0777, true);
                            }

                            $uploaded = move_uploaded_file($_FILES[$key]['tmp_name'], $path);

                            $PetAttachment = new PetAttachment();
                            $PetAttachment->pet_id = $user_pets->id;
                            $PetAttachment->user_id = $user_id;
                            $PetAttachment->attachment_type = 'image';
                            $PetAttachment->attachment = $imagePath;
                            $PetAttachment->save();
                        }
                        elseif($attachment_type == 'video'){

                            $vedioPath = $user_id .'-'.time().'-'.rand(10000,10000000). '.' . $ext;

                            $path = dirname(getcwd()) . '/public/up_data/pets-of-the-month/'.$user_id.'//videos/'.$vedioPath;
                            $vedioDir = dirname(getcwd()) .'/public/up_data/pets-of-the-month/'.$user_id.'//videos/';

                            if(!is_dir($vedioDir))
                            {
                                mkdir($vedioDir, 0777, true);
                            }

                            $uploaded = move_uploaded_file($_FILES[$key]['tmp_name'], $path);

                            $PetAttachment = new PetAttachment();
                            $PetAttachment->pet_id = $user_pets->id;
                            $PetAttachment->user_id = $user_id;
                            $PetAttachment->attachment_type = 'video';
                            $PetAttachment->attachment = $vedioPath;
                            $PetAttachment->save();
                        }

                    }
                    catch (\Exception $exp)
                    {
                        $notify[] = ['error', 'Couldn\'t Previous Recored'];
                        return response()->json(['message' => ' Not Previous Record '], 301);
                    }
                }
            }
        }

        // if (isset($_FILES['images']) && $_FILES['images']['name']) {
        //     foreach($_FILES['images']['name'] as $key => $file){

        //         $ext = explode('.', $file);
        //         $ext = end($ext);

        //         $userId = auth()->user()->id;
        //         $imagePath = $userId .'-'.time().'-'.rand(10000,10000000). '.' . $ext;

        //         $path = dirname(getcwd()) . '/public/up_data/pets-of-the-month/'.$userId.'//images/'.$imagePath;
        //         $imageDir = dirname(getcwd()) .'/public/up_data/pets-of-the-month/'.$userId.'//images/';

        //         if(!is_dir($imageDir))
        //         {
        //             mkdir($imageDir, 0777, true);
        //         }

        //         $uploaded = move_uploaded_file($_FILES['images']['tmp_name'][$key], $path);

        //         $PetAttachment = new PetAttachment();
        //         $PetAttachment->pet_id = $user_pets->id;
        //         $PetAttachment->user_id = $user_id;
        //         $PetAttachment->attachment_type = 'image';
        //         $PetAttachment->attachment = $imagePath;
        //         $PetAttachment->save();
        //     }
        // }
        // $file = $_FILES['video']['name'];
        // if (isset($_FILES['video']) && $_FILES['video']['name']) {

        //     foreach($_FILES['video']['name'] as $key => $file){

        //         $ext = explode('.', $file);
        //         $ext = end($ext);

        //         $userId = auth()->user()->id;
        //         $vedioPath = $userId .'-'.time().'-'.rand(10000,10000000). '.' . $ext;

        //         $path = dirname(getcwd()) . '/public/up_data/pets-of-the-month/'.$userId.'//videos/'.$vedioPath;
        //         $vedioDir = dirname(getcwd()) .'/public/up_data/pets-of-the-month/'.$userId.'//videos/';

        //         if(!is_dir($vedioDir))
        //         {
        //             mkdir($vedioDir, 0777, true);
        //         }

        //         $uploaded = move_uploaded_file($_FILES['video']['tmp_name'][$key], $path);

        //         $PetAttachment = new PetAttachment();
        //         $PetAttachment->pet_id = $user_pets->id;
        //         $PetAttachment->user_id = $user_id;
        //         $PetAttachment->attachment_type = 'video';
        //         $PetAttachment->attachment = $vedioPath;
        //         $PetAttachment->save();
        //     }
        // }

        return response()->json(['success' => true, 'message' => 'Pet shared successfuly'], 200);
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

    public function deleteMyPet($id){
        UserPets::find($id)->delete();
        return response()->json(['success' => true, 'message' => 'Pet deleted successfuly'], 200);
    }

    public function updatePet(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pet_id' => 'required|exists:user_pets,id',
            'pet_name' => 'required|string|max:255',
            'age' => 'required',
            'age_in' => 'required|in:month,year',
            'user_id' => 'required|exists:users,id',
            'pet_type_id' => 'required|exists:pet_type,id',
            'weight' => 'required',
            'unit' => 'required|in:lbs,kg',
            'gender' => 'required|in:male,female',
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'error' => $validator->messages()], 201);
        }
        $user_pets = UserPets::findOrFail($request->pet_id);
        $user_id = $request->user_id;
        $user_pets->user_id                 = $user_id;
        $user_pets->name                    = $request->pet_name;
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

        return response()->json(['success' => true, 'message' => 'Pet updated successfuly'], 200);
    }
}
