
<?php
$this->breadcrumbs=array(
	'Sacara Masuk Ms'=>array('index'),
	'Create',
);

$this->menu=array(
        array('label'=>Yii::t('mds','Create').' Cara Masuk ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Cara Masuk', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Manage').' Cara Masuk', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>