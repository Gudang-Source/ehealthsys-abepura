<?php
$this->breadcrumbs=array(
	'Lookup Ms',
);

$this->menu=array(
        array('label'=>Yii::t('mds','List').' Minat Pekerjaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
//	array('label'=>Yii::t('mds','Manage').' Minat Pekerjaan', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Minat Pekerjaan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>