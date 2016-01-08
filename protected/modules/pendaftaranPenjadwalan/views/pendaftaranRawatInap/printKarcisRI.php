<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
    }
    body{
        width:7.9cm;
    }
</style>
<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrint'); ?>
<table width="100%">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
             Data Pasien
        </td>
    </tr>
    <?php if($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){ ?>
    <tr>
        <td>No. Antrian</td>
        <td>:</td>
        <td><strong><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></strong></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
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
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
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
        <td>Karcis</td>
        <td>:</td>
        <td><?php echo (isset($modTindakan->karcis->karcis_nama) ? $modTindakan->karcis->karcis_nama : "-"); ?></td>
    </tr>
    <tr>
        <td>Harga Karcis</td>
        <td>:</td>
        <td><?php echo (isset($modTindakan->tarif_satuan) ? $format->formatUang($modTindakan->tarif_satuan * $modTindakan->qty_tindakan) : "-")?></td>
    </tr>
    
</table><br>
<table width="100%">
    <tr>
        <td width="50%"></td>
        <td>Kasir</td>
    </tr>
    <tr height="60px" valign="bottom">
        <td></td>
        <td><?php echo $modPegawai->nama_pegawai; ?></td>
    </tr>
</table>


    <?php }else{ ?>
    <tr>
        <td>No. Antrian</td>
        <td>:</td>
        <td><strong><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></strong></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
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
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
    </tr>
    </table>
    <?php } ?>