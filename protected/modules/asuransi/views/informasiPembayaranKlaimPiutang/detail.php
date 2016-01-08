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
			'value'=>'$data->tgl_pendaftaran',
		),
		array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->no_pendaftaran',
		),
		array(
			'name'=>'nama_pasien',
			'value'=>'$data->nama_pasien',
		),
		array(
			'name'=>'jmlpiutang',
			'value'=>'$data->jmlpiutang',
		),
		array(
			'name'=>'jmltelahbayar',
			'value'=>'$data->jmltelahbayar',
		),
		array(
			'name'=>'jumlahbayar',
			'value'=>'$data->jumlahbayar',
		),
		array(
			'name'=>'jmlsisapiutang',
			'value'=>'$data->jmlsisapiutang',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>