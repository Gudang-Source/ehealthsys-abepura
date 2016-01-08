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
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 48px;
    }
	.break { page-break-before: always; }
/*	table { page-break-inside:auto }
	tr    { page-break-inside:avoid; page-break-after:auto }*/
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerMcu'); 
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><?php echo $judul_print ?></b>
		</td>
	</tr>
</table><br/>

<table class="table-condensed" width="100%">
	<tr>
		<td width="100%">
			<strong>Analisa ini mengidentifikasi resiko terjadinya Penyakit Jantung Koroner selama 10 tahun kedepan</strong>
		</td>
	</tr>
</table>
<div class="row-fluid">
	<div class="span12">
		<!--<fieldset class="well">-->
			<table class="table-condensed" width="100%">	
			<tr>            
				<td width="100%">
					<table width="100%" id="form-riwayatpekerjaan-mcu" border="1">
						<thead>
							<tr>
								<th style='text-align:center;'>Faktor Resiko</th>
								<th style='text-align:center;'>Hasil</th>
								<th style='text-align:center;'>Level</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong>Total Kolesterol</strong></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->total_kolesterol; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->total_kolesterol_level; ?></td>
							</tr>
							<tr>
								<td><strong>Triglyceride</strong></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->triglycerida; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->triglycerida_level; ?></td>
							</tr>
							<tr>
								<td><strong>HDL Kolesterol</strong></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->hdl_kolesterol; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->hdl_kolesterol_level; ?></td>
							</tr>
							<tr>
								<td><strong>LDL Kolesterol</strong></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->ldl_kolesterol; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->ldl_kolesterol_level; ?></td>
							</tr>
							<tr>
								<td><strong>Tekanan Darah</strong></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->tekanandarah; ?></td>
								<td style="text-align: center;"></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td width="100%">
					Resiko Serangan Jantung dalam 10 tahun &nbsp;&nbsp;&nbsp; (Hasil Presentase <?php echo !empty($modJantungKoroner->hasil_resiko_persen)? ": ".$modJantungKoroner->hasil_resiko_persen.'%':'<i> - </i>'; ?>)
				</td>
			</tr>
			<tr>
				<td width="100%">
					Hasil dari review faktor Resiko Jantung Koroner Lainnya
				</td>
			</tr>
		</table>
		<table class="table-condensed" width="100%">
			<tr>            
				<td>
					<strong>Hasil Review</strong>
				</td>
				<td>
					<div style="border:2px solid black;">
						<p align="justify"><?php echo $modJantungKoroner->hasil_review_ab; ?></p>
					</div>
				</td>
			</tr>
			<tr>            
				<td>
					<strong>Gangguan Metabolisme</strong>
				</td>
				<td>
					<?php
						if(empty($modJantungKoroner->gangguan_metabolisme)){
							$style = 'style="border:2px solid black;padding-bottom: 50px;"';
						}else{
							$style='style="border:2px solid black;"';
						}
					?>
					<div <?php echo $style; ?>>
						<p align="justify"><?php echo $modJantungKoroner->gangguan_metabolisme; ?></p>
					</div>
				</td>
			</tr>
		</table>
		<!--</fieldset>-->
	</div>
</div>
<br/>
	
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
        var jantungkoroner_id = '<?php echo isset($modJantungKoroner->jantungkoroner_id) ? $modJantungKoroner->jantungkoroner_id : null ?>';
		var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&jantungkoroner_id='+jantungkoroner_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
<?php } ?>
