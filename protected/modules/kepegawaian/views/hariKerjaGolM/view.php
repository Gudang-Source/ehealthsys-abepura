<?php
$this->breadcrumbs=array(
	'Hari Kerja Golongan Ms'=>array('index'),
	$model->harikerjagol_id,
);

$arrMenu = array();
    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Hari Kerja Golongan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Hari Kerja Golongan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'harikerjagol_id',
		  'kelompokpegawai.kelompokpegawai_nama',
		'periodeharikerjaawl',
		'periodehariakhir',
        'periodeharikerjaakhir',
             'jmlharibln',
        array(       
            'name'=>'harikerjagol_aktif',
            'type'=>'raw',
            'value'=>(($model->harikerjagol_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
        ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>