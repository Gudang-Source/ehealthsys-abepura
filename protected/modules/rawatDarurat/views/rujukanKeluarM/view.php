<?php 
//$this->widget('bootstrap.widgets.BootMenu', array(
//    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//    'stacked'=>false, // whether this is a stacked menu
//    'items'=>array(
////        array('label'=>'Jadwal Dokter', 'url'=>$this->createUrl('/rawatDarurat/jadwaldokterM')),
//        array('label'=>'Transportasi', 'url'=>$this->createUrl('/rawatDarurat/TransportasiM')),
//        array('label'=>'Keadaan Masuk', 'url'=>$this->createUrl('/rawatDarurat/KeadaanMasukM')),
//        array('label'=>'Keadaan Pulang', 'url'=>$this->createUrl('/rawatDarurat/KeadaanPulangM')),
//        array('label'=>'Rujukan Keluar', 'url'=>'', 'active'=>true),
//        array('label'=>'Asal Rujukan', 'url'=>$this->createUrl('/rawatDarurat/asalRujukanM')),
//        array('label'=>'Triase', 'url'=>$this->createUrl('/rawatDarurat/triaseM')),
//        array('label'=>'Cara Keluar', 'url'=>$this->createUrl('/rawatDarurat/CaraKeluarM')),
//    ),
//)); ?>
<div class="white-container">
    <legend class="rim2">Lihat <b>Rujukan Keluar</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sarujukan Keluar Ms'=>array('index'),
            $model->rujukankeluar_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Rujukan Keluar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rujukan Keluar', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'rujukankeluar_id',
                    'rumahsakitrujukan',
                    'alamatrsrujukan',
                    'telp_fax',
                    'rujukankeluar_aktif',
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>