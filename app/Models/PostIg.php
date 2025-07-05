<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostIg extends Model
{
    use HasFactory;
    protected $table="post_ig";
    protected $fillable = [
        'judul', 
        'deskripsi', 
        'path_image', 
        'status',
        'is_post',
        'is_like',
        'is_komentar',
    ];

    /**
     * Function Pagination
     * getCountPostIg()
     * getListPostIg()
     * 
     */
    function columnMap(){
        $data = array(
            'judul' => 'p.judul',
            'deskripsi' => 'p.deskripsi',
        );
        return $data;
    }

    function getCountPostIg($filter){
        $key = $filter['q'];
        
        $q = "
            SELECT count(*) as jml from post_ig p
            WHERE CONCAT(p.judul, p.deskripsi) LIKE '%$key%' 
            AND p.status = true
        ";
        $query = DB::select($q);
        return $query[0]->jml;
    }

    function getListPostIg($filter){
        $key = $filter['q'];
        $page = $filter['page'];
        $limit = $filter['limit'];
        $sortBy = $filter['sortby'];
        $sortType = $filter['sorttype'];
        $offset = ($limit * $page) - $limit;

        $q = "
            SELECT p.* from post_ig p
            WHERE CONCAT(p.judul, p.deskripsi) LIKE '%$key%' 
            AND p.status = true
        ";

      

        $q .= "
            order by $sortBy $sortType
            limit $limit offset $offset
        ";

        $query = DB::select($q);
        return $query;
    }

    // Get All PostIg
    function getAllPostIg(){
        $q = DB::select("
            SELECT p.* from post_ig p
            WHERE p.status = true
        ");
        return $q;
    }

    function getByID($id){
        $q = DB::table('post_ig as p')
                ->select('p.*')
                ->where([
                    'p.id' => $id,
                    'p.status' => 'true' 
                ]);
        return $q;
    }
}
