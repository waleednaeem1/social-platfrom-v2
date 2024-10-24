<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    use HasFactory;

    protected $hidden = [ 'created_at', 'updated_at' ];
    
    public function education_level($id)
    {
        $education_level = self::select('name')
            ->where('id', $id)
            ->first();
        return $education_level['name'];
    }
}
