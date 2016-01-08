<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
//        array('label'=>'Propinsi',  'url'=>$this->createUrl('/rawatDarurat/propinsiM')),
//        array('label'=>'Kabupaten', 'url'=>'', 'active'=>true),
//        array('label'=>'Kecamatan', 'url'=>$this->createUrl('/rawatDarurat/kecamatanM')),
//        array('label'=>'Kelurahan', 'url'=>$this->createUrl('/rawatDarurat/kelurahanM')),
//    ),
//)); ?>
<div class="white-container">
    <legend class="rim2">Lihat <b>Kabupaten</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakabupaten Ms'=>array('index'),
            $model->kabupaten_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kabupaten ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kabupaten', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'kabupaten_id',
                    'propinsi.propinsi_nama',
                    'kabupaten_nama',
                    'kabupaten_namalainnya',
                    array(            
                                                'label'=>'Aktif',
                                                'type'=>'raw',
                                                'value'=>(($model->kabupaten_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                            ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>