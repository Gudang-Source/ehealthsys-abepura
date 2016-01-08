
<?php
$this->breadcrumbs=array(
	'Lookup Ms'=>array('index'),
	'Create',
);

$this->menu=array(
        array('label'=>Yii::t('mds','Create').' Kategori Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>Yii::t('mds','Manage').' Kategori Obat', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>