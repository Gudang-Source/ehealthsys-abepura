<?php
$this->breadcrumbs=array(
	'RIruanganpegawai Ms'=>array('index'),
	$model->ruangan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Ruangan Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ruangan.ruangan_nama',
                                array(
                                    'label'=>'Pegawai',
                                    'type'=>'raw',
                                    'value'=>$this->renderPartial('_pegawai', array('ruangan_id'=>$model->ruangan_id), true),
                                ),
	),
)); ?>
<?php 
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));?>
