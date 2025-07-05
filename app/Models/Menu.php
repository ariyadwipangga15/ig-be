<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'menu';

    protected $fillable = ['id', 'nama_menu', 'link_menu', 'keterangan', 'status', 'class_icon','app','is_deleted','created_at', 'updated_at'];
    // Transaksi
   function ResolveMenuByRoleID ($filter)
   {
    $idRole = $filter['idRole'];
    $App = $filter['app'];
    $Posisi = $filter['posisi'];
    $Level = $filter['level'];
    $LinkParent = $filter['linkParent'];
     $q ="
     SELECT mu.id as id, m.id as id_menu, m.nama_menu, m.link_menu, m.keterangan, m.class_icon, m.is_permission, mu.level, mu.urutan, mu.posisi, m.app, m2.link_menu link_parent,
            (CASE WHEN mu.posisi='1' THEN 'SIDEBAR'
                WHEN mu.posisi='2' THEN 'CARD MENU'
                WHEN mu.posisi='3' THEN 'DETAIL MENU'
                ELSE '' END) AS ket_posisi
            FROM menu_user mu
            JOIN menu m on mu.id_menu = m.id
            LEFT JOIN menu m2 on mu.parent = m2.id
            WHERE m.status = '1' and mu.id_role = '$idRole' and coalesce(mu.is_deleted, false)= false
     ";

     if($App!=""){
        $q .= " AND m.app = '$App' ";
    }

    if($Posisi!=""){
        $q .= " AND mu.posisi= '$Posisi' ";
    }

    if($Level!=""){
        $q .= " AND mu.level= '$Level' ";
    }

    if($LinkParent!=""){
        $q .= " AND m2.link_menu= '$LinkParent' ";
    }

    $q .= " order by mu.urutan asc ";


     $query = DB::select($q);
     return $query;
 }
   function ResolveMenuByParentID ($filter,$idMenu)
   {
    $idRole = $filter['idRole'];
    $App = $filter['app'];
    $PosisiSubMenu = $filter['posisiSubMenu'];

     $q ="
     SELECT mu.id as id, m.id as id_menu, m.nama_menu, m.link_menu, m.keterangan, m.class_icon, m.is_permission, mu.level, mu.urutan, mu.posisi, m.app, m2.link_menu link_parent,
            (CASE WHEN mu.posisi='1' THEN 'SIDEBAR'
                WHEN mu.posisi='2' THEN 'CARD MENU'
                WHEN mu.posisi='3' THEN 'DETAIL MENU'
                ELSE '' END) AS ket_posisi
            FROM menu_user mu
            JOIN menu m on mu.id_menu = m.id
            LEFT JOIN menu m2 on mu.parent = m2.id
            WHERE m.status='1' and mu.level = 2 and mu.id_role = '$idRole' and mu.parent = '$idMenu' and coalesce(mu.is_deleted,false) = false
     ";

     if($App!=""){
        $q .= " AND m.app = '$App' ";
    }

    if($PosisiSubMenu!=""){
        $q .= " AND mu.posisi= '$PosisiSubMenu' ";
    }


    $q .= " order by mu.urutan asc ";


     $query = DB::select($q);
     return $query;
 }
//  Master
function columnMap()
    {
        $data = [
            'id' => 'id',
            'nama_menu' => 'nama_menu',
            'link_menu' => 'link_menu',
            'keterangan' => 'keterangan',
            'class_icon' => 'class_icon',
            'app' => 'app'
        ];
        return $data;
    }

    function getCountMenu($filter)
    {
        $key = $filter['q'];
        $app = $filter['app'];

        $q = "
            SELECT count(*) as jml from menu
            WHERE CONCAT(nama_menu, link_menu, keterangan, class_icon, status, app) LIKE '%$key%'
            and is_deleted=false
        ";
        if($app!=""){
            $q .= " and app = '$app' ";
        }

        $query = DB::select($q);
        return $query[0]->jml;
    }

    function getListMenu($filter)
    {
        $key = $filter['q'];
        $page = $filter['page'];
        $app = $filter['app'];
        $limit = $filter['limit'];
        $sortBy = $filter['sortBy'];
        $sortType = $filter['sortType'];
        $offset = $limit * $page - $limit;

        $q = "
        SELECT id, nama_menu, link_menu, keterangan, class_icon, status, created_at, updated_at, is_permission,coalesce(is_deleted, false) as is_deleted,
        app from menu
        WHERE CONCAT(nama_menu, link_menu, keterangan, class_icon, status, app) LIKE '%$key%'
        and is_deleted=false
        ";

        if($app!=""){
            $q .= " and app = '$app' ";
        }

        $q .= "
        order by $sortBy $sortType
        limit $limit offset $offset
     ";

        $query = DB::select($q);
        return $query;
    }
    function getAllMenu($filter)
    {
        $app = $filter['app'];
        $q = "
        SELECT id, nama_menu, link_menu, keterangan, class_icon, status, created_at, updated_at, is_permission,coalesce(is_deleted, false) as is_deleted,
        app from menu
        WHERE is_deleted=false
        ";
        if($app!=""){
            $q .= " and app = '$app' ";
        }
        $query = DB::select($q);
        return $query;
    }
    function getAllMenuId($id)
    {
        $q = "
        SELECT id, nama_menu, link_menu, keterangan, class_icon, status, created_at, updated_at, is_permission,coalesce(is_deleted, false) as is_deleted,
        app from menu
        WHERE is_deleted=false
        and id = '$id'
        ";
        $query = DB::select($q);
        return $query;
    }
}
