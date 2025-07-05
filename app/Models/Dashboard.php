<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    use HasFactory;
    public $incrementing = false;

    function dashboardPenerimaan($filter)
    {
        $tglAwal = $filter['tgl_awal'];
        $tglAkhir = $filter['tgl_akhir'];
        $id_gudang = $filter['id_gudang'];
        $id_item = $filter['id_item'];

        $q = "
        select
        tpbd.id_gudang, mg.nama as nama_gudang, 
        tpbd.id_item , mi.nama as nama_komoditas,
        sum(tpbd.jml_colli) as jml_colli, 
        sum(tpbd.bruto * tpbd.jml_colli) as jml_bruto,
        sum(tpbd.netto * tpbd.jml_colli) as jml_netto,
        tpb.id_jenis_penerimaan,
        mjp.nama as status
        from t_penerimaan_barang_detail tpbd 
        left join m_item mi on mi.id = tpbd.id_item
        left join m_gudang mg on mg.id = tpbd .id_gudang
        left join t_penerimaan_barang tpb on tpb.id = tpbd.id_penerimaan
        left join m_jenis_penerimaan mjp on mjp.id = tpb.id_jenis_penerimaan 
        where 
        tpbd.is_deleted = false
        and tpb.tgl_timbang::date between '$tglAwal'::date and '$tglAkhir'::date
        ";

        if ($id_gudang != '') {
            $q .= " AND tpbd.id_gudang = '$id_gudang' ";
        }

        if ($id_item != '') {
            $q .= " AND tpbd.id_item = '$id_item' ";
        }

        $q .=
            ' group by tpbd.id_gudang, mg.nama, tpbd.id_item, mi.nama, tpb.id_jenis_penerimaan, mjp.nama';

        $query = DB::select($q);
        return $query;
    }

    function dashboardPengeluaran($filter)
    {
        $tglAwal = $filter['tgl_awal'];
        $tglAkhir = $filter['tgl_akhir'];
        $id_gudang = $filter['id_gudang'];
        $id_item = $filter['id_item'];

        $q = "
        select
        tpbd.id_gudang, mg.nama as nama_gudang, 
        tpbd.id_item , mi.nama as nama_komoditas,
        sum(tpbd.jml_colli) as jml_colli, 
        sum(tpbd.bruto * tpbd.jml_colli) as jml_bruto,
        sum(tpbd.netto * tpbd.jml_colli) as jml_netto
        from t_pengeluaran_barang_detail tpbd
        left join m_item mi on mi.id = tpbd.id_item
        left join m_gudang mg on mg.id = tpbd .id_gudang
        left join t_pengeluaran_barang tpb on tpb.id = tpbd.id_pengeluaran
        where 
        tpbd.is_deleted = false
        and tpb.tgl_timbang::date between '$tglAwal'::date and '$tglAkhir'::date
        ";

        if ($id_gudang != '') {
            $q .= " AND tpbd.id_gudang = '$id_gudang' ";
        }

        if ($id_item != '') {
            $q .= " AND tpbd.id_item = '$id_item' ";
        }

        $q .= 'group by mi.nama, tpbd.id_gudang, mg.nama, tpbd.id_item';

        $query = DB::select($q);
        return $query;
    }

    function dashboardStockBarang($filter)
    {
        $tglAwal = $filter['tgl_awal'];
        $tglAkhir = $filter['tgl_akhir'];
        $id_gudang = $filter['id_gudang'];
        $id_item = $filter['id_item'];

        $q = "
        select * from fn_dashboard_stock('$id_gudang', '$id_item', '$tglAwal', '$tglAkhir') as 
        (id_item varchar, nama_komoditas varchar, id_gudang varchar, nama_gudang varchar, stock numeric)
        ";

        $query = DB::select($q);
        return $query;
    }
}
