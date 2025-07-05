<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auth extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'users';
    protected $fillable = ['id', 'nama', 'username', 'email', 'password'];

    function getUserLogin($param)
    {
        $q = "
     select u.* from users u
     where u.username='$param'
     ";

        $query = DB::select($q);
        return $query;
    }
    function getRole($param)
    {
        $q = "
     select r.* from role r
     where r.id='$param'
     ";

        $query = DB::select($q);
        return $query;
    }
}
