<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 14.7cm;
    }
    .content td{
        height: 48px;
    }
</style>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Umur</td>
        <td style="width:15%">: <?php echo $modPendaftaran->umur; ?></td>
        <td style="width:15%">Alamat</td>
        <td style="width:15%">: <?php echo $modPasien->alamat_pasien;?> <?php echo $modPasien->rt;?> <?php echo $modPasien->rw; ?></td>
    </tr>
</table>
<table width="100%" border="1" class="content">
<?php 
if (COUNT($modPersalinan)>0){
foreach ($modPersalinan as $i => $persalinan){
?>
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            PERSALINAN</td>
    </tr>
    <tr>
	<td style="width:20%">Tanggal Mulai Persalinan</td>
        <td style="width:30%">: <?php echo (isset($persalinan->tglmulaipersalinan) ? $persalinan->tglmulaipersalinan :"-"); ?></td>
        <td style="width:20%">Tanggal Selesai Persalinan</td>
        <td style="width:30%">: <?php echo (isset($persalinan->tglselesaipersalinan) ? $persalinan->tglselesaipersalinan :"-"); ?></td>
        <td style="width:20%">Lama Persalinan</td>
        <td style="width:30%">: <?php echo (isset($persalinan->lamapersalinan_jam) ? $persalinan->lamapersalinan_jam :"-"); ?> Jam</td>
    </tr>
    <tr>
        <td style="width:20%">Kegiatan Persalinan</td>
        <td style="width:25%">: <?php echo  (isset($persalinan->kegiatanpersalinan_id) ? $persalinan->kegiatanpersalinan->kegiatanpersalinan_nama :"-"); ?></td>
        <td style="width:20%">Kelompok Sebab Abortus</td>
        <td style="width:30%">: <?php echo (isset($persalinan->kelsebababortus_id) ? $persalinan->kelsebababortus->kelsebababortus_nama :"-"); ?></td>
        <td style="width:20%">Sebab Abortus</td>
        <td style="width:30%">: <?php echo (isset($persalinan->sebababortus_id) ? $persalinan->sebababortus->sebababortus_nama :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Dokter Persalinan</td>
        <td style="width:25%">: <?php echo  (isset($persalinan->pegawai_id) ? $persalinan->pegawai->pegawai_nama :"-"); ?></td>
        <td style="width:20%">Jenis Kegiatan Persalinan</td>
        <td style="width:30%">: <?php echo (isset($persalinan->jeniskegiatanpersalinan) ? $persalinan->jeniskegiatanpersalinan :"-"); ?></td>
        <td style="width:20%">Cara Persalinan</td>
        <td style="width:30%">: <?php echo (isset($persalinan->carapersalinan) ? $persalinan->carapersalinan :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Posisi Janin</td>
        <td style="width:25%">: <?php echo  (isset($persalinan->posisijanin) ? $persalinan->posisijanin :"-"); ?></td>
        <td style="width:20%">Keadaan Lahir</td>
        <td style="width:30%">: <?php echo (isset($persalinan->keadaanlahir) ? $persalinan->keadaanlahir :"-"); ?></td>
        <td style="width:20%">Masa Gestasi</td>
        <td style="width:30%">: <?php echo (isset($persalinan->masagestasi_minggu) ? $persalinan->masagestasi_minggu :"-"); ?> Minggu</td>
    </tr>
    <tr>
        <td style="width:20%">Paritas</td>
        <td style="width:25%">: <?php echo  (isset($persalinan->paritaske) ? $persalinan->paritaske :"-"); ?></td>
        <td style="width:20%">Jumlah Kelahiran Hidup</td>
        <td style="width:30%">: <?php echo (isset($persalinan->jmlkelahiranhidup) ? $persalinan->jmlkelahiranhidup :"-"); ?> Orang</td>
        <td style="width:20%">Jumlah Kelahiran Mati</td>
        <td style="width:30%">: <?php echo (isset($persalinan->jmlkelahiranmati) ? $persalinan->jmlkelahiranmati :"-"); ?> Orang</td>
    </tr>
    <tr>
        <td style="width:20%">Sebab Kematian</td>
        <td style="width:25%">: <?php echo  (isset($persalinan->sebabkematian) ? $persalinan->sebabkematian :"-"); ?></td>
        <td style="width:20%">Tanggal Abortus</td>
        <td style="width:30%">: <?php echo (isset($persalinan->tglabortus) ? $persalinan->tglabortus :"-"); ?></td>
        <td style="width:20%">Jumlah Abortus</td>
        <td style="width:30%">: <?php echo (isset($persalinan->jmlabortus) ? $persalinan->jmlabortus :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Catatan Dokter</td>
        <td style="width:25%">: <?php echo  (isset($persalinan->catatan_dokter) ? $persalinan->catatan_dokter :"-"); ?></td>
        <td style="width:20%">Bidan</td>
        <td style="width:30%">: <?php echo (isset($persalinan->bidan_id) ? $persalinan->bidan->pegawai_nama :"-"); ?></td>
        <td style="width:20%">Paramedis</td>
        <td style="width:30%">: <?php echo (isset($persalinan->paramedis_id) ? $persalinan->paramedis->pegawai_nama :"-"); ?></td>
    </tr>
    <tr><td colspan="6"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada riwayat persalinan</td>
    </tr> 
<?php } ?>
</table> 