<div class="span11">
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'asinfoklaimpiutang-t-grid',
	'dataProvider'=>$modDetail->searchDetail($id),
	'template'=>"{items}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
		),
		array(
			'name'=>'tgl_pendaftaran',
			'value'=>'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)',
		),
		array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->pendaftaran->no_pendaftaran',
		),
		array(
			'name'=>'nama_pasien',
			'value'=>'$data->pasien->namadepan." ".$data->pasien->nama_pasien',
		),
		array(
			'name'=>'jmlpiutang',
			'value'=>'number_format($data->jmlpiutang,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
			'name'=>'jmltelahbayar',
			'value'=>'number_format($data->jmltelahbayar,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
			'name'=>'jumlahbayar',
			'value'=>'number_format($data->jumlahbayar,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
			'name'=>'jmlsisapiutang',
			'value'=>'number_format($data->jmlsisapiutang,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>