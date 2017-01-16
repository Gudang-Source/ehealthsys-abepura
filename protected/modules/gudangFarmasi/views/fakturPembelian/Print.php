<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  

<style>
	.det td, .det th {
		border: 1px solid black;
		padding: 2px;
	}
</style>

<?php
if(!$modFakturPembelianDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>No. Penerimaan Barang</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->noterima; ?></td>
            
            <?php if(count($modFakturPembelian) > 0){ ?>
            <td>No. Faktur</td>
            <td>:</td>
            <td><?php echo $modFakturPembelian->nofaktur; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Tanggal Penerimaan Barang</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenerimaanBarang->tglterima); ?></td>
            
            <?php if(count($modFakturPembelian) > 0){ ?>
            <td>Tanggal Faktur</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modFakturPembelian->tglfaktur); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>No. Surat Jalan</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->nosuratjalan; ?></td>
            
            <td>Tanggal Jatuh Tempo</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modFakturPembelian->tgljatuhtempo); ?></td>
        </tr>
        <tr>
            <td>Tanggal Surat Jalan</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenerimaanBarang->tglsuratjalan); ?></td>
        </tr>
        
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="det">
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Asal Barang</th>
            <th style="text-align: center;">Kategori / Nama Obat</th>
            <th style="text-align: center;">Jumlah Permintaan </th>
            <th style="text-align: center;">Jumlah Diterima</th>
            <th style="text-align: center;">Diskon (%)</th>
            <th style="text-align: center;">Diskon Total (Rp.)</th>
            <th style="text-align: center;">Harga Netto</th>
            <th style="text-align: center;">PPN (%)</th>
            <th style="text-align: center;">PPH (%)</th>
            <th style="text-align: center;">Sub Total</th>
        </thead>
		<tbody>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modFakturPembelianDetail as $i=>$modObat){ 
        ?>
            <tr>
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align:center;"><?php echo $modObat->jmlterima; ?></td>
                <td style="text-align:center;"><?php echo $modObat->jmlterima; ?></td>                
                <td style="text-align:center;"><?php echo $modObat->persendiscount; ?></td>
                <td style="text-align:right;"><?php echo $format->formatNumberForPrint($modObat->jmldiscount); ?></td>
                <td style="text-align:right;"><?php echo $format->formatNumberForPrint($modObat->harganettofaktur); ?></td>
                <td style="text-align:center;"><?php echo $modObat->persenppnfaktur; ?></td>
                <td style="text-align:center;"><?php echo $modObat->persenpphfaktur; ?></td>
                <td style="text-align:right;"><?php 
                    $subtotal = ($modObat->harganettofaktur * $modObat->jmlterima);
                    
                    if(!empty($modObat->persenppnfaktur)) {
                        $subtotal = (($modObat->harganettofaktur + ($modObat->harganettofaktur * ($modObat->persenppnfaktur/100))) * $modObat->jmlterima) ;            
                    }

                    if(!empty($modObat->persenpphfaktur)){
                        $subtotal = ($subtotal + ($subtotal * ($modObat->persenpphfaktur/100)));
                    }
					
					$subtotal -= $modObat->jmldiscount;
					
					$total += $subtotal;
					
                    echo $format->formatNumberForPrint($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="10" align="right"><strong>Total</strong></td>
				<td style="text-align:right;"><strong><?php echo $format->formatNumberForPrint($total); ?></strong></td>
			</tr>
		</tfoot>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        fakturpembelian_id = '<?php echo isset($modFakturPembelian->fakturpembelian_id) ? $modFakturPembelian->fakturpembelian_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&fakturpembelian_id='+fakturpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
<!--                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php //echo $data['pegawaimengetahui']; ?></div>
                    </td>-->
                    <td width="35%" align="center">
<!--                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php //echo $data['pegawaimenyetujui']; ?></div>-->
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>
                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php echo isset($modFakturPembelian->pegawai->NamaLengkap) ? $modFakturPembelian->pegawai->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
