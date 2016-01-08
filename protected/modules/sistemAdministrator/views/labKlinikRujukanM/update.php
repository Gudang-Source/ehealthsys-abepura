
<?php
$this->breadcrumbs=array(
	'Salab Klinik Rujukan Ms'=>array('index'),
	$model->labklinikrujukan_id=>array('view','id'=>$model->labklinikrujukan_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Lab Klinik Rujukan #'.$model->labklinikrujukan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Lab Klinik Rujukan', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Lab Klinik Rujukan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Lab Klinik Rujukan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->labklinikrujukan_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Lab Klinik Rujukan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php $this->widget('UserTips',array('type'=>'update'));?>