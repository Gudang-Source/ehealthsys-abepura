<style>
	.table {
		border-collapse: collapse;
		box-shadow: none;
	}
	
	.table th, .table td, .table tbody {
		background-color: white !important;
		border: 1px solid black !important;
	}
</style>

<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
$data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
$colspan = 12; ?>
<table width="100%">
        <TR>
            <TD ROWSPAN=3 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
            </TD>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <B><FONT FACE="Liberation Serif" SIZE=5 color="black"><?php echo $judulLaporan; ?></FONT></B>
            </TD>
        </TR>
         <TR>
             <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>"><b>
                     <FONT FACE="Liberation Serif" SIZE=4 color="black"><?php echo Yii::app()->user->getState('nama_rumahsakit'); ?></FONT></b>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan=" <?php echo (!empty($colspan)) ? ($colspan-1) : "5"; ?>">
                <B><FONT FACE="Liberation Serif" SIZE=4 color="black">TANGGAL : <?php echo str_replace(" 23:59:59","",MyFormatter::formatDateTimeId($tanggal)); ?></FONT></B>
            </TD>
        </TR>
         <TR>
            <TD colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" HEIGHT=2 style="border-bottom: 3px solid #000000" ></TD>
        </TR>
</table>
<br>
<?php
if ($caraPrint != 'GRAFIK')
$this->renderPartial('_table', array('model'=>$model, 'modDetail'=>$modDetail,'caraPrint'=>$caraPrint, 'data'=>$data,'rincianUang'=>$rincianUang)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
?>

<br>
<br>
<table class="table-condensed" style="width:100%">
    <tr>
        <td align="left">
            <p style="text-align: left;">
                &nbsp;&nbsp;&nbsp;Mengetahui<br>
             &nbsp;&nbsp;&nbsp;KPA BLUD<br>
             <br>
             <br>
             <br>
             <br>
             <br>
             &nbsp;&nbsp;&nbsp;---------------------------------------------<br>
             &nbsp;&nbsp;&nbsp;&nbsp;NIP.
            </p>
        </td>
        <td align="right">
            <p style="text-align: right;">
                <?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?> &nbsp;&nbsp;&nbsp;<br>
             Bendahara Penerimaan&nbsp;&nbsp;&nbsp;&nbsp;<br>
             <br>
             <br>
             <br>
             <br>
             <br>
             ---------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;<br>
             NIP.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </p>
        </td>
    </tr>
</table>