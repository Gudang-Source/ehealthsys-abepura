<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
//        array('label'=>'Propinsi',  'url'=>$this->createUrl('/rawatDarurat/propinsiM')),
//        array('label'=>'Kabupaten', 'url'=>$this->createUrl('/rawatDarurat/kabupatenM')),
//        array('label'=>'Kecamatan', 'url'=>'', 'active'=>true),
//        array('label'=>'Kelurahan', 'url'=>$this->createUrl('/rawatDarurat/kelurahanM')),
//    ),
//)); ?>
<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Kecamatan</b></legend>-->
<fieldset class = "box">
    <legend class = "rim">Ubah Kecamatan</legend>
    <?php
    $this->breadcrumbs=array(
            'Sakecamatan Ms'=>array('index'),
            $model->kecamatan_id=>array('view','id'=>$model->kecamatan_id),
            'Update',
    );


    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kecamatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kecamatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>