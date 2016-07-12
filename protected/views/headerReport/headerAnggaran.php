<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table style="margin:0 auto;">
        <TR>
            <TD ROWSPAN=3 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
            </TD>
            <TD style = "text-align: center;" ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <B><FONT FACE="Liberation Serif" SIZE=5 color="black"><?php echo $data->nama_rumahsakit ?></FONT></B>
            </TD>
        </TR>
         <TR>
            <TD  style = "text-align: center;" ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black"><?php echo $data->alamatlokasi_rumahsakit ?></FONT>
            </TD>
        </TR>
         <TR>
            <TD  style = "text-align: center;" ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT>
            </TD>
        </TR>
</table>
<table style="margin:0 auto;" width="100%">
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" HEIGHT=2 style="border-bottom: 3px solid #000000" ></TD>
        </TR>
</table>
<table style="margin:0 auto; ">
        <?php
            if(isset($judulLaporan) || strlen($judulLaporan) > 0){
        ?>
             <TR>
				 <TD style="border-bottom: 2px solid #000000; text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3><?php echo $judulLaporan ?></h3></font></TD>
            </TR>
        <?php
            }
        ?>
        <?php
            $deskripsi = (isset($deskripsi) ? $deskripsi : null);
            if(isset($deskripsi) || strlen($deskripsi) > 0){
        ?>
             <TR>
				 <TD style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE><font color="black"><?php echo $deskripsi ?></font></TD>
            </TR>  
        <?php
            }
        ?>
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE></TD>
        </TR>  
</table>