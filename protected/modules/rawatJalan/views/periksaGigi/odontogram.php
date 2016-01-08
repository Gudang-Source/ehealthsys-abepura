<?php
$pendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
$pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
?>
<table>
    <tr>
        <td width="100px;">Tgl. Pendaftaran</td><td>:</td><td><?php echo $pendaftaran->tgl_pendaftaran; ?></td>
        <td width="100px;">No. Rekam Medik</td><td>:</td><td><?php echo $pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td><td>:</td><td><?php echo $pendaftaran->no_pendaftaran; ?></td>
        <td>Nama Pasien</td><td>:</td><td><?php echo $pasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir / Umur</td><td>:</td><td><?php echo $pasien->tanggal_lahir . ' / ' . $pendaftaran->umur; ?></td>
        <td>Bin / Binti</td><td>:</td><td><?php echo $pasien->nama_bin; ?></td>
    </tr>
    <tr>
        <td>Kasus Penyakit</td><td>:</td><td><?php echo (isset($pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama) ? $pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : ""); ?></td>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo $pasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Golongan Darah</td><td>:</td><td><?php echo $pasien->golongandarah; ?></td>
        <td>Alamat</td><td>:</td><td><?php echo $pasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <?php
        $this->widget('Odontogram', array('gigis' => $gigi));
        ?> 
    </tr>
</table>
<br/>
