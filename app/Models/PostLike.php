<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostLike extends Model
{
    use HasFactory;
    protected $table="post_like";
    protected $fillable = [
        'post_ig_id', 
        'user_id', 
        'status',
    ];

    // Get All PostKomentar
}
