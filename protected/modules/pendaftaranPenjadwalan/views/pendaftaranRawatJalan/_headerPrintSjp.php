<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="100%">
    <tr>
        <td align="center" nowrap>
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 60px; width:60px;"/>
        </td>
        <td align="center" width="100%">
            <div>
                <h4><b>PEMERINTAH PROVINSI <?php echo strtoupper($modProfilRs->propinsi->propinsi_nama); ?></b></h4>
            </div>
            <div>
                <h3><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></h3>
            </div>
            <div>
                <h5><b>SATGAS KARTU PAPUA SEHAT (KPS)</b></h5>
            </div>
            <div>
                <font style="font-size:10px;"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>. Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </div>
        </td>
         <td align="center" nowrap>
            <img src="<?php echo Params::urlProfilRSDirectory()."../baktihusada1.png" ?>" style="max-width: 60px; width:60px;"/>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 3px solid #000000;"><div  style="height:3px;border-bottom: 1px solid #000000;width:100%"></div></td>
    </tr>
</table>