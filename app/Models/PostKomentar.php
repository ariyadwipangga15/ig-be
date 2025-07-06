<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostKomentar extends Model
{
    use HasFactory;
    protected $table="post_komentar";
    protected $fillable = [
        'post_ig_id', 
        'komentar', 
        'status',
        'nama_user',
    ];

    // Get All PostKomentar
    function getAllPostKomentar($idPostIg){
        $sql = "SELECT p.* FROM post_komentar p WHERE p.status = true";

        if (!empty($idPostIg)) {
            $sql .= " AND p.post_ig_id = ?";
            return DB::select($sql, [$idPostIg]);
        }

    return DB::select($sql);
    }
}
