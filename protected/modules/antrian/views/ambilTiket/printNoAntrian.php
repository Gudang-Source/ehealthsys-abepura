
<table style='width:100%; margin-top:7%;' >
    <tr>
        <td colspan="3" style="font-size: 50px;">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?>
        </td>
        </tr>
    <tr>
       <td width="30%" colspan="1" >
           <center>
               <b><?=  strtoupper(date('d M Y')); ?></b>   
           <br>
           </center>
        </td>
       <td colspan="1">
           <center>
           <br>
           </center>
        </td>
       <td width="30%" colspan="1" >
           <center>
           <b><?= strtoupper(date('H:i:s')); ?></b>  
           <br>
           </center>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <center>
           <b>NO. ANTRIAN <?php echo strtoupper($modAntrian->loket->loket_nama." (".$modAntrian->loket->loket_singkatan).")"; ?></b>  
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
    <tr  style="margin:10px 0 0 20px;">
       <td width="100%" colspan="3">
           <center><b>&nbsp;.</b></center>
        </td>
    </tr>
</table>
</b></font>
</center>