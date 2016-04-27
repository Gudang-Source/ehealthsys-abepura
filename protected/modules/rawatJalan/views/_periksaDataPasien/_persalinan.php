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
        padding-left:5px;
    }
    .content td{
        height: 24px;
    }
</style>
<table width="100%">
    <tr>
        <td nowrap>Nama Pasien / No. RM</td>
        <td>:</td><td width="100%"> <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td nowrap>No. Pendaftaran</td>
        <td>:</td><td> <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td><td> <?php echo $modPendaftaran->umur; ?></td>
        <td>Alamat</td>
        <td>:</td><td nowrap> <?php echo $modPasien->alamat_pasien;?> <?php echo $modPasien->rt;?> <?php echo $modPasien->rw; ?></td>
    </tr>
</table>
<table width="100%" border="1" class="content">
<?php 
if (COUNT($modPersalinan)>0){
foreach ($modPersalinan as $i => $persalinan){
?>
    <tr>
        <td align="center" valign="middle" colspan="9" style="font-weight:bold; text-align: center">PERSALINAN</td>
    </tr>
    <tr>
	<td nowrap>Tanggal Mulai Persalinan</td>
        <td>:</td><td width="33%"> <?php echo (isset($persalinan->tglmulaipersalinan) ? MyFormatter::formatDateTimeForUser($persalinan->tglmulaipersalinan) :"-"); ?></td>
        <td nowrap>Tanggal Selesai Persalinan</td>
        <td>:</td><td width="33%"> <?php echo (isset($persalinan->tglselesaipersalinan) ? MyFormatter::formatDateTimeForUser($persalinan->tglselesaipersalinan) :"-"); ?></td>
        <td>Lama Persalinan</td>
        <td>:</td><td width="33%"> <?php echo (isset($persalinan->lamapersalinan_jam) ? $persalinan->lamapersalinan_jam :"-"); ?> Jam</td>
    </tr>
    <tr>
        <td>Kegiatan Persalinan</td>
        <td>:</td><td> <?php echo  (isset($persalinan->kegiatanpersalinan_id) ? $persalinan->kegiatanpersalinan->kegiatanpersalinan_nama :"-"); ?></td>
        <td>Kelompok Sebab Abortus</td>
        <td>:</td><td> <?php echo (isset($persalinan->kelsebababortus_id) ? $persalinan->kelsebababortus->kelsebababortus_nama :"-"); ?></td>
        <td>Sebab Abortus</td>
        <td>:</td><td> <?php echo (isset($persalinan->sebababortus_id) ? $persalinan->sebababortus->sebababortus_nama :"-"); ?></td>
    </tr>
    <tr>
        <td>Dokter Persalinan</td>
        <td>:</td><td> <?php echo  (isset($persalinan->pegawai_id) ? $persalinan->pegawai->pegawai_nama :"-"); ?></td>
        <td>Jenis Kegiatan Persalinan</td>
        <td>:</td><td> <?php echo (isset($persalinan->jeniskegiatanpersalinan) ? $persalinan->jeniskegiatanpersalinan :"-"); ?></td>
        <td>Cara Persalinan</td>
        <td>:</td><td> <?php echo (isset($persalinan->carapersalinan) ? $persalinan->carapersalinan :"-"); ?></td>
    </tr>
    <tr>
        <td>Posisi Janin</td>
        <td>:</td><td> <?php echo  (isset($persalinan->posisijanin) ? $persalinan->posisijanin :"-"); ?></td>
        <td>Keadaan Lahir</td>
        <td>:</td><td> <?php echo (isset($persalinan->keadaanlahir) ? $persalinan->keadaanlahir :"-"); ?></td>
        <td>Masa Gestasi</td>
        <td>:</td><td> <?php echo (isset($persalinan->masagestasi_minggu) ? $persalinan->masagestasi_minggu :"-"); ?> Minggu</td>
    </tr>
    <tr>
        <td>Paritas</td>
        <td>:</td><td> <?php echo  (isset($persalinan->paritaske) ? $persalinan->paritaske :"-"); ?></td>
        <td>Jumlah Kelahiran Hidup</td>
        <td>:</td><td> <?php echo (isset($persalinan->jmlkelahiranhidup) ? $persalinan->jmlkelahiranhidup :"-"); ?> Orang</td>
        <td nowrap>Jumlah Kelahiran Mati</td>
        <td>:</td><td> <?php echo (isset($persalinan->jmlkelahiranmati) ? $persalinan->jmlkelahiranmati :"-"); ?> Orang</td>
    </tr>
    <tr>
        <td>Sebab Kematian</td>
        <td>:</td><td> <?php echo  (isset($persalinan->sebabkematian) ? $persalinan->sebabkematian :"-"); ?></td>
        <td>Tanggal Abortus</td>
        <td>:</td><td> <?php echo (isset($persalinan->tglabortus) ? $persalinan->tglabortus :"-"); ?></td>
        <td>Jumlah Abortus</td>
        <td>:</td><td> <?php echo (isset($persalinan->jmlabortus) ? $persalinan->jmlabortus :"-"); ?></td>
    </tr>
    <tr>
        <td>Catatan Dokter</td>
        <td>:</td><td> <?php echo  (isset($persalinan->catatan_dokter) ? $persalinan->catatan_dokter :"-"); ?></td>
        <td>Bidan</td>
        <td>:</td><td> <?php echo (isset($persalinan->bidan_id) ? $persalinan->bidan->pegawai_nama :"-"); ?></td>
        <td>Paramedis</td>
        <td>:</td><td> <?php echo (isset($persalinan->paramedis_id) ? $persalinan->paramedis->pegawai_nama :"-"); ?></td>
    </tr>
    <tr><td colspan="9"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="9">* Tidak ada riwayat persalinan</td>
    </tr> 
<?php } ?>
</table> 