<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'gumutasibrg-t-grid',
	'dataProvider'=>$model->searchInformasi(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		'nomutasibrg',
		array(
			'name'=>'tglmutasibrg',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmutasibrg)',
		),
		array(
			'header'=>'Nama Pegawai Pengirim',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaipengirim)?$data->pegawaipengirim->nama_pegawai:"")',
		),
		array(
			'header'=>'Nama Pegawai Mengetahui',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaimengetahui)?$data->pegawaimengetahui->nama_pegawai:"")',
		),
		'totalhargamutasi',
		'ruangantujuan.ruangan_nama',
		'keterangan_mutasi',
		'pesanbarang.nopemesanan',
		array(
			'header'=>'Rincian',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("'.$controller.'/detailMutasiBarang",array("id"=>$data->mutasibrg_id)),array("id"=>"$data->mutasibrg_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Mutasi Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
		),
		array(
			'header'=>'Batal Mutasi',
			'type'=>'raw',
			'value'=>'($data->testingData == false) ? CHtml::link("<i class=\'icon-form-silang\'></i> ",  Yii::app()->controller->createUrl("'.$controller.'/batalMutasiBarang",array("id"=>$data->mutasibrg_id)),array("id"=>"$data->mutasibrg_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Pembatalan Mutasi Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')")) : "Telah Dibatalkan"',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
		),		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>