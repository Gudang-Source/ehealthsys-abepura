<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
////        array('label'=>'Jadwal Dokter', 'url'=>$this->createUrl('/rawatDarurat/jadwaldokterM')),
//        array('label'=>'Transportasi', 'url'=>$this->createUrl('/rawatDarurat/TransportasiM')),
//        array('label'=>'Keadaan Masuk', 'url'=>'', 'active'=>true),
//        array('label'=>'Kondisi Pulang', 'url'=>$this->createUrl('/rawatDarurat/KondisiPulangM')),
//        array('label'=>'Rujukan Keluar', 'url'=>$this->createUrl('/rawatDarurat/rujukanKeluarM')),
//        array('label'=>'Asal Rujukan', 'url'=>$this->createUrl('/rawatDarurat/asalRujukanM')),
//        array('label'=>'Triase', 'url'=>$this->createUrl('/rawatDarurat/triaseM')),
//        array('label'=>'Cara Keluar', 'url'=>$this->createUrl('/rawatDarurat/CaraKeluarM')),
//    ),
//)); ?>

<?php
$this->breadcrumbs=array(
	'Rdkeadaan Masuk Ms',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Keadaan Masuk ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Keadaan Masuk', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Keadaan Masuk', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>