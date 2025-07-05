<!DOCTYPE html>
<html>
<head>
<title>Laporan Kartu Persediaan Hasil</title>
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
    .border-th-td {
            border: 1px solid black;
            font-size: 12px;
        }
</style>
</head>
<body>

<table cellspacing="0" cellpadding="0">
  <tr style="font-size:12px; border:none !important;">
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">PT. PERKEBUNAN NUSANTARA XII (PERSERO)</td>
  </tr>
  <tr style="font-size:12px; border:none !important;">
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">KARTU PERSEDIAAN HASIL : {{$item}} di gudang: {{$gudang}}</td>
  </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0">
  <tr style="font-size:12px; border:none !important;">
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">KEBUN</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$kebun}}</td>
  </tr>
  <tr style="font-size:12px; border:none !important;">
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">TAHUN PANEN</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$tahun_panen}}</td>
  </tr>
  <tr style="font-size:12px; border:none !important;">
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">JENIS/MUTU</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$mutu}}</td>
  </tr>
  <tr style="font-size:12px; border:none !important;">
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">PERTANGGAL</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">:</td>
      <td style="padding: 1px; border: 1px solid black; font-family: Arial, Helvetica, sans-serif; font-size:10px; border:none !important;">{{$tanggal_awal}} S/D {{$tanggal}}</td>
  </tr>
