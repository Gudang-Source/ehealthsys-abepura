<?php
$this->breadcrumbs=array(
	'Rmlokasi Raks'=>array('index'),
	$model->lokasirak_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Lokasi Rak', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SALokasirakM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SALokasirakM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SALokasirakM', 'icon'=>'pencil','url'=>array('update','id'=>$model->lokasirak_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SALokasirakM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lokasirak_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Lokasi Rak', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'lokasirak_id',
		'lokasirak_nama',
		'lokasirak_namalainnya',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->lokasirak_aktif==1)? "Ya" : "Tidak"),
                                )
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>