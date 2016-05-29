
<?php
//$this->breadcrumbs=array(
//	'Gureturpenerimaan Ts'=>array('index'),
//	'Create',
//);
//
//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUReturpenerimaanT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUReturpenerimaanT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUReturpenerimaanT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
//
//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'modDetails'=>$modDetails, 'modTerima'=>$modTerima, 'id'=>$id)); ?>