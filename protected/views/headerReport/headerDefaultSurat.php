<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);?>

<table width="100%">
        <TR>
            <TD ROWSPAN=4 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit; ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT FACE="Liberation Serif" SIZE=4><?php echo $data->nama_rumahsakit; ?></FONT></B>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <FONT FACE="Liberation Serif"><?php echo $data->alamatlokasi_rumahsakit; ?></FONT>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <FONT FACE="Liberation Serif">Telp./Fax. <?php echo $data->no_telp_profilrs; ?> / <?php echo $data->no_faksimili; ?></FONT>
            </TD>
        </TR>
         <TR>
            <TD COLSPAN=2 HEIGHT=2 style="border-bottom: 3px solid #000000"></TD>
        </TR>
</table>