<!DOCTYPE html>
<html>
<head>
<title>Laporan Pengeluaran Barang</title>
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
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">LAPORAN HARIAN PENGELUARAN HASIL</td>
    </tr>
  </table>
  <br>
<table cellspacing="0" cellpadding="0">
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">Gudang</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$gudang}}</td>
    </tr>
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">Tanggal</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$tanggal}}</td>
    </tr>
  </table>
  <br>
<table class="table">
    <thead class="head-table">
        <tr>
            <th width="2%" rowspan="2" class="text-center">NO.NT.Keluar</th>
            <th width="5%" colspan="2" class="text-center">DARI KEBUN</th>
            <th width="3%" rowspan="2" class="text-left">Komoditi</th>
            <th width="2%" rowspan="2" class="text-center">Tahun Panen</th>
            <th width="2%" rowspan="2" class="text-center">Jenis/Mutu</th>
            <th width="2%" rowspan="2" class="text-center">No.Kav/Chop</th>
            <th width="2%" rowspan="2" class="text-center">No.Serie/Colli</th>
            <th width="2%" rowspan="2" class="text-center">Jumlah Colli</th>
            <th width="5%" colspan="2" class="text-center">DIKELUARKAN</th>
            <th width="2%" rowspan="2" class="text-center">PENYESUIAN (expor)</th>
            <th width="2%" rowspan="2" class="text-center">(+/-) (lokal)</th>
            <th width="5%" colspan="2" class="text-center">DO/PPL</th>
            <th width="5%" colspan="2" class="text-center">S.C</th>
            <th width="1%" rowspan="2" class="text-center">Ekspor/Lokal</th>
            <th width="5%" rowspan="2" class="text-center">Cattan</th>
        </tr>
        <tr>
           <th class="text-center" width="2%">Kode</th>
           <th class="text-center" width="2%">Kebun</th>
           <th class="text-center" width="2%">Bruto</th>
           <th class="text-center" width="2%">Netto</th>
           <th class="text-center" width="2%">No.</th>
           <th class="text-center" width="2%">Tanggal</th>
           <th class="text-center" width="2%">No.</th>
           <th class="text-center" width="2%">Tanggal</th>
         </tr>
    </thead>
    <tbody class="body-table">
        <?php
          $total_colli = 0;
          $total_bruto = 0;
          $total_netto = 0;
          $total_penyesuaian = 0;
          $total_local = 0;
        ?>
        @foreach ($data as $row)
        <?php
            $subtotal_colli = 0;
            $subtotal_bruto = 0;
            $subtotal_netto = 0;
            $subtotal_penyesuaian = 0;
            $subtotal_local = 0;
            ?>
          <tr>
              <td class="text-center">{{$row->no_transaksi}}</td>
              <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['kode']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['kebun']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['item']}} <br>
                @endforeach
              </td>
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
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['no_kav_chop']}}<br>
                    @endforeach
              </td>
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['no_serie_colli']}}<br>
                    @endforeach
              </td>
              <td class="text-right">
                    @foreach ($row->data_detail as $rows)
                    {{number_format($rows['jml_colli'],2)}}<br>
                    <?php
                    $subtotal_colli += $rows['jml_colli'];
                    $total_colli += $rows['jml_colli'];
                    ?>
                    @endforeach
              </td>
              <td class="text-right">
                    @foreach ($row->data_detail as $rows)
                    {{number_format($rows['bruto_keluar'],2)}}<br>
                    <?php
                    $subtotal_bruto += $rows['bruto_keluar'];
                    $total_bruto += $rows['bruto_keluar'];
                    ?>
                    @endforeach
              </td>
              <td class="text-right">
                    @foreach ($row->data_detail as $rows)
                    {{number_format($rows['netto_keluar'],2)}}<br>
                    <?php
                    $subtotal_netto += $rows['netto_keluar'];
                    $total_netto += $rows['netto_keluar'];
                    ?>
                    @endforeach
              </td>
              <td class="text-right">
                    @foreach ($row->data_detail as $rows)
                    {{number_format($rows['penyesuaian'],2)}}<br>
                    <?php
                    $subtotal_penyesuaian += $rows['penyesuaian'];
                    $total_penyesuaian += $rows['penyesuaian'];
                    ?>
                    @endforeach
              </td>
              <td class="text-right">
                    @foreach ($row->data_detail as $rows)
                    {{number_format($rows['local'],2)}}<br>
                    <?php
                    $subtotal_local += $rows['local'];
                    $total_local += $rows['local'];
                    ?>
                    @endforeach
              </td>
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['no_do']}}<br>
                    @endforeach
              </td>
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['tgl_do']}}<br>
                    @endforeach
              </td>
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['no_sc']}}<br>
                    @endforeach
              </td>
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['tgl_sc']}}<br>
                    @endforeach
              </td>
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['ex']}}<br>
                    @endforeach
              </td>
              <td class="text-center">
                    @foreach ($row->data_detail as $rows)
                    {{$rows['catatan']}}<br>
                    @endforeach
              </td>
          </tr>
          <tr>
            <th colspan="8" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>SUB TOTAL TIMBANG</strong></th>
            <td class="text-right">{{number_format($subtotal_colli,2)}}</td>
            <td class="text-right">{{number_format($subtotal_bruto,2)}}</td>
            <td class="text-right">{{number_format($subtotal_netto,2)}}</td>
            <td class="text-right">{{number_format($subtotal_penyesuaian,2)}}</td>
            <td class="text-right">{{number_format($subtotal_local,2)}}</td>
            <td class="text-center" colspan="6"></td>
        </tr>
          @endforeach
          <tr>
              <th colspan="8" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>TOTAL PENGELUARAN HASIL</strong></th>
              <td class="text-right">{{number_format($total_colli,2)}}</td>
              <td class="text-right">{{number_format($total_bruto,2)}}</td>
              <td class="text-right">{{number_format($total_netto,2)}}</td>
              <td class="text-right">{{number_format($total_penyesuaian,2)}}</td>
              <td class="text-right">{{number_format($total_local,2)}}</td>
              <td class="text-center" colspan="6"></td>
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
