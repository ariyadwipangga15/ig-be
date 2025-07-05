<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{

    use HasFactory;
    public $incrementing = false;
    protected $table = 'role';

    protected $fillable = ['id', 'nama', 'keterangan', 'is_view_data_all', 'is_choose_pegawai', 'is_choose_terbatas', 'status', 'created_at', 'updated_at'];


    //  Master
    function columnMap()
    {
        $data = [
            'id' => 'id',
            'nama' => 'nama',
            'keterangan' => 'keterangan',
            'is_view_data_all' => 'is_view_data_all',
            'is_choose_pegawai' => 'is_choose_pegawai',
            'is_choose_terbatas' => 'is_choose_terbatas',
            'status' => 'status'
        ];
        return $data;
    }

    function getCountRole($filter)
    {
        $key = $filter['q'];

        $q = "
            SELECT count(*) as jml from role
            WHERE CONCAT(nama, keterangan) LIKE '%$key%'
            and status='1'
        ";
        $query = DB::select($q);
        return $query[0]->jml;
    }

    function getListRole($filter)
    {
        $key = $filter['q'];
        $page = $filter['page'];
        $limit = $filter['limit'];
        $sortBy = $filter['sortBy'];
        $sortType = $filter['sortType'];
        $offset = $limit * $page - $limit;

        $q = "
        SELECT id, nama, keterangan, is_view_data_all, is_choose_pegawai, is_choose_terbatas, status
        from role
        WHERE CONCAT(nama , keterangan) LIKE '%$key%'
        and status = '1'
        ";

        $q .= "
        order by $sortBy $sortType
        limit $limit offset $offset
    ";

        $query = DB::select($q);
        return $query;
    }
    function getAllRoleId($id)
    {
        $q = "
        SELECT id, nama, keterangan, is_view_data_all, is_choose_pegawai, is_choose_terbatas, status
        from role
        where id = '$id'
        and status ='1'
        ";
        $query = DB::select($q);
        return $query;
    }
    function getAll()
    {
        $q = "
        SELECT id, nama, keterangan, is_view_data_all, is_choose_pegawai, is_choose_terbatas, status
         from role
         where status ='1'
        ";
        $query = DB::select($q);
        return $query;
    }
}
