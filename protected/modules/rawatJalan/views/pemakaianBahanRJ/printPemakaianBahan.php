<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>

    <table>
        <tr>
            <td>
                <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
            </td>
        </tr>
    </table>
    <table class="status">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>Data Kunjungan</h4>
            </td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->tanggal_lahir; ?> / <?php echo $modPendaftaran->umur; ?></td>
        </tr>
        <tr>
            <td>Cara Bayar / Penjamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->carabayar_nama; ?> / <?php echo $modPendaftaran->penjamin_nama; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->kelaspelayanan_nama; ?></td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>Daftar Obat dan Alat Kesehatan</h4>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                            <table border="1" style="text-align:center;">
                                <thead>
                                    <td><strong>No.</strong></td>
                                    <td><strong>Obat & Alat Kesehatan</strong></td>
                                    <td><strong>Jumlah</strong></td>
                                </thead>
                                <?php 
                                $total = 0;
                                $subtotal = 0;
                                foreach ($modObatAlkesPasien as $i=>$modOAPasien){ 
                                ?>
                                    <tr>
                                        <td><?php echo ($i+1)."."; ?></td>
                                        <td><?php echo $modOAPasien->obatalkes->obatalkes_nama; ?></td>
                                        <td><?php echo $modOAPasien->qty_oa; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
            </td>
        </tr>

    </table>
    <div style="border: 0px solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=" >  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>