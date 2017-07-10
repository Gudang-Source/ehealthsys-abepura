<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>" class="headers">
    <TR>
        <!--<TD width="15%" height="50%">-->       
		<TD ROWSPAN=3 ALIGN=CENTER VALIGN=MIDDLE class="logo_profil">
			 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report' width="60"/>
		</TD>        
        <TD align="center" width="100%" COLSPAN="<?php echo (!empty($coljudul)?($coljudul-1):'2') ?>">
            <div align="center" class="nama_profil">
                <B>
                    <FONT FACE="Liberation Serif" SIZE=4 color="black">
                        <?php echo $data->nama_rumahsakit ?>
                    </FONT>
                </B>
            </div>            
        </TD>
    </TR>
	<TR>				
        <TD align="center" width="100%" COLSPAN="<?php echo (!empty($coljudul)?($coljudul-1):'2') ?>">           
            <div align="center" class="jalan_profil">
                <FONT FACE="Liberation Serif" color="black">
                    <?php echo $data->alamatlokasi_rumahsakit ?>
                </FONT>                
            </div>           
        </TD>
	</TR>
	<TR>			
        <TD align="center" width="100%" COLSPAN="<?php echo (!empty($coljudul)?($coljudul-1):'2') ?>">           
            <div align="center" class="kontak_profil">
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT>
            </div>
        </TD>
	</TR>
    <TR>
        <TD colspan="2" HEIGHT=2 style="border-bottom: 1px solid #000000">&nbsp;</TD>
    </TR>
    <TR>
        <TD ALIGN="CENTER" STYLE="text-align:center;" colspan="<?php echo (!empty($coljudul)?$coljudul:'2') ?>">
			<div align="center" class="nama_profil">
                <B>
                    <font color="black"><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></font>
                </B>
            </div>                       
        </TD>
	</TR>	
	<?php if (!empty($judulLaporan2)){ ?>
	<TR>
		<TD align="center" colspan="<?php echo (!empty($coljudul)?$coljudul:'2') ?>">
			<div align="center" class="jalan_profil">
                <font color="black"><?php echo ((isset($judulLaporan2)) ? $judulLaporan2 : null); ?></font>
            </div>			
		</TD>
	</TR>
	<?php } ?>
	
	<?php if (!empty($judulLaporan3)){ ?>
	<TR>
		<TD align="center" colspan="<?php echo (!empty($coljudul)?$coljudul:'2') ?>">
			<div align="center" class="jalan_profil">
                <font color="black"><?php echo ((isset($judulLaporan3)) ? $judulLaporan3 : null); ?></font>
            </div>			
		</TD>
	</TR>
	<?php } ?>
	
	<TR>
        <TD colspan="2" HEIGHT=2 style="border-bottom: 1px solid #000000">&nbsp;</TD>
    </TR>
</table>
<!--
<table width="100%" border="1">
        <TR>
            <TD ROWSPAN=4 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php //echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <B><FONT FACE="Liberation Serif" SIZE=4 color="black" style="margin-left: 20px"><?php echo $data->nama_rumahsakit ?></FONT></B>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php //echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black"><?php //echo $data->alamatlokasi_rumahsakit ?></FONT>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php //echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. <?php //echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></FONT>
            </TD>
        </TR>
         <TR>
            <TD colspan=" <?php //echo (!empty($colspan)) ? ($colspan) : "6"; ?>" HEIGHT=2 style="border-bottom: 1px solid #000000"></TD>
        </TR>
         <TR>
             <TD colspan=" <?php //echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h5><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h5></font></TD>
        </TR>
         <TR>
            <TD colspan=" <?php //echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE></TD>
        </TR>  
</table>-->