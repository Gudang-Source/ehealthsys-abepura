<?php
$this->breadcrumbs=array(
	'Rujukandari Ms'=>array('index'),
	$model->rujukandari_id=>array('view','id'=>$model->rujukandari_id),
	'Update',
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Daftar Rujukan'.$model->rujukandari_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RujukandariM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RujukandariM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RujukandariM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->rujukandari_id))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Daftar RUjukan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset class="box">
    <legend class="rim">Ubah Daftar Rujukan</legend>
    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
</fieldset>