<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    body{
        width: 100%;
    }
    th, td, div{
        font-family:Times New Roman;
        font-size: 9.7pt;
        line-height: 12px;
    }
</style>
<?php
$format = new MyFormatter;
 echo $this->renderPartial('application.views.headerReport.headerRincian');
?>
    <table class="status">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
         <tr>
             <td align="center" valig="middle" colspan="3" style="text-decoration: underline;">
                 <br/>
                 Data Pasien
            </td>
        </tr>
        <tr>
            <td width="130">No. Pendaftaran</td>
            <td>:</td>
            <td><strong><?php echo $modPendaftaran->no_pendaftaran; ?></strong></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medis</td>
            <td>:</td>
            <td><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>/<?php echo $modPendaftaran->umur; ?></td>
        </tr>
        <tr>
            <td>Cara Bayar / Penjamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?>/<?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                <br/>
                <u><?php echo isset($modPasienMasukPenunjang->ruangan->ruangan_nama) ? $modPasienMasukPenunjang->ruangan->ruangan_nama : "-"; ?></u>
            </td>
        </tr>
        <tr>
            <td>No. Masuk Penunjang</td>
            <td>:</td>
            <td><?php echo isset($modPasienMasukPenunjang->no_masukpenunjang) ? $modPasienMasukPenunjang->no_masukpenunjang : "-"; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo isset($modPasienMasukPenunjang->kelaspelayanan->kelaspelayanan_nama) ? $modPasienMasukPenunjang->kelaspelayanan->kelaspelayanan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Dokter Pemeriksa</td>
            <td>:</td>
            <td><?php echo isset($modPasienMasukPenunjang->pegawai->NamaLengkap) ? $modPasienMasukPenunjang->pegawai->NamaLengkap : "-"; ?></td>
        </tr>
        <?php /*
        <tr>
            <td>Karcis</td>
            <td>:</td>
            <td>
                <?php echo (isset($modTindakans->karcis->karcis_nama) ? $modTindakans->karcis->karcis_nama : "-"); ?>
            </td>
        </tr>
        <tr>
            <td>Tarif Karcis</td>
            <td>:</td>
            <td>
                <?php 
                echo (isset($modTindakans->tarif_satuan) ? $format->formatUang($modTindakans->tarif_satuan * $modTindakans->qty_tindakan) : "0");
                echo " ".(!empty($modTindakans->tindakansudahbayar_id) ? "(Lunas)" : "(Belum Lunas)");
                ?>
            </td>
        </tr>
         * 
         */ ?>
<!--                    <tr>
            <td>Status Pembayaran Karcis</td>
            <td>:</td>
            <td>Belum Dibayar  Default dulu</td>
        </tr>-->
        <tr>
            <td colspan="3" align="center">
                            <br/>
                            <div align="center" valign="middle"><strong><u>Daftar Pemeriksaan</u></strong></div>
                            <table border="1" style="margin-top: 10px;text-align:center;width:360px;">
                                <thead>
                                <td><strong>No.</strong></td>
                                <td><strong>Pemeriksaan</strong></td>
                                <td><strong>Tarif</strong></td>
                                </thead>
                                <?php 
                                $total_tarif = 0;
                                foreach ($daftartindakan as $i=>$daftartindakans){ 
                                ?>
                                <tr>
                                    <td><?php echo ($i+1)."."; ?></td>
                                    <td><?php echo $daftartindakans->daftartindakan->daftartindakan_nama; ?></td>
                                    <td><?php 
                                    $tarif_tindakan = ($daftartindakans->tarif_satuan * $daftartindakans->qty_tindakan);
                                    $total_tarif += $tarif_tindakan;
                                    echo $format->formatUang($tarif_tindakan); ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2" align="center"><strong>Total</strong></td>
                                    <td><?php echo $format->formatUang($total_tarif); ?></td>
                                </tr>
                            </table>
                        </td>
        </tr>
        
    </table>
    <div style="border: 0px solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=" >  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>