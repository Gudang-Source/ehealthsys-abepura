<style>
    body {
        width: 22cm;
    }
    
    .letters, .letters table td {
        font-family: serif !important;
        line-height: .5cm;
        font-size: 12px;
    }
    
    .heads td {
        line-height: normal;
    }
    .heads td > div {
        font-family: serif !important;
        line-height: normal;
        font-size: 16px;
    }
    
    .ind {
        margin-left: 2cm;
        margin-bottom: .5cm;
        margin-top: .5cm;
    }
    
    .judul {
        text-align: center;
        font-size: 18px;
        font-family: serif !important;
        font-weight: bold;
        text-decoration: underline;
        margin-top: .5cm;
        margin-bottom: .5cm;
    }
</style>

<div class="letters">
    <div class="heads">
        <?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); ?>
    </div>


<div class="judul">SURAT RENCANA KONTROL PASIEN</div>
<div class="judul"><?php echo $sk->nomorsurat; ?></div>
Saya yang bertanda tangan dibawah ini, Dokter RSUD ABPURA, dengan ini menerangkan bahwa :<br/>
<table class="ind">
    <tr>
        <td width="150">Nama</td><td>: <?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
    <tr/>
    <tr>
        <td>Nomor RM</td><td>: <?php echo $modPasien->no_rekam_medik; ?></td>    
    </tr>
    <tr>
        <td>Umur/Tgl. Lahir</td><td>: <?php echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>: <?php echo $modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Alamat<td>: <?php echo $modPasien->alamat_pasien; ?></td>
    </tr>
</table>

Supaya pasien diatas dapat melakukan rencana kontrol pada :
<?php 
$tgl = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
?>
<table class="ind">
    <tr>
        <td width="150">Tanggal<td>: <?php echo MyFormatter::formatDateTimeForUser($tgl); ?></td>
    </tr>
    <tr>
        <td>Poliklinik</td><td>: <?php echo $modPendaftaran->ruangankontrol->ruangan_nama; ?></td>
    </tr>
</table>

Surat ini hanya berlaku untuk <strong>satu kali unjungan</strong> pada tanggal <strong><?php echo MyFormatter::formatDateTimeForUser($tgl); ?></strong>
selama jam pelayanan.<br/><br/>
Demikian Surat Rencana Kontrol ini dibuat untuk dipergunakan seperlunya.<br/><br/>

<table>
    <tr>
        <td width="100%"></td>
        <td nowrap style="text-align: center">
            <?php echo Yii::app()->user->getState('kecamatan_nama').", ".MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?>
            <br/>
            <br/>
            <br/>
            <br/>
            <u><?php echo $modAdmisi->pegawai->namaLengkap; ?></u><br/>
            <?php echo $modAdmisi->pegawai->nomorindukpegawai; ?>
        </td>
    </tr>
    
</table>


</div>


