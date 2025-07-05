<!DOCTYPE html>
<html>
<head>
<title>Laporan Persedian PerKomoditi dan Perkebun</title>
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
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">LAPORAN PERSEDIAAN HASIL PER_KOMOIDITI, PER_KEBUN</td>
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
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">Tanggal Mutasi</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$tanggal}}</td>
    </tr>
  </table>
  <br>
<table class="table">
    <thead class="head-table">
        <tr>
            <th width="4%" rowspan="3" class="text-center">NAMA KEBUN</th>
            <th width="2%" rowspan="3" class="text-center">TAHUN PANEN</th>
            <th width="5%" rowspan="3" class="text-left">MUTU</th>
            <th width="5%" rowspan="2" colspan="2" class="text-center">SALDO AWAL</th>
            <th width="5%" colspan="4" class="text-center">PEMASUKAN</th>
            <th width="5%" colspan="4" class="text-center">PENGELUARAN</th>
            <th width="2%" rowspan="3" class="text-center">PENYESUIAN (expor)</th>
            <th width="2%" rowspan="3" class="text-center">(+/-) (lokal)</th>
            <th width="5%" rowspan="2" colspan="2" class="text-center">SALDO AKHIR</th>
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
          $total_tmbh_kurang =0;
          $total_saldo_a_colli =0;
          $total_saldo_a_netto =0;
          ?>
        @foreach ($data as $row)
           <?php
            $subtotal_k_colli = 0;
            $subtotal_k_netto = 0;
            $subtotal_t_colli = 0;
            $subtotal_t_netto = 0;
            $subtotal_e_colli = 0;
            $subtotal_e_netto = 0;
            $subtotal_l_colli = 0;
            $subtotal_l_netto = 0;
            $subtotal_penyesuaian = 0;
            $subtotal_lokal = 0;
            ?>
          <tr>
              <td class="text-center">{{$row->kebun}}</td>
              <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['tahun_panen']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['mutu']}} <br>
                @endforeach
              </td>
              <td class="text-right">
                <?php
                $total_sub_saldo_colli = 0;
                ?>
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['saldo_colli'],2)}} <br>
                <?php
                $total_sub_saldo_colli += $rows['saldo_colli'];
                $total_saldo_colli += $rows['saldo_colli'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                <?php
                $total_sub_saldo_netto = 0;
                ?>
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['saldo_netto'],2)}} <br>
                <?php
                $total_sub_saldo_netto += $rows['saldo_netto'];
                $total_saldo_netto += $rows['saldo_netto'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['masuk_k_colli'],2)}} <br>
                <?php
                $total_masuk_k_colli += $rows['masuk_k_colli'];
                $subtotal_k_colli += $rows['masuk_k_colli'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['masuk_k_netto'],2)}} <br>
                <?php
                $total_masuk_k_netto += $rows['masuk_k_netto'];
                $subtotal_k_netto += $rows['masuk_k_netto'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['masuk_t_colli'],2)}} <br>
                <?php
                $total_masuk_t_colli += $rows['masuk_t_colli'];
                $subtotal_t_colli += $rows['masuk_t_colli'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['masuk_t_netto'],2)}} <br>
                <?php
                $subtotal_t_netto += $rows['masuk_t_netto'];
                $total_masuk_t_netto += $rows['masuk_t_netto'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['keluar_e_colli'],2)}} <br>
                <?php
                $subtotal_e_colli += $rows['keluar_e_colli'];
                $total_keluar_e_colli += $rows['keluar_e_colli'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['keluar_e_netto'],2)}} <br>
                <?php
                $subtotal_e_netto += $rows['keluar_e_netto'];
                $total_keluar_e_netto += $rows['keluar_e_netto'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['keluar_l_colli'],2)}} <br>
                <?php
                $subtotal_l_colli += $rows['keluar_l_colli'];
                $total_keluar_l_colli += $rows['keluar_l_colli'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['keluar_l_netto'],2)}} <br>
                <?php
                $subtotal_l_netto += $rows['keluar_l_netto'];
                $total_keluar_l_netto += $rows['keluar_l_netto'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['penyesuaian'],2)}} <br>
                <?php
                $subtotal_penyesuaian += $rows['penyesuaian'];
                $total_penyesuaian += $rows['penyesuaian'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['tmbh_kurang'],2)}} <br>
                <?php
                $subtotal_lokal += $rows['tmbh_kurang'];
                $total_tmbh_kurang += $rows['tmbh_kurang'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                <?php
                $total_sub_saldo_a_colli = 0;
                ?>
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['saldo_akhir_colli'],2)}} <br>
                <?php
                $total_sub_saldo_a_colli += $rows['saldo_akhir_colli'];
                $total_saldo_a_colli += $rows['saldo_akhir_colli'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                <?php
                $total_sub_saldo_a_netto = 0;
                ?>
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['saldo_akhir_netto'],2)}} <br>
                <?php
                $total_sub_saldo_a_netto += $rows['saldo_akhir_netto'];
                $total_saldo_a_netto += $rows['saldo_akhir_netto'];
                ?>
                @endforeach
              </td>
          </tr>
          <tr>
            <th colspan="3" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>SUB TOTAL</strong></th>
            <td class="text-right">{{number_format($total_sub_saldo_colli,2) }}</td>
            <td class="text-right">{{number_format($total_sub_saldo_netto,2)}}</td>
            <td class="text-right">{{number_format($subtotal_k_colli,2)}}</td>
            <td class="text-right">{{number_format($subtotal_k_netto,2) }}</td>
            <td class="text-right">{{number_format($subtotal_t_colli,2)}}</td>
            <td class="text-right">{{number_format($subtotal_t_netto,2) }}</td>
            <td class="text-right">{{number_format($subtotal_e_colli,2)}}</td>
            <td class="text-right">{{number_format($subtotal_e_netto,2)}}</td>
            <td class="text-right">{{number_format($subtotal_l_colli,2)}}</td>
            <td class="text-right">{{number_format($subtotal_l_netto,2)}}</td>
            <td class="text-right">{{number_format($subtotal_penyesuaian,2)}}</td>
            <td class="text-right">{{number_format($subtotal_lokal,2)}}</td>
            <td class="text-right">{{number_format($total_sub_saldo_a_colli,2)}}</td>
            <td class="text-right">{{number_format($total_sub_saldo_a_netto,2)}}</td>
        </tr>
          @endforeach
          <tr>
              <th colspan="3" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>TOTAL PERSEDIAAN</strong></th>
              <td class="text-right">{{number_format($total_saldo_colli,2)}}</td>
              <td class="text-right">{{number_format($total_saldo_netto,2)}}</td>
              <td class="text-right">{{number_format($total_masuk_k_colli,2) }}</td>
              <td class="text-right">{{number_format($total_masuk_k_netto,2) }}</td>
              <td class="text-right">{{number_format($total_masuk_t_colli,2) }}</td>
              <td class="text-right">{{number_format($total_masuk_t_netto,2) }}</td>
              <td class="text-right">{{number_format($total_keluar_e_colli,2) }}</td>
              <td class="text-right">{{number_format($total_keluar_e_netto,2) }}</td>
              <td class="text-right">{{number_format($total_keluar_l_colli,2) }}</td>
              <td class="text-right">{{number_format($total_keluar_l_netto,2) }}</td>
              <td class="text-right">{{number_format($total_penyesuaian,2) }}</td>
              <td class="text-right">{{number_format($total_tmbh_kurang,2) }}</td>
              <td class="text-right">{{number_format($total_saldo_a_colli,2) }}</td>
              <td class="text-right">{{number_format($total_saldo_a_netto,2) }}</td>
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
                                    Surabaya, {{$tanggal_ttd}}</td>
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
