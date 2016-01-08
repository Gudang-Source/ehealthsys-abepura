<?php
$format = new MyFormatter();

echo CHtml::css('.control-label{
        float:left; 
        text-align: left; 
        width:160px;
        color:black;
        padding-right:10px;
        font-size: 12pt;
    }
    table{
        font-size:12px;
    }
');
?>
<style>
    td, div{
        font-size: 12pt;
    }
    td .uang{
        text-align: right;
    }
    td .total{
        border-top: 1px solid #000000;
        text-align: right;
        font-weight: bold;
    }
    td .totalSeluruh{
        border-bottom: 1px solid #000000;
        text-align: right;
        font-weight: bold;
    }
</style>

<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
                    <tr>
                        <th colspan="3" align="center" style="font-size:14pt;text-decoration:underline;padding:10px;">
                            <b>KWITANSI PEMBATALAN UANG MUKA</b>
                        </th>
                    </tr>                    
                    <tr>
                        <td width="40%">No. Kwitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo $model->nokaskeluar;?></td>
                    </tr>
                    <tr>
                        <td >Sudah Terima Dari</td>
                        <td>:</td>
                        <td><?php echo $model->namapenerima; ?></td>
                    </tr>
                    <tr>
                        <td>Banyak Uang</td>
                        <td>:</td>
                        <td><?php echo $format->formatNumberTerbilang($model->jmlkaskeluar).' rupiah';?></td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td><?php echo $model->untukpembayaran;?> Tanggal <?php echo date('d/m/Y');?></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php // echo $model->darinama_bkm;?><?php echo $tandabuktibayar->pembayaran->pendaftaran->pasien->nama_pasien; ?> - No. RM : <?php echo $tandabuktibayar->pembayaran->pendaftaran->pasien->no_rekam_medik ?></td>
                    </tr>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <div style="border:1px solid #000000;width:200px;padding:10px;font-size:14pt;font-weight: bold;">
                                Rp. <?php echo number_format($model->jmlkaskeluar,0,'','.');?>,-
                            </div>
                        </td>
                        <td align="center">
                                <div>Tasikmalaya,
                                    <?php 
                                            $tgl = $model->tglkaskeluar;
                                            $tglBayar = explode(" ",$tgl);
                                            $tanggal = $tglBayar[0];
                                            $bulan = $tglBayar[1];
                                            $tahun = $tglBayar[2];
                                            $tglBayar = $tanggal." ".$bulan." ".$tahun;
                                            // $tgls = $format->formatDateMediumForDB($tglBayar);
                                            $tgls = $tglBayar;
                                            // echo $tgls;
                                            echo $tgls;

                                    ?>
                                </div>
                                <div>Petugas RS,</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                
                                <div>
                                    <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                                    <b><?php echo $pegawai->nama_pegawai; ?></b>
                                </div>
                        </td>
                    </tr>
                    <br><br>
                    <tr>
                        <td colspan="2">
                            <div style="font-size:10pt;">Catatan : Untuk pembayaran melalui Cheque/Bilyet Giro (BG)<br>
                            belum dianggap lunas apabila Cheque/Bilyet Giro (BG) belum diuangkan<br>
                            <i>*Kwitansi ini sah bila ada tandatangan petugas dan cap RS*</i></div>
                        </td>
                    </tr>
             
            </table>
   