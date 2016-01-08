<legend class="rim2">Informasi Mutasi Barang</legend>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gumutasibrg-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'gumutasibrg-t-grid',
	'dataProvider'=>$model->searchInformasiGudang(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		'nomutasibrg',
		'tglmutasibrg',
		'pegawaipengirim.nama_pegawai',
		'pegawaimengetahui.nama_pegawai',
		'totalhargamutasi',
		'ruangantujuan.ruangan_nama',
		'keterangan_mutasi',
		'pesanbarang.nopemesanan',
		array(
			'header'=>'Detail',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ",  Yii::app()->controller->createUrl("'.$controller.'/detailMutasiBarang",array("id"=>$data->mutasibrg_id)),array("id"=>"$data->mutasibrg_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Mutasi Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
		),
		array(
			'header'=>'Batal Mutasi',
			'type'=>'raw',
			'value'=>'($data->testingData == false) ? "Telah Dimutasi" : "Batal Mutasi"',
		),
		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//        $this->widget('UserTips',array('type'=>'admin'));
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Mutasi Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>