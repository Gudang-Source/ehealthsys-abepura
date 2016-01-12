<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('#rekonsiliasibank-info-search').submit(function(){
	$('#informasirekonsiliasibank-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasirekonsiliasibank-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
	<legend class="rim2">Informasi Rekonsiliasi <b>Bank</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Rekonsiliasi Bank</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasirekonsiliasibank-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No. Rekonsiliasi Bank',
					'type'=>'raw',
					'value'=>'$data->rekonsiliasibank_no',
				),
				array(
					'header'=>'Tanggal Rekonsiliasi Bank',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->rekonsiliasibank_tgl)',
				),
				array(
					'header'=>'Bank',
					'type'=>'raw',
					'value'=>'$data->namabank',
				),
				array(
					'header'=>'Jenis Rekonsiliasi Bank',
					'type'=>'raw',
					'value'=>'$data->jenisrekonsiliasibank_nama',
				),
				array(
					'header'=>'Kode Rekening',
					'type'=>'raw',
					'value'=>'$data->getKodeRekening()',
				),
				array(
					'name'=>'Nama Rekening',
					'type'=>'raw',
					'value'=>'$data->getNamaRekening()',
				),
				array(
					'name'=>'Saldo Debit',
					'type'=>'raw',
					'value'=>'number_format($data->saldodebit)',
					'htmlOptions'=>array(
						'style'=>'text-align:right;',
					),
				),
				array(
					'name'=>'Saldo Kredit',
					'type'=>'raw',
					'value'=>'number_format($data->saldokredit)',
					'htmlOptions'=>array(
						'style'=>'text-align:right;',
					),
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
 </div>
<fieldset class="box search-form">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,'format'=>$format
	)); ?>
</fieldset><!-- search-form -->