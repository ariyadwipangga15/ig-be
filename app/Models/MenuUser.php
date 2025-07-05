<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuUser extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'menu_user';

    protected $fillable = ['id', 'id_menu', 'posisi', 'level', 'urutan', 'status', 'created_at', 'updated_at', 'parent', 'id_role', 'is_deleted'];

    function cekMenuUser($filter,$id_menu)
    {
        $posisi = $filter['posisi'];
        $level = $filter['level'];
        $id_role = $filter['id_role'];
        $parent = $filter['parent'];
        $q = "
        select count(*) as jml from menu_user mu
        where mu.id_menu = '$id_menu' and mu.posisi = '$posisi' and mu.level = $level and mu.status = '1' and   mu.id_role = '$id_role' and mu.is_deleted=false
        ";
        if($level!="" && $level != 1){
            $q .= " and mu.parent = '$parent' ";
        }
        $query = DB::select($q);
        return $query[0]->jml;
    }
    function cekMenuUrutan($filter)
    {
        $posisi = $filter['posisi'];
        $level = $filter['level'];
        $id_role = $filter['id_role'];
        $parent = $filter['parent'];
        $q = "
        select coalesce(max(urutan),0) + 1 as urutan_selanjutnya from menu_user mu
        where mu.posisi = '$posisi' and mu.level = $level and mu.status = '1' and mu.id_role = '$id_role' and mu.is_deleted=false
        ";
        if($level!="" && $level != 1){
            $q .= " and mu.parent = '$parent' ";
        }
        $query = DB::select($q);
        return $query[0]->urutan_selanjutnya;
    }
    function cekMenuUp($id)
    {
        $q = "
        select * from menu_user mu
        where mu.id = '$id'
        ";
        $query = DB::select($q);
        return $query[0];
    }
    function upMenu($filter)
    {
        $id_menu_dipilih = $filter['id_menu_dipilih'];
        $posisi_dipilih = $filter['posisi_dipilih'];
        $level_dipilih = $filter['level_dipilih'];
        $urutan_dipilih = $filter['urutan_dipilih'];
        $parent_dipilih = $filter['parent_dipilih'];
        $id_role_dipilih = $filter['id_role_dipilih'];
        $urutan_sebelumnya = $filter['urutan_sebelumnya'];

        $filter_parent = false;
        if($parent_dipilih!='' && $parent_dipilih != null){
          $filter_parent = true;
        }

        $q = "
        update menu_user mu
        set urutan = $urutan_dipilih
        where
          mu.posisi = '$posisi_dipilih'
          and mu.level = $level_dipilih
          and mu.urutan = $urutan_sebelumnya
          and mu.id_role = '$id_role_dipilih'
        ";
        if($filter_parent == true){
            $q .= " and mu.parent = '$parent_dipilih' ";
          }
        $query = DB::select($q);
        return $query;
    }
    function downMenu($filter)
    {
        $id_menu_dipilih = $filter['id_menu_dipilih'];
        $posisi_dipilih = $filter['posisi_dipilih'];
        $level_dipilih = $filter['level_dipilih'];
        $urutan_dipilih = $filter['urutan_dipilih'];
        $parent_dipilih = $filter['parent_dipilih'];
        $id_role_dipilih = $filter['id_role_dipilih'];
        $urutan_selanjutnya = $filter['urutan_selanjutnya'];

        $filter_parent = false;
        if($parent_dipilih!='' && $parent_dipilih != null){
          $filter_parent = true;
        }

        $q = "
        update menu_user mu
        set urutan = $urutan_dipilih
        where
          mu.posisi = '$posisi_dipilih'
          and mu.level = $level_dipilih
          and mu.urutan = $urutan_selanjutnya
          and mu.id_role = '$id_role_dipilih'
        ";
        if($filter_parent == true){
            $q .= " and mu.parent = '$parent_dipilih' ";
          }
        $query = DB::select($q);
        return $query;
    }
}
