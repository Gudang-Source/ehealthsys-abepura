
<?php
$this->breadcrumbs=array(
	'Jurnal Rekening Supplier Ms'=>array('index'),
	$model->supplier_id=>array('view','id'=>$model->supplier_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jurnal Rekening Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Supplier ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>