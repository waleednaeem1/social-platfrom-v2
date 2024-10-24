<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetPollingResult extends Model
{
    use HasFactory;

    protected $table = 'pet_polling_results';
    protected $fillable = [ 'id', 'user_id', 'pet_id', 'month', 'year', 'vote_count', 'result', 'created_at', 'updated_at'];
}
