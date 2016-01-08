<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Pemakaianbarang Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasijadwalpegawai-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim2">Informasi Jadwal Pegawai</legend>
 <div class="block-tabel">
	<h6>Tabel <b>Jadwal Pegawai</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasijadwalpegawai-grid',
			'dataProvider'=>$model->searchInformasiJadwal(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No.',
					'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:right;'),
				),
				array(
					'header'=>'Shift',
					'name'=>'tglbuatjadwal',
					'type'=>'raw',
					'value'=>'"<b>".MyFormatter::formatDateTimeForUser($data->tglbuatjadwal)."</b> (".
						$data->shift_jamawal." - ".$data->shift_jamakhir.") - ".$data->shift_nama ."<b>(".$data->shift_kode.")</b>"',
				),
				array(
					'name'=>'ruangan_nama',
					'type'=>'raw',
					'value'=>'$data->ruangan_nama',
				),
				array(
					'header'=>'Nama Pegawai',
					'name'=>'nama_pegawai',
					'type'=>'raw',
				),
				array(
					'header'=>'Kelompok Pegawai',
					'name'=>'kelompokpegawai_nama',
					'type'=>'raw',
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