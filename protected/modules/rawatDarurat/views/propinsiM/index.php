<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
//        array('label'=>'Propinsi', 'url'=>'', 'active'=>true),
//        array('label'=>'Kabupaten', 'url'=>$this->createUrl('/rawatDarurat/kabupatenM')),
//        array('label'=>'Kecamatan', 'url'=>$this->createUrl('/rawatDarurat/kecamatanM')),
//        array('label'=>'Kelurahan', 'url'=>$this->createUrl('/rawatDarurat/kelurahanM')),
//    ),
//)); ?>

<?php
//$this->breadcrumbs=array(
//	'Sapropinsi Ms',
//);

//$arrMenu = array();
  //              array_push($arrMenu,array('label'=>Yii::t('mds','List').' Propinsi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //            (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Propinsi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
      //          (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Propinsi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

//$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php //$this->widget('ext.bootstrap.widgets.BootListView',array(
	//'dataProvider'=>$dataProvider,
	//'itemView'=>'_view',
//)); ?>

<?php //$this->widget('UserTips',array('type'=>'list'));?>
<div class="white-container">
    <legend class="rim2">Master <b>Wilayah</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
    <div>
        <iframe class='biru' id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
    </div>
</div>