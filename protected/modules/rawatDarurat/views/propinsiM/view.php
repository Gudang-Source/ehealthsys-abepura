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
<div class="white-container">
    <legend class="rim2">Lihat <b>Propinsi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapropinsi Ms'=>array('index'),
            $model->propinsi_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Propinsi', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Propinsi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'propinsi_id',
                    'propinsi_nama',
                    'propinsi_namalainnya',
                    array(            
                                                'label'=>'Aktif',
                                                'type'=>'raw',
                                                'value'=>(($model->propinsi_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                            ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>