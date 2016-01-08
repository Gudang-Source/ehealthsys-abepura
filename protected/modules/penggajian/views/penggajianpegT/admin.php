<div class="white-container">
    <legend class="rim2">Penggajian <b>Karyawan</b></legend><?php
$this->breadcrumbs = array(
	'Gjpenggajianpeg Ts' => array('index'),
	'Manage',
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' GJPenggajianpegT ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) : '';
array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' GJPenggajianpegT', 'icon' => 'list', 'url' => array('index')));
(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' GJPenggajianpegT', 'icon' => 'file', 'url' => array('create'))) : '';

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert');
?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form" style="display:none">
                <?php $this->renderPartial($this->path_view. '_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->

<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'gjpenggajianpeg-t-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		////'penggajianpeg_id',
		array(
			'name' => 'penggajianpeg_id',
			'value' => '$data->penggajianpeg_id',
			'filter' => false,
		),
		'pegawai_id',
		'tglpenggajian',
		'nopenggajian',
		'keterangan',
		'mengetahui',
		/*
		  'menyetujui',
		  'totalterima',
		  'totalpajak',
		  'totalpotongan',
		  'penerimaanbersih',
		 */
		array(
			'header' => Yii::t('zii', 'View'),
			'class' => 'bootstrap.widgets.BootButtonColumn',
			'template' => '{view}',
		),
		array(
			'header' => Yii::t('zii', 'Update'),
			'class' => 'bootstrap.widgets.BootButtonColumn',
			'template' => '{update}',
			'buttons' => array(
				'update' => array(
					'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
				),
			),
		),
		array(
			'header' => Yii::t('zii', 'Delete'),
			'class' => 'bootstrap.widgets.BootButtonColumn',
			'template' => '{delete}',
			'buttons' => array(
//				'remove' => array(
//					'label' => "<i class='icon-remove'></i>",
//					'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
//					'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->penggajianpeg_id"))',
//					//'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//					'click' => 'function(){return confirm("' . Yii::t("mds", "Do You want to remove this item temporary?") . '");}',
//				),
				'delete' => array(
					'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
				),
			)
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php
echo CHtml::link(Yii::t('mds', '{icon} Tambah Penggajian Karyawan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
$this->widget('UserTips', array('type' => 'admin'));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPenggajian');
?>
</div>
<?php
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gjpenggajianpeg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>