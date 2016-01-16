<style>
    body {
        font-size: 15px important;
    }
    .headers td .nama_profil font{
        font-size: 15px !important;
    }
    
    .headers .judul > font > h5, .details td {
        font-size: 10px !important;
    }
    
    .headers .logo_profil > img {
        width: 50px !important;
    }
</style>

<table style='width:100%;' class="details">
    <tr>
        <td colspan="2" style="font-size: 20px;">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?>
        </td>
        </tr>
    <tr>
        <td width="30%" colspan="1" style="text-align: left; font-weight: bold">
            <?= strtoupper(date('d M Y')); ?>
        </td>
        <td width="30%" colspan="1" style="text-align: right; font-weight: bold">
            <?= strtoupper(date('H:i:s')); ?>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3" style="text-align: center;">
           <b>NOMOR ANTRIAN <?php echo strtoupper($modAntrian->loket->loket_namalain); ?></b>  
           <br>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding:0px;margin:0px;border:0px;">
           <center>
           <b><font style="font-size: 35px;"><?php echo strtoupper($modAntrian->loket->loket_singkatan."-".$modAntrian->noantrian) ?></font></b>  
           <br>
           </center>
               </div>
        </td>
    </tr>
</table>
</b></font>
</center>