<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
$format = new MyFormatter;
?>

<style>
 
    tr:last-child > td:first-child 
    {
        border-bottom-left-radius: 0px;
    }    
    
    .table
    {
        border: 1px solid #000;
        border-radius: 0px 0px 0px 0px;
        box-shadow: 0px 0px 0px 0px;
    }

    .table-striped tbody tr:nth-child(2n+1) td
    {
        background-color: #fff;
    }

    .table th
    {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;

    }

    .c th + th, .c td + td, .c th + td, .c td + th 
    {
        border-left: 1px solid #000;

    }
   
    .d th + th, .d td + td, .d th + td, .d td + th 
    {
        border-left: 0px;

    }
    
    table.d{
        border:0px;
    }
    
    
   thead th {
    background: none;
    border-bottom: 4px solid #6B994D;
    color: #333333;
    }
</style>

<table class='table d' style = "border: 0px;">
    <tr>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nopenerimaan')); ?>:</b>
            <?php echo CHtml::encode($modTerima->nopenerimaan); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglterima')); ?>:</b>
            <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(CHtml::encode(MyFormatter::formatDateTimeForDb($modTerima->tglterima))))); ?>
             <br/>
             
        </td>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('peg_penerima_id')); ?>:</b>
            <?php echo CHtml::encode($modTerima->penerima->nama_pegawai); ?>
            <br />
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('ruanganpenerima_id')); ?>:</b>
            <?php echo CHtml::encode($modTerima->ruangan->ruangan_nama); ?>
            <br />            
        </td>
        <?php
            if ($modTerima->nofaktur != ''):
        ?>
                 <td>
                    <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nofaktur')); ?>:</b>
                   <?php echo CHtml::encode($modTerima->nofaktur); ?>
                   <br />
                   <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglfaktur')); ?>:</b>
                   <?php echo CHtml::encode($modTerima->tglfaktur); ?>
                   <br />
                   <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tgljatuhtempo')); ?>:</b>
                   <?php echo CHtml::encode($modTerima->tgljatuhtempo); ?>
                   <br />
                             
               </td>
        <?php
           endif;  
        ?>
      
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed c">
    <thead>
        <th>No.Urut</th>
        <th>Bidang</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Sub Sub Kelompok</th>
        <th>Barang</th>
        <th>Harga Beli</th>
        <th>Harga Satuan</th>
        <th>Jumlah Terima</th>
        <!--<th>Satuan</th>-->
        <th>Ukuran<br/>Bahan</th>
        <th>Subtotal</th>
    </thead>
    <tbody>
    <?php
    $total = 0;     
    $no=1;
   
        foreach($modDetailTerima AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); 
              
               
              $subtotal = ($detail->hargasatuan * $detail->jmlterima);
              $total = $total + $subtotal;
              
        ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama:'-'; ?></td>
                <td><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:'-'; ?></td>
                <td><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:'-'; ?></td>
                <td><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subsubkelompok_nama:'-'; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td style = "text-align:right;"><?php echo $format->formatNumberForPrint($detail->hargabeli); ?></td>
                <td style = "text-align:right;"><?php echo $format->formatNumberForPrint($detail->hargasatuan); ?></td>
                <td style = "text-align:right;"><?php echo $format->formatNumberForPrint($detail->jmlterima).' '.$detail->satuanbeli; ?></td>
               <!-- <td><?php //echo $detail->satuanbeli; ?></td>-->
                <td><?php echo $modBarang->barang_ukuran; ?><br/><?php echo $modBarang->barang_bahan; ?></td>
                <td style = "text-align:right;"><?php echo $format->formatNumberForPrint(($detail->hargasatuan * $detail->jmlterima)) ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
     
         $diskon = $modTerima->discount;
         $ppn = $modTerima->pajakppn;
         $pph = $modTerima->pajakpph;
         $biayaadmin = $modTerima->biayaadministrasi;
         $totalseluruh = ($total - $diskon) + $ppn + $pph + $biayaadmin;
    ?>
            <tr>
                <td colspan = "10" style = "text-align:right;border-top: 1px solid #000;"><b>Total</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo $format->formatNumberForPrint($total); ?></b></td>
            </tr>
             <tr>
                <td colspan = "10" style = "text-align:right;border-top: 1px solid #000;"><b>Diskon</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo $format->formatNumberForPrint($diskon); ?></b></td>
            </tr>
            <tr>
                <td colspan = "10" style = "text-align:right;border-top: 1px solid #000;"><b>Biaya Administrasi</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo $format->formatNumberForPrint($biayaadmin); ?></b></td>
            </tr>
            <tr>
                <td colspan = "10" style = "text-align:right;border-top: 1px solid #000;"><b>PPH</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo $format->formatNumberForPrint($pph); ?></b></td>
            </tr>
             <tr>
                <td colspan = "10" style = "text-align:right;border-top: 1px solid #000;"><b>PPN</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo $format->formatNumberForPrint($ppn); ?></b></td>
            </tr>
             <tr>
                <td colspan = "10" style = "text-align:right;border-top: 1px solid #000;"><b>Total Keseluruhan</b></td>
                <td style = "border-top: 1px solid #000;text-align:right;"><b><?php echo  $format->formatNumberForPrint($totalseluruh); ?></b></td>
            </tr>
    </tbody>
</table>
<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table width="100%">
				<tr>
					<td width="35%" align="center">						
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Yang Mengetahui</div>
						<div style="margin-top:60px;"><?php echo isset($modTerima->peg_mengetahui_id) ? $modTerima->mengetahui->NamaLengkap : "" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT');"));
    //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 

?>
<script type='text/javascript'>
    /**
     * print
     */    
    function print(caraprint)
    {        
        var terimapersediaan_id = '<?php echo $modTerima->terimapersediaan_id; ?>';
        // alert('<?php //echo $this->createUrl('print'); ?>&id='+terimapersediaan_id+'&caraPrint='+caraprint);
        
        window.open('<?php echo $this->createUrl('print'); ?>&id='+terimapersediaan_id+'&caraPrint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    };                                                             
  </script>
<?php } ?>
 