<!DOCTYPE html>
<html>
<head>
<title>Laporan Penjualan Ekspor Urut No SC</title>
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
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">LAPORAN PENJUALAN/PENGELUARAN EKSPOR URUT NOMOR_SC</td>
    </tr>
  </table>
  <br>
<table cellspacing="0" cellpadding="0">
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">KOMODITI</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$item}}</td>
    </tr>
    <tr style="font-size:12px; border:none !important;">
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">PERIODE TGL</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
        <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$tanggal}}</td>
    </tr>
</table>
  <br>
<table class="table">
    <thead class="head-table">
        <tr>
            <th width="2%" rowspan="2" class="text-center">NO.</th>
            <th width="2%" colspan="2" class="text-center">NT. Keluar</th>
            <th width="5%" colspan="2" class="text-center">S.C</th>
            <th width="3%" rowspan="2" class="text-center">NO.INV</th>
            <th width="4%" rowspan="2" class="text-center">Tanggal Pengapalan</th>
            <th width="4%" rowspan="2" class="text-center">MUTU</th>
            <th width="4%" rowspan="2" class="text-center">KAV/CHOP</th>
            <th width="2%" rowspan="2" class="text-center">Tahun Panen</th>
            <th width="3%" rowspan="2" class="text-center">Jumlah Colli</th>
            <th width="3%" rowspan="2" class="text-center">Berat Netto</th>
            <th width="3%" rowspan="2" class="text-center">Harga Satuan US-$</th>
            <th width="5%" colspan="3" class="text-center">NILAI</th>
            <th width="3%" rowspan="2" class="text-center">NEGARA TUJUAN</th>
            <th width="3%" rowspan="2" class="text-center">BRG Titipan</th>
        </tr>
        <tr>
           <th class="text-center" width="3%">NO.</th>
           <th class="text-center" width="3%">TGL.</th>
           <th class="text-center" width="3%">NO.SC</th>
           <th class="text-center" width="3%">TGL.SC</th>
           <th class="text-center" width="3%">US-$</th>
           <th class="text-center" width="3%">KURS</th>
           <th class="text-center" width="3%">Rp.</th>
         </tr>
    </thead>
    <tbody class="body-table">
        <?php
          $no = 0;
          $total_colli = 0;
          $total_berat_netto = 0;
          $total_us = 0;
          $total_rupiah = 0;
        ?>
        @foreach ($data as $row)
        <?php
         $subtotal_colli = 0;
         $subtotal_berat_netto = 0;
         $subtotal_us = 0;
         $subtotal_rupiah = 0;
         ?>
          <tr>
            <td class="text-center">
              <?php $count1 = 0;
              $no2 = $no+1;
            ?>
                @foreach ($row->data_detail as $rows)
                {{$no2++}}  <br>
                @endforeach
                <?php $no=$no2-1; ?>
              </td>
            <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['no_transaksi']}} <br>
                @endforeach
              </td>
            <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['tanggal']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['no_sc']}} <br>
                @endforeach
             </td>
            <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['tgl_sc']}} <br>
                @endforeach
             </td>
             <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['no_invoice']}} <br>
                @endforeach
             </td>
            <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['tgl_pengapalan']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['mutu']}} <br>
                @endforeach
             </td>
             <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['no_kav_chop']}} <br>
                @endforeach
             </td>
            <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['tahun_panen']}} <br>
                @endforeach
             </td>
            <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['jml_colli'],2)}} <br>
                <?php
                $subtotal_colli += $rows['jml_colli'];
                $total_colli += $rows['jml_colli'];
                ?>
                @endforeach
             </td>
            <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{number_format($rows['berat_netto'],2)}} <br>
                <?php
                $subtotal_berat_netto += $rows['berat_netto'];
                $total_berat_netto += $rows['berat_netto'];
                ?>
                @endforeach
             </td>
            <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{$rows['harga_satuan']}} <br>
                @endforeach
             </td>
            <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{$rows['us']}} <br>
                <?php
                $subtotal_us += $rows['us'];
                $total_us += $rows['us'];
                ?>
                @endforeach
             </td>
            <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{$rows['kurs']}} <br>
                @endforeach
             </td>
            <td class="text-right">
                @foreach ($row->data_detail as $rows)
                {{$rows['rupiah']}} <br>
                <?php
                $subtotal_rupiah += $rows['rupiah'];
                $total_rupiah += $rows['rupiah'];
                ?>
                @endforeach
             </td>
            <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['tujuan']}} <br>
                @endforeach
             </td>
            <td class="text-center">
                @foreach ($row->data_detail as $rows)
                {{$rows['ex_titipan']}} <br>
                @endforeach
             </td>
          </tr>
          <tr>
            <th colspan="10" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>SUB TOTAL</strong></th>
            <td class="text-right">{{number_format($subtotal_colli,2)}}</td>
            <td class="text-right">{{number_format($subtotal_berat_netto,2)}}</td>
            <td class="text-center"></td>
            <td class="text-right">{{number_format($subtotal_us)}}</td>
            <td class="text-center"></td>
            <td class="text-right">{{number_format($subtotal_rupiah)}}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
          @endforeach
          <tr>
            <th colspan="10" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>TOTAL</strong></th>
            <td class="text-right">{{number_format($total_colli,2)}}</td>
            <td class="text-right">{{number_format($total_berat_netto,2)}}</td>
            <td class="text-center"></td>
            <td class="text-right">{{number_format($total_us)}}</td>
            <td class="text-center"></td>
            <td class="text-right">{{number_format($total_rupiah)}}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
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
