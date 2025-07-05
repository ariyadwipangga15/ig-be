<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $table = 'users';
    protected $fillable = [
        'id',
        'nama',
        'username',
        'email',
        'password',
        'status',
        'role',
        'id_gudang',
        'path_ttd',
        'created_at',
        'updated_at',
        'is_deleted',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
     //  Master
     function columnMap()
     {
         $data = [
             'id' => 'id',
             'nama' => 'nama',
             'username' => 'username',
             'email' => 'email',
             'password' => 'password',
             'status' => 'status',
             'role' => 'role',
             'created_at' => 'created_at',
             'updated_at' => 'updated_at',
             'is_deleted' => 'is_deleted',
         ];
         return $data;
     }

     function getCountUser($filter)
     {
         $key = $filter['q'];
         $role = $filter['role'];

         $q = "
             SELECT count(*) as jml from users u
             join role r on r.id = u.role
             WHERE CONCAT(u.nama, u.username, u.email, r.nama) LIKE '%$key%'
             and u.is_deleted=false
         ";
         if($role!=""){
            $q .= " and u.role = '$role' ";
        }
         $query = DB::select($q);
         return $query[0]->jml;
     }

     function getListUser($filter)
     {
         $key = $filter['q'];
         $page = $filter['page'];
         $limit = $filter['limit'];
         $sortBy = $filter['sortBy'];
         $sortType = $filter['sortType'];
         $role = $filter['role'];
         $offset = $limit * $page - $limit;

         $q = "
         SELECT u.id, u.nama, u.username, u.email,  u.status, u.role, u.created_at, u.updated_at, u.is_deleted,
         r.nama nama_role, u.id_gudang,  u.path_ttd
	     FROM users u
         join role r on r.id = u.role
         WHERE CONCAT(r.nama , u.nama, u.username, u.email) LIKE '%$key%'
         and u.is_deleted = false
         ";

         if($role!=""){
            $q .= " and u.role = '$role' ";
        }

         $q .= "
         order by $sortBy $sortType
         limit $limit offset $offset
     ";

         $query = DB::select($q);
         return $query;
     }
     function getAllUserId($id)
     {
         $q = "
         SELECT id, nama, username, email,  status, role, id_gudang, path_ttd, created_at, updated_at, is_deleted
            FROM users
            where id = '$id'
            and is_deleted = false
         ";
         $query = DB::select($q);
         return $query;
     }
     function getAll()
     {
         $q = "
         SELECT u.id, u.nama, u.username, u.email,  u.status, u.role, u.id_gudang,  u.created_at, u.updated_at, u.is_deleted
	       FROM users u
           WHERE u.is_deleted = false
         ";
         $query = DB::select($q);
         return $query;
     }
     function getAllUserGudang($filter)
     {
        $id_gudang = $filter['id_gudang'];
         $q = "
         SELECT u.id, u.nama, u.username, u.email,  u.status, u.role, u.id_gudang,   u.created_at, u.updated_at, u.is_deleted
	       FROM users u
           WHERE u.is_deleted = false
         ";
         if ($id_gudang != '') {
            $q .= " and id_gudang = '$id_gudang' ";
        }
         $query = DB::select($q);
         return $query;
     }
}
