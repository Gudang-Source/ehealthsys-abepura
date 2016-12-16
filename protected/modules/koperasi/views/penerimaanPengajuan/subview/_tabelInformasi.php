<div class="panel panel-primary col-sm-12">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Data Penerimaan Pemotongan</div>  
	</div>
	<div class="panel-body col-sm-12">
		<?php	$this->widget('bootstrap.widgets.TbGridView',array(
				'id'=>'penerimaanpemotongan-m-grid',
				'dataProvider'=>$penerimaanPemotongan->search(),
				'filter'=>null,
				'itemsCssClass' => 'table-bordered datatable dataTable',
				'columns'=>array(
					array(
						'header'=>'Tgl BKM /<br/>No BKM',
						'name'=>'tglbuktibayar',
						'type'=>'raw',
						'value'=>'date("d/m/Y H:i", strtotime($data->tglbuktibayar))."<br/>".$data->nobuktimasuk',
					), /*
					array(
						'header'=>'No BKM',
						'name'=>'nobuktimasuk',
					), */
					array(
						'name'=>'namaunit',
						'headerHtmlOptions'=>array('style'=>'vertical-align:middle;color:#373E4A'),
						),
					'namapotongan',
					'nokeanggotaan',
					array(
						'header'=>'Nama Anggota',
						'name'=>'nama_pegawai',
						),
					array(
						'name'=>'simpananwajib',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpananwajib)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'name'=>'simpanansukarela',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpanansukarela)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'header'=>'Pokok Angsuran',
						'name'=>'jmlpokok_byrangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'name'=>'jmljasa_byrangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmljasa_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'header'=>'Denda Angsuran',
						'name'=>'jmldenda_byrangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmldenda_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'header'=>'Total Pengajuan',
						'name'=>'jmlpengajuan_pengangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpengajuan_pengangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'header'=>'Total Potongan',
						'name'=>'jmlbayar_pembangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlbayar_pembangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'header'=>'Sisa',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpengajuan_pengangsuran - $data->jmlbayar_pembangsuran)',					
						'htmlOptions'=>array('style'=>'text-align: right'),
						'headerHtmlOptions'=>array('style'=>'vertical-align:middle;color:#373E4A'),					
					)
					/*
					array(
						'header'=>'Penangguhan',
						'type'=>'raw',
						'value'=>function($data) {
							return CHtml::link('<i class="entypo-publish"></i>', Yii::app()->controller->createUrl('penangguhan', array('id'=>1)), array('target'=>'_blank'));
						},
						'htmlOptions'=>array('style'=>'text-align: center'),
					),	*/			
				),
				//'afterAjaxUpdate'=>'function(id, data) {registerNum(); hitungTotalAngsuran(); }',
			));
		?>
	</div>
	<div class="panel-body col-sm-12">
		<?php  echo Chtml::link('<i class="entypo-print"></i> Print','#', array('class' => 'btn btn-success', 'onclick'=>'iPrint(); return false;')); ?>
	</div>
</div>