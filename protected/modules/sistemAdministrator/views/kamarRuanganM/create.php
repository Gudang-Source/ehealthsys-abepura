
<?php
$this->breadcrumbs=array(
	'Sakamar Ruangan Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kamar Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kamar Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kamar Ruangan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'modRiwayatRuanganR'=>$modRiwayatRuanganR)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>