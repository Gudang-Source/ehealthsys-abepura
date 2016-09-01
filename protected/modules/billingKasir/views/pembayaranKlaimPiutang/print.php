<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulKuitansi.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulKuitansi));      
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
       .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
');
?>


<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td>           
            <b>No. Pembayaran Klaim</b>            
        </td>
        <td><?php echo ": ".CHtml::encode(($modPembayaranKlaim->nopembayaranklaim)); ?> / </td>
        <td>&nbsp;</td>
        <td>           
            <b>Cara Bayar / Penjamin  </b>          
        </td>
        <td>
            <?php
                echo ": ".CHtml::encode(($modPembayaranKlaim->carabayar->carabayar_nama ."/".$modPembayaranKlaim->penjamin->penjamin_nama));
            ?>
        </td>
    </tr>
    <tr>
        <td>            
                <b>Tgl. Pembayaran Klaim</b>            
        <td>
            <?php echo ": ".CHtml::encode(MyFormatter::formatDateTimeForUser($modPembayaranKlaim->tglpembayaranklaim)); ?>
        </td>
        <Td>&nbsp;</td>
        <td>               
                <b>Cara Pembayaran</b>            
        </td>
        <td>
            <?php
                echo ": ".CHtml::encode($modPembayaranKlaim->pembayaranmelalui);   
            ?>
        </td>
    </tr>
    <tr>
        <td>            
                <b>Total Piutang</b>            
        </td>
        <td>
                <?php echo ": ".CHtml::encode(number_format($modPembayaranKlaim->totalpiutang,0,"",".")); ?>
        </td>
        <Td>&nbsp;</td>
        <td>               
                <b>Total Bayar</b>            
        </td>
        <td>
                <?php echo ": ".CHtml::encode(number_format($modPembayaranKlaim->totalbayar,0,"",".")); ?>
        </td>
    </tr>                
</table>            
     <br/>
<?php
    $totalbiayaadminfarmasi = 0;
    $row = array();
?>
<table width="100%" style='margin-left:auto; margin-right:auto;box-shadow:none;' class='table border'>
    <thead>
        <tr>
            <th>Tgl. Pendaftaran</th>
            <th>No. Pendaftaran</th>
            <th>No. Rekam Medik</th>
            <th>Nama Pasien</th>
            <th class="tengah">Jumlah Piutang (Rp)</th>
            <th class="tengah">Jumlah Bayar</th>
            <th class="tengah">Jumlah Telah Bayar (Rp)</th>
            <th class="tengah">Jumlah Sisa Piutang (Rp)</th>
        </tr>
    </thead>
                    <tbody>
    <?php
        $total_piutang = 0;
        $total_bayar = 0;
        $total_telah_bayar = 0;
        $total_sisa_piutang = 0;                   

        foreach ($modPembayaranKlaimDetail as $i => $pembayaran) {
                    ?>
                            <tr>
                                    <td><?php echo MyFormatter::formatDateTimeForUser($pembayaran->pendaftaran->tgl_pendaftaran); ?></td>
                                    <td><?php echo $pembayaran->pendaftaran->no_pendaftaran; ?></td>
                                    <td><?php echo $pembayaran->pasien->no_rekam_medik; ?></td>
                                    <td><?php echo $pembayaran->pasien->nama_pasien; ?></td>
                                    <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pembayaran->jmlpiutang); ?></td>
                                    <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pembayaran->jumlahbayar); ?></td>
                                    <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pembayaran->jmltelahbayar); ?></td>
                                    <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pembayaran->jmlsisapiutang); ?></td>
                            </tr>
                    <?php 
                            $total_piutang = $total_piutang + $pembayaran->jmlpiutang;
                            $total_bayar = $total_bayar + $pembayaran->jumlahbayar;
                            $total_telah_bayar = $total_telah_bayar + $pembayaran->jmltelahbayar;
                            $total_sisa_piutang = $total_sisa_piutang + $pembayaran->jmlsisapiutang;
                            } 
                    ?>
                    </tbody>
     <tfoot>
        <tr>
            <td colspan="7"><div class='pull-right'><b>Total Piutang</b></div></td>
            <td style="text-align:right;"><b><?php echo number_format($total_piutang,0,',','.'); ?></b></td>
        </tr>
        <tr>
            <td colspan="7"><div class='pull-right'><b>Total Bayar</b></div></td>
            <td style="text-align:right;"><b><?php echo number_format($total_bayar,0,',','.'); ?></b></td>
        </tr>
        <tr>
            <td colspan="7"><div class='pull-right'><b>Total Telah Bayar</b></div></td>
            <td style="text-align:right;"><b><?php echo number_format($total_telah_bayar,0,',','.'); ?></b></td>
        </tr>
        <tr>
            <td colspan="7"><div class='pull-right'><b>Total Sisa Piutang</b></div></td>
            <td style="text-align:right;"><b><?php echo number_format((isset($total_sisa_piutang)?$total_sisa_piutang:0),0,',','.');?></b></td>
        </tr>                    
    </tfoot>

</table>
       