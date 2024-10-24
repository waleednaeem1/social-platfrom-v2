<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetOfTheMonthRequest extends Model
{
    use HasFactory;

    protected $table = 'pet_of_the_month_requests';

    protected $fillable = ['id', 'user_id', 'pet_id', 'approved_by_admin', 'created_at', 'updated_at'];

    public function getPet()
    {
        return $this->belongsTo(UserPets::class,'pet_id');
    }
}
