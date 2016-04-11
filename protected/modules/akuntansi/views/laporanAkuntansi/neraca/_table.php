<?php
    Yii::app()->clientScript->registerScript('cari cari', "
        $('#search-form').submit(function(){
                $('#tableLaporan').addClass('srbacLoading');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;	
	$caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
	$table = "table table-striped table-condensed";
    if (isset($caraPrint)){
		$layout = '';
		$table = 'table table-striped';
//        $data = $modelLaporan->searchNeraca();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
		$layout = 'max-width:1250px;overflow-x:scroll;';
    }
?>
<div id="tableLaporan" class="grid-view" style="<?php echo $layout; ?>">
  <table class="<?php echo $table; ?>">
    <thead>
      <tr>
        <th id="tableLaporan_c0">
            Nama Rekening
        </th>
        <th id="tableLaporan_c0">
            Total Saldo
        </th>
      </tr>
    </thead>
    <tbody>
        <?php
			$periodeposting_id = isset($_GET['AKLaporanneracaV']['periodeposting_id']) ? $_GET['AKLaporanneracaV']['periodeposting_id'] : isset($modelLaporan->periodeposting_id) ? $modelLaporan->periodeposting_id : null;
			$ruangan_id = isset($_GET['AKLaporanneracaV']['ruangan_id']) ? $_GET['AKLaporanneracaV']['ruangan_id'] : isset($modelLaporan->ruangan_id) ? $modelLaporan->ruangan_id : null;
			$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$pendapatan_aktiva = 0; //AKLaporanneracaV::model()->getSaldoNeraca($periodeposting_id,$ruangan_id,'ACTIVA');
			$pendapatan_passiva = 0; //AKLaporanneracaV::model()->getSaldoNeraca($periodeposting_id,$ruangan_id,'PASSIVA');
//			if (count($model)>0){				
        ?>

        <!----------------- BEGIN ACTIVA ---------------------------------------------->
        <tr>
			<td style="height: 30px; vertical-align: middle;"><b><i>AKTIVA</i></b></td>
			<td style="height: 30px; vertical-align: middle;text-align: right;font-weight: bold;"><?php echo isset($pendapatan_aktiva) ? number_format($pendapatan_aktiva,0) : 0; ?></td>
		</tr>
        <?php		
			$jml_aktiva = 0;
			if (count($model)>0){	
			foreach($model as $a=>$laporan_detail){
				if($laporan_detail->kelompokneraca == 'ACTIVA'){
					$jml_aktiva += $laporan_detail->saldoakhirberjalan;
		?>
		<tr>
			<td><strong><?php echo $spasi."".$laporan_detail->getNamaRekening(); ?></strong></td>
			<td style='text-align:right;'><?php echo number_format($laporan_detail->saldoakhirberjalan); ?></td>

		<?php } 
			}
		?>
		</tr>
		<?php } ?>
        <tr>
            <td style="text-align: right; padding-right: 1em"><i><b>TOTAL AKTIVA &nbsp; &nbsp;</b></i></td>
            <?php
				echo "<td style='text-align:right;'><b><i>".number_format($jml_aktiva,0)."</b></i></td>";
            ?>
        </tr>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>
        <!----------------- END ACTIVA ---------------------------------------------->
        
        
        <!----------------- BEGIN PASSIVA ---------------------------------------------->
        <tr>
			<td style="height: 30px; vertical-align: middle;"><b><i>PASSIVA</i></b></td>
			<td style="height: 30px; vertical-align: middle;text-align: right;font-weight: bold;"><?php echo isset($pendapatan_passiva) ? number_format($pendapatan_passiva,0) : 0; ?></td>
		</tr>
        <?php		
			$jml_passiva = 0;
			if (count($model)>0){	
			foreach($model as $a=>$laporan_detail){
				if($laporan_detail->kelompokneraca == 'PASSIVA'){
					$jml_aktiva += $laporan_detail->saldoakhirberjalan;
		?>
		<tr>
			<td><strong><?php echo $spasi."".$laporan_detail->getNamaRekening(); ?></strong></td>
			<td style='text-align:right;'><?php echo number_format($laporan_detail->saldoakhirberjalan); ?></td>

		<?php } 
			}
		?>
		</tr>
		<?php } ?>
        <tr>
            <td style="text-align: right; padding-right: 1em"><i><b>TOTAL PASSIVA &nbsp; &nbsp;</b></i></td>
            <?php
				echo "<td style='text-align:right;'><b><i>".number_format($jml_passiva,0)."</b></i></td>";            
			?>
        </tr>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>
        <!----------------- END PASIVVA ---------------------------------------------->        
      <?php
//      }
      ?>
    </tbody>
  </table>
</div>