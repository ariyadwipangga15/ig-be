<!DOCTYPE html>
<html>
<head>
<title>REKAPITULASI LAPORAN PERSEDIAAN HASIL AKHIR_BULAN, PER_KEBUN</title>
<link rel="icon" sizes="16x16" href="">
<style>
    .table {
      border-collapse: collapse;
      border-color: #333;
      font-family: TimesNewRoman,Times New Roman,Times,Baskerville,Georgia,serif;
      width:100%;
    }
    .head-table th{
      padding: 8px;
      border-top: 1px solid #333;
      border-bottom: 1px solid #333;
      font-family: Arial, Helvetica, sans-serif;
      font-size:11px;
    }
    .body-table td,th{
      padding: 4px;
      border: 1px solid black;
      font-family: Arial, Helvetica, sans-serif;
      font-size:11px;
    }
    .head-lap td{
      padding: 1px;
      border: 1px solid black;
      font-family: Arial, Helvetica, sans-serif;
    }
    .text-center{
        text-align:center;
    }
    .text-left{
        text-align:left;
    }
    .text-right{
        text-align:right;
    }
    .line-title {
        border: 0;
        border-style: inset;
        border-top: 2px solid #333;
    }
    .line-title-child {
        border: 0;
        margin-top: -7px;
        border-top: 1px solid #333;
    }
    .flex-container {
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    }

    .page_break { page-break-before: always; }
    @page { margin: 0.8cm; }
</style>
</head>
<body>

<table cellspacing="0" cellpadding="0">
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">PT. PERKEBUNAN NUSANTARA XII (PERSERO)</td>
    </tr>
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">REKAPITULASI LAPORAN PERSEDIAAN HASIL AKHIR_BULAN, PER_KEBUN</td>
    </tr>
  </table>
  <br>
<table cellspacing="0" cellpadding="0">
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">Nama Komoditi</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$item}}</td>
    </tr>
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">Gudang Transito</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$gudang}}</td>
    </tr>
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">Bulan</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$bulanTahun}}</td>
    </tr>
  </table>
  <br>
<table class="table">
    <thead class="head-table">
        <tr>
            <th width="2%" rowspan="3" class="text-center">KODE KEBUN</th>
            <th width="4%" rowspan="3" class="text-center">NAMA KEBUN</th>
            <th width="2%" rowspan="3" class="text-center">TAHUN PANEN</th>
            <th width="5%" rowspan="2" colspan="2" class="text-center">SALDO AWAL TAHUN</th>
            <th width="5%" colspan="4" class="text-center">PEMASUKAN S/D BULAN INI</th>
            <th width="5%" colspan="4" class="text-center">PENGELUARAN S/D BULAN INI</th>
            <th width="2%" rowspan="3" class="text-center">PENYESUIAN (expor)</th>
            <th width="2%" rowspan="3" class="text-center">(+/-) (lokal)</th>
            <th width="5%" rowspan="2" colspan="2" class="text-center">SALDO AKHIR BULAN</th>
        </tr >
        <tr>
            <th colspan="2" class="text-center">EX. KEBUN</th>
            <th colspan="2" class="text-center">EX. TRANSITO</th>
            <th colspan="2" class="text-center">EKSPOR</th>
            <th colspan="2" class="text-center">LOKAL</th>
        </tr>
        <tr>
            <th class="text-center" width="2%">Colli</th>
            <th class="text-center" width="2%">Netto</th>
            <th class="text-center" width="2%">Colli</th>
            <th class="text-center" width="2%">Netto</th>
            <th class="text-center" width="2%">Colli</th>
            <th class="text-center" width="2%">Netto</th>
            <th class="text-center" width="2%">Colli</th>
            <th class="text-center" width="2%">Netto</th>
            <th class="text-center" width="2%">Colli</th>
            <th class="text-center" width="2%">Netto</th>
            <th class="text-center" width="2%">Colli</th>
            <th class="text-center" width="2%">Netto</th>
        </tr>
  </tr>
    </thead>
    <tbody class="body-table">
        <?php
          $total_saldo_colli = 0;
          $total_saldo_netto = 0;
          $total_masuk_k_colli =0;
          $total_masuk_k_netto =0;
          $total_masuk_t_colli =0;
          $total_masuk_t_netto =0;
          $total_keluar_e_colli =0;
          $total_keluar_e_netto =0;
          $total_keluar_l_colli =0;
          $total_keluar_l_netto =0;
          $total_penyesuaian =0;
          $total_local =0;
          $total_saldo_a_colli =0;
          $total_saldo_a_netto =0;
        ?>
        @foreach ($data as $row)
           <?php
            $total_saldo_colli += $row->saldo_colli;
            $total_saldo_netto += $row->saldo_netto;
            $total_masuk_k_colli+=$row->masuk_k_colli;
            $total_masuk_k_netto+=$row->masuk_k_netto;
            $total_masuk_t_colli+=$row->masuk_t_colli;
            $total_masuk_t_netto+=$row->masuk_t_netto;
            $total_keluar_e_colli+=$row->keluar_e_colli;
            $total_keluar_e_netto+=$row->keluar_e_netto;
            $total_keluar_l_colli+=$row->keluar_l_colli;
            $total_keluar_l_netto+=$row->keluar_l_netto;
            $total_penyesuaian+=$row->penyesuaian;
            $total_local+=$row->tmbh_kurang;
            $total_saldo_a_colli+=$row->saldo_a_colli;
            $total_saldo_a_netto+=$row->saldo_a_netto;
            ?>
          <tr>
              <td class="text-center">{{$row->kode_kebun}}</td>
              <td class="text-center">{{$row->kebun}}</td>
              <td class="text-center">{{$row->tahun_panen}}</td>
              <td class="text-right">{{number_format($row->saldo_colli,2)}}</td>
              <td class="text-right">{{number_format($row->saldo_netto,2)}}</td>
              <td class="text-right">{{number_format($row->masuk_k_colli,2)}}</td>
              <td class="text-right">{{number_format($row->masuk_k_netto,2)}}</td>
              <td class="text-right">{{number_format($row->masuk_t_colli,2)}}</td>
              <td class="text-right">{{number_format($row->masuk_t_netto ?? 0.0,2)}}</td>
              <td class="text-right">{{number_format($row->keluar_e_colli,2)}}</td>
              <td class="text-right">{{number_format($row->keluar_e_netto,2)}}</td>
              <td class="text-right">{{number_format($row->keluar_l_colli,2)}}</td>
              <td class="text-right">{{number_format($row->keluar_l_netto,2)}}</td>
              <td class="text-right">{{number_format($row->penyesuaian,2)}}</td>
              <td class="text-right">{{number_format($row->tmbh_kurang,2)}}</td>
              <td class="text-right">{{number_format($row->saldo_a_colli,2)}}</td>
              <td class="text-right">{{number_format($row->saldo_a_netto,2)}}</td>
          </tr>
          @endforeach
          <tr>
              <th colspan="3" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>TOTAL PERSEDIAAN</strong></th>
              <td class="text-right">{{number_format($total_saldo_colli,2)}}</td>
              <td class="text-right">{{number_format($total_saldo_netto,2)}}</td>
              <td class="text-right">{{number_format($total_masuk_k_colli,2)}} </td>
              <td class="text-right">{{number_format($total_masuk_k_netto,2)}} </td>
              <td class="text-right">{{number_format($total_masuk_t_colli,2)}} </td>
              <td class="text-right">{{number_format($total_masuk_t_netto,2)}} </td>
              <td class="text-right">{{number_format($total_keluar_e_colli,2)}} </td>
              <td class="text-right">{{number_format($total_keluar_e_netto,2)}} </td>
              <td class="text-right">{{number_format($total_keluar_l_colli,2)}} </td>
              <td class="text-right">{{number_format($total_keluar_l_netto,2)}}</td>
              <td class="text-right">{{number_format($total_penyesuaian,2)}}</td>
              <td class="text-right">{{number_format($total_local,2)}}</td>
              <td class="text-right">{{number_format($total_saldo_a_colli,2)}}</td>
              <td class="text-right">{{number_format($total_saldo_a_netto,2)}}</td>
          </tr>
    </tbody>
</table>
<!-- ttd -->
<table style="width: 100%" class="table">
        <tbody>
            <tr>
                <td style="width:30%;">
                    <table style="width:30%; margin-bottom:85px;" class="table body-table">
                        <tr>
                            <td style="font-size:13px; border:none !important;">{{$ttd_ket_kabag}}</td>
                        </tr>
                        <tr>
                            <td style="font-size:13px; border:none !important;">{{$ttd_jabatan_kabag}}</td>
                        </tr>
                        <tr>
                            <td align="left" style="border:none !important;">
                                <div style="margin-left:30px">
                                    <?php
                echo '<img style="width:50px; height:50px;" src="' . $ttd_kabag . '">';
                ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="vertical-align: top; width:30%;">
                </td>
                <td style="vertical-align: top; width:30%;">
                    <table class="table">
                        <tbody>
                            <tr align="right">
                                <td colspan="{{ count($data_ttd) }}" style="font-size:15px;">
                                    Surabaya, {{$tanggal}}</td>
                            </tr>
                            <tr>
                                <?php foreach ($data_ttd as $row) { ?>
                                <td class="text-right" style="width:10%;">
                                    {{$row->nama}}<br>
                                    <div>
                                        <img style="width:50px; height:50px;" src="{{$row->path_ttd}}">
                                    </div>
                                    {{$row->nama_user}}

                                </td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