</table>
<br>
<table class="table">
    <thead class="head-table">
        <tr>
            <th width="1%" colspan="2" class="text-center">NOTA TIMBANG</th>
            <th width="1%" colspan="3" class="text-center">FAKTUR KEBUN</th>
            <th width="5%" colspan="2" class="text-center">D.O</th>
            <th width="5%" colspan="2" class="text-center">S.C</th>
            <th width="1%" rowspan="2" class="text-center">No.Kav/Chop</th>
            <th width="5%" colspan="2" class="text-center">PEMASUKAN</th>
            <th width="5%" colspan="2" class="text-center">PENGELUARAN</th>
            <th width="1%" rowspan="2" class="text-center">PENYESUIAN (expor)</th>
            <th width="1%" rowspan="2" class="text-center">(+/-)</th>
            <th width="5%" colspan="2" class="text-center">SISA AKHIR KAV/CHOP</th>
        </tr>
        <tr>
            <th class="text-center" width="1%">Tanggal</th>
            <th class="text-center" width="1%">Nomor</th>
            <th class="text-center" width="1%">Kode Kebun</th>
            <th class="text-center" width="1%">Tanggal</th>
           <th class="text-center" width="1%">Nomor</th>
           <th class="text-center" width="1%">Tanggal</th>
           <th class="text-center" width="1%">Nomor</th>
           <th class="text-center" width="1%">Tanggal</th>
           <th class="text-center" width="1%">Nomor</th>
           <th class="text-center" width="1%">Jml_Colli</th>
           <th class="text-center" width="1%">Berat Netto</th>
           <th class="text-center" width="1%">Jml_Colli</th>
           <th class="text-center" width="1%">Berat Netto</th>
           <th class="text-center" width="1%">Jml_Colli</th>
           <th class="text-center" width="1%">Berat Netto</th>
         </tr>
    </thead>
    <tbody class="body-table">
        <?php
        $total_m_jml_colli=0;
        $total_m_berat_netto=0;
        $total_k_jml_colli=0;
        $total_k_berat_netto=0;
        $total_penyesuaian=0;
        $total_tmbh_kurang=0;
        $total_sisa_jml_colli=0;
        $total_sisa_berat_netto=0;
        $total_jml_colli = 0;
        $total_jml_netto = 0;
        ?>
        @foreach ($data as $row)
        <?php
            $sub_total_jml_colli = 0;
            $sub_total_jml_netto = 0;
            $sub_total_jml_colli_k = 0;
            $sub_total_jml_netto_k = 0;
            $sub_total_penyesuaian = 0;
            $sub_total_lokal = 0;
            ?>

          <tr>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['tgl_timbang']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['no_timbang']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['kode_kebun']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['tgl_faktur']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['no_faktur']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['tgl_do']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['no_do']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['tgl_sc']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['no_sc']}} <br>
                @endforeach
              </td>
              <td class="text-center">
                 @foreach ($row->data_detail as $rows)
                 {{$rows['no_kav_chop']}} <br>
                @endforeach
              </td>
              <td class="text-right">
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['m_jml_colli'],2)}} <br>
                 <?php
                 $sub_total_jml_colli += $rows['m_jml_colli'];
                 $total_m_jml_colli +=  $rows['m_jml_colli'];
                 ?>
                @endforeach
              </td>
              <td class="text-right">
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['m_berat_netto'],2)}} <br>
                 <?php
                 $sub_total_jml_netto += $rows['m_berat_netto'];
                 $total_m_berat_netto += $rows['m_berat_netto'];
                 ?>
                @endforeach
              </td>
              <td class="text-right">
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['k_jml_colli'],2)}} <br>
                @endforeach
                <?php
                $sub_total_jml_colli_k += $rows['k_jml_colli'];
                $total_k_jml_colli += $rows['k_jml_colli'];
                ?>
              </td>
              <td class="text-right">
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['k_berat_netto'],2)}} <br>
                @endforeach
                <?php
                $sub_total_jml_netto_k += $rows['k_berat_netto'];
                $total_k_berat_netto += $rows['k_berat_netto'];
                ?>
              </td>
              <td class="text-right">
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['penyesuaian'],2)}} <br>
                @endforeach
                <?php
                $sub_total_penyesuaian += $rows['penyesuaian'];
                $total_penyesuaian += $rows['penyesuaian'];
                ?>
              </td>
              <td class="text-right">
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['tmbh_kurang'],2)}} <br>
                @endforeach
                <?php
                $sub_total_lokal += $rows['tmbh_kurang'];
                $total_tmbh_kurang += $rows['tmbh_kurang'];
                ?>
              </td>
              <?php
                $sub_total_sisa_jml_colli =0;
                ?>
              <td class="text-right">
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['sisa_jml_colli'],2)}} <br>
                 <?php
                $sub_total_sisa_jml_colli = empty($row->data_detail[count($row->data_detail)-1]['sisa_jml_colli'])? 0 : $row->data_detail[count($row->data_detail)-1]['sisa_jml_colli'];
                $total_jml_colli += $rows['m_jml_colli'];
                ?>
                @endforeach
              </td>
              <td class="text-right">
                <?php
                $sub_total_sisa_berat_netto = 0;
                ?>
                 @foreach ($row->data_detail as $rows)
                 {{number_format($rows['sisa_berat_netto'],2)}} <br>
                <?php
                $sub_total_sisa_berat_netto = $row->data_detail[count($row->data_detail)-1]['sisa_berat_netto'];
                $total_jml_netto += $rows['m_berat_netto']
                ?>
                @endforeach
              </td>
          </tr>
          <tr>
            <th colspan="10" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>SUB TOTAL KAV/CHOP : {{$row->sub_no_kav_chop}}</strong></th>
            <td class="text-right">{{number_format($sub_total_jml_colli,2)}}</td>
            <td class="text-right">{{number_format($sub_total_jml_netto,2)}}</td>
            <td class="text-right">{{number_format($sub_total_jml_colli_k,2)}}</td>
            <td class="text-right">{{number_format($sub_total_jml_netto_k,2)}}</td>
            <td class="text-right">{{number_format($sub_total_penyesuaian,2)}}</td>
            <td class="text-right">{{number_format($sub_total_lokal,2)}}</td>
            <td class="text-right">{{number_format($sub_total_jml_colli-$sub_total_jml_colli_k,2)}}</td>
            <td class="text-right">{{number_format($sub_total_jml_netto-$sub_total_jml_netto_k,2)}}</td>
        </tr>
          @endforeach
          <tr>
              <th colspan="10" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>TOTAL PERSEDIAAN</strong></th>
              <td class="text-right">{{number_format($total_jml_colli,2)}}</td>
              <td class="text-right">{{number_format($total_jml_netto,2)}}</td>
              <td class="text-right">{{number_format($total_k_jml_colli,2)}}</td>
              <td class="text-right">{{number_format($total_k_berat_netto,2)}}</td>
              <td class="text-right">{{number_format($total_penyesuaian,2)}}</td>
              <td class="text-right">{{number_format($total_tmbh_kurang,2)}}</td>
              <td class="text-right">{{number_format($total_jml_colli - $total_k_jml_colli,2)}}</td>
              <td class="text-right">{{number_format($total_jml_netto - $total_k_berat_netto,2)}}</td>
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
