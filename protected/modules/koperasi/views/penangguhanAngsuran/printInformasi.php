<style>	
		h1{
		font-size: 16px;
		margin-top: 0px;
	}
.header{
		text-align: center;
		padding-right: 100px;
	}
	hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
	}	
body, table{
		width: 1200px;	
		font-size: 11px;
   	margin-left: auto;
    	margin-right: auto;
	}
.tabel td, 	th{
	border:1px solid black;
}
</style>
<table width="100%">
<tr>
<td>
<?php echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>50)); ?>
</td>
<td class="header"><h1>
	<b>KOPERASI PEGAWAI REPUBLIK INDONESIA<br>
	<?php echo $profil->nama_profil; ?></b><br>
	<?php echo $profil->badanhukum; ?>
</h1>
</td>
</tr>
</table>
<hr class="symbol" />
<center>
	<h1>
		<u>INFORMASI PERMINTAAN PENANGGUHAN</u>
	</h1>
</center>
<div>
	<?php if(!empty($periode)) echo "Tgl Periode : ".$periode;?><br/>
	Tanggal Cetak : <?php echo MyFormatter::formatDateTimeId(date('d m Y')); ?> <br/>
	Dicetak Oleh : <?php echo Yii::app()->user->name; ?>
</div>
		<?php	
		$provider = $penangguhan->searchInformasi();
		$provider->pagination = false;
		$this->widget('bootstrap.widgets.TbGridView',array(
				'id'=>'penangguhanangsuran-m-grid',
				'dataProvider'=>$provider,
				'filter'=>null,
				'itemsCssClass' => 'table-bordered datatable dataTable',
				'enableSorting'=>false,
				'columns'=>array(
					array(
						'name'=>'tglpermpenangguhan',
						'value'=>'date("d/m/Y", strtotime($data->tglpermpenangguhan));',
					),
					'nokeanggotaan',
					'nama_pegawai',
					'jnspenangguhan',
					array(
						'name'=>'jumlahpinjaman',
						'value'=>'MyFormatter::formatNumberForPrint($data->jumlahpinjaman)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'name'=>'kesanggupanbayar',
						'value'=>'MyFormatter::formatNumberForPrint($data->kesanggupanbayar)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'name'=>'sisapinjaman',
						'value'=>'MyFormatter::formatNumberForPrint($data->sisapinjaman)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					), 
				),
				//'afterAjaxUpdate'=>'function(id, data) {registerNum(); hitungTotalAngsuran(); }',
			));
		?>