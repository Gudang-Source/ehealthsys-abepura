<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="100%">
    <tr>
        <td align="center" nowrap>
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
        </td>
        <td align="center" width="100%">
            <div>
                <b>PEMERINTAH PROVINSI <?php echo strtoupper($modProfilRs->propinsi->propinsi_nama); ?></b>
            </div>
            <div>
                <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
            </div>
            <div>
                <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>. Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 2px solid #000000">&nbsp;</td>
    </tr>
</table>