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
    
    .colon {
        padding-right: 5px;
        padding-left: 5px;
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

<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>No. Pengajuan Klaim</td>
                    <td class="colon">: </td>
                    <td width="100%"><?php echo CHtml::encode(($modPengajuanKlaim->nopengajuanklaimanklaim)); ?> / </td>
                    

                    <td nowrap>Cara Bayar / Penjamin</td>
                    <td class="colon">: </td>
                    <td nowrap> <?php echo CHtml::encode(($modPengajuanKlaim->carabayar->carabayar_nama ."/".$modPengajuanKlaim->penjamin->penjamin_nama)); ?> </td>
                </tr>
                
                <tr>
                    <td nowrap>Tgl. Pengajuan Klaim</td>
                    <td class="colon">: </td>
                    <td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPengajuanKlaim->tglpengajuanklaimanklaim)); ?> </td>
                    

                    <td>Tgl. Jatuh Tempo</td>
                    <td class="colon">: </td>
                    <td nowrap> <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPengajuanKlaim->tgljatuhtempo)); ?> </td>
                </tr>
                
                <tr>
                    <td>Total Piutang</td>
                    <td class="colon">: </td>
                    <td><?php echo CHtml::encode(number_format($modPengajuanKlaim->totalpiutang,0,"",".")); ?> </td>
                    

                    <td>Total Sisa Piutang</td>
                    <td class="colon">: </td>
                    <td nowrap> <?php echo CHtml::encode(number_format($modPengajuanKlaim->totalsisapiutang,0,"",".")); ?> </td>
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
            <table width="100%" style='box-shadow:none;margin-left:auto; margin-right:auto;' class='table border'>
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
                    
                    foreach ($modPengajuanKlaimDetail as $i => $pengajuan) {
				?>
					<tr>
						<td><?php echo MyFormatter::formatDateTimeForUser($pengajuan->pendaftaran->tgl_pendaftaran); ?></td>
						<td><?php echo $pengajuan->pendaftaran->no_pendaftaran; ?></td>
						<td><?php echo $pengajuan->pasien->no_rekam_medik; ?></td>
						<td><?php echo $pengajuan->pasien->nama_pasien; ?></td>
						<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pengajuan->jmlpiutang); ?></td>
						<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pengajuan->jumlahbayar); ?></td>
						<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pengajuan->jmltelahbayar); ?></td>
						<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pengajuan->jmlsisapiutang); ?></td>
					</tr>
				<?php 
					$total_piutang = $total_piutang + ($pengajuan->jmlpiutang);
					$total_bayar = $total_bayar + $pengajuan->jumlahbayar;
					$total_telah_bayar = $total_telah_bayar + $pengajuan->jmltelahbayar;
					$total_sisa_piutang = $total_sisa_piutang + $pengajuan->jmlsisapiutang;
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
        </td>
    </tr>
</table>
