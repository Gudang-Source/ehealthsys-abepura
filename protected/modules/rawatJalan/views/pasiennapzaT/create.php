<?php
$this->breadcrumbs=array(
	'Rjpasiennapza Ts'=>array('index'),
	'Create',
);

$arrMenu = array();
                //array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pasien Napza ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJPasiennapzaT', 'icon'=>'list', 'url'=>array('index'))) ;
                //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pasien Napza', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'modPasien'=>$modPasien,'modPeriksaFisik'=>$modPeriksaFisik, 'modAnamnesa'=>$modAnamnesa)); ?>
