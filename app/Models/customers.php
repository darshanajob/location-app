<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class customers extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone_number',
        'address',
        'user_id',
        
        //'profile_photo',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

}
