
<table style='width:100%; margin-left:20%; margin-top:7%;' >
    <tr>
        <td colspan="3" style="font-size: 50px;">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>'Antrian Farmasi')); ?>
        </td>
        </tr>
    <tr>
       <td width="30%" colspan="1" >
           <center>
           <b><?=date('d M Y'); ?></b>   
           <br>
           </center>
        </td>
       <td colspan="1">
           <center>
           <br>
           </center>
        </td>
       <td width="50%" colspan="1" >
           <center>
           <b><?=date('H:i:s'); ?></b>  
           <br>
           </center>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <center>
           <b>No. Antrian <?php echo $modAntrian->racikan->racikan_singkatan; ?></b>  
           <br>
           </center>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding:20px;margin:10px;border:0px;">
           <center>
           <b><font style="font-size: 50px;"><?php echo $modAntrian->racikan->racikan_singkatan."-".$modAntrian->noantrian; ?></font></b>  
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



<?php 

Yii::app()->clientScript->registerScript('onend','
//        var printContents = document.getElementById("printArea").innerHTML;
     var originalContents = document.body.innerHTML;

//     document.body.innerHTML = printContents;

     window.print();

     

     ', CClientScript::POS_END); ?>
    