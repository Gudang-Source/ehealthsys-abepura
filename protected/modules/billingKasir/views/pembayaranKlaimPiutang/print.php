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
');
?>

<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%">
                        <label class='control-label'>
                            No. Pembayaran Klaim:
                        </label>
                            <?php echo CHtml::encode(($modPembayaranKlaim->nopembayaranklaim)); ?> / 
                    </td>
                    <Td width="5%"></td>
                    <td>
                        <label class='control-label'>
                            Cara Bayar / Penjamin :
                        </label>
                        <?php
                            echo CHtml::encode(($modPembayaranKlaim->carabayar->carabayar_nama ."/".$modPembayaranKlaim->penjamin->penjamin_nama));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Tgl. Pembayaran Klaim:
                        </label>
                        <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPembayaranKlaim->tglpembayaranklaim)); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Cara Pembayaran:
                        </label>
                        <?php
                            echo CHtml::encode($modPembayaranKlaim->pembayaranmelalui);   
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Total Piutang:
                        </label>
                            <?php echo CHtml::encode(MyFormatter::formatNumberForUser($modPembayaranKlaim->totalpiutang)); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Total Bayar:
                        </label>
                            <?php echo CHtml::encode(MyFormatter::formatNumberForUser($modPembayaranKlaim->totalbayar)); ?>
                    </td>
                </tr>                
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <div align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
                <?php // echo strtoupper($judulKuitansi);?>
            </div>
            <?php
                $totalbiayaadminfarmasi = 0;
                $row = array();
            ?>
            <table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
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
                        <td colspan="7"><div class='pull-right'>Total Piutang</div></td>
                        <td style="text-align:right;"><?php echo number_format($total_piutang,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="7"><div class='pull-right'>Total Bayar</div></td>
                        <td style="text-align:right;"><?php echo number_format($total_bayar,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="7"><div class='pull-right'>Total Telah Bayar</div></td>
                        <td style="text-align:right;"><?php echo number_format($total_telah_bayar,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="7"><div class='pull-right'>Total Sisa Piutang</div></td>
                        <td style="text-align:right;"><?php echo number_format((isset($total_sisa_piutang)?$total_sisa_piutang:0),0,',','.');?></td>
                    </tr>                    
                </tfoot>
                
            </table>
        </td>
    </tr>
</table>
