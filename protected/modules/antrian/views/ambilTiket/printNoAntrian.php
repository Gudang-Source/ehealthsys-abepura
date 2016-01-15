
<table style='width:100%;' >
    <tr>
        <td colspan="2" style="font-size: 50px;">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?>
        </td>
        </tr>
    <tr>
       <td width="30%" colspan="1" style="text-align: left">
               <b><?=  strtoupper(date('d M Y')); ?></b> 
        </td>
       <td width="30%" colspan="1" style="text-align: right">
           <b><?= strtoupper(date('H:i:s')); ?></b>  
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <center>
           <b>NO. ANTRIAN <?php echo strtoupper($modAntrian->loket->loket_nama); ?></b>  
           <br>
           </center>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding:20px;margin:10px;border:0px;">
           <center>
           <b><font style="font-size: 50px;"><?php echo strtoupper($modAntrian->loket->loket_singkatan."-".$modAntrian->noantrian) ?></font></b>  
           <br>
           </center>
               </div>
        </td>
    </tr>
</table>
</b></font>
</center>