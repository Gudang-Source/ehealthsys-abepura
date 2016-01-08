<?php
$this->breadcrumbs=array(
	'Rujukandari Ms'=>array('index'),
	$model->rujukandari_id,
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Rujukan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rujukan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<!--<fieldset class="box">-->
    <!--<legend class="rim">Lihat Rujukan</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'rujukandari_id',
                    'asalrujukan.asalrujukan_nama',
                    'namaperujuk',
                    'spesialis',
                    'alamatlengkap',
                    'notelp',
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Daftar Rujukan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
<!--</fieldset>-->