
<?php
$this->breadcrumbs=array(
	'Sadiagnosa Tindakan Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').'  Diagnosa Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').'  Diagnosa Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  Diagnosa Tindakan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>