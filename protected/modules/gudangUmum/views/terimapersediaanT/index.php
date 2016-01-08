
<?php
//$this->breadcrumbs=array(
//	'Guterimapersediaan Ts'=>array('index'),
//	'Create',
//);
//
//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUTerimapersediaanT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUTerimapersediaanT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUTerimapersediaanT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
//
//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'modDetails'=>$modDetails, 'modBeli'=>$modBeli, 'modDetailBeli'=>$modDetailBeli)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>