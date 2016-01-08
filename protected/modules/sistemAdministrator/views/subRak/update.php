<div class="row-fluid">
  <div class="span12"><legend class="rim">Edi Sub Rak</legend><br />
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmsub Raks'=>array('index'),
	$model->subrak_id=>array('view','id'=>$model->subrak_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sub Rak ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASubrakM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASubrakM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SASubrakM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->subrak_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sub Rak', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
