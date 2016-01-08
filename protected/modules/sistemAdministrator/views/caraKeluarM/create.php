<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
//        array('label'=>'Jadwal Dokter', 'url'=>$this->createUrl('/rawatDarurat/jadwaldokterM')),
//        array('label'=>'Transportasi', 'url'=>$this->createUrl('/rawatDarurat/transportasiM')),
//        array('label'=>'Keadaan Masuk', 'url'=>$this->createUrl('/rawatDarurat/KeadaanMasukM')),
//        array('label'=>'Kondisi Pulang', 'url'=>$this->createUrl('/rawatDarurat/KondisiPulangM')),
//        array('label'=>'Rujukan Keluar', 'url'=>$this->createUrl('/rawatDarurat/rujukanKeluarM')),
//        array('label'=>'Asal Rujukan', 'url'=>$this->createUrl('/rawatDarurat/triaseM')),
//        array('label'=>'Triase', 'url'=>$this->createUrl('/rawatDarurat/triaseM')),
//        array('label'=>'Cara Keluar', 'url'=>'', 'active'=>true),
//    ),
//)); ?>
<fieldset class="box">
    <legend class="rim">Tambah Cara Keluar</legend>
    <?php
    $this->breadcrumbs=array(
            'Rdcara Keluar Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Keluar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Keluar', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</fieldset>