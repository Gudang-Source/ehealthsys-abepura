<div class="row-fluid">
  <div class="span12"><legend class="rim">Edit Lokasi Rak</legend><br />
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmlokasi Raks'=>array('index'),
	$model->lokasirak_id=>array('view','id'=>$model->lokasirak_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Lokasi Rak ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SALokasirakM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SALokasirakM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SALokasirakM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lokasirak_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Lokasi Rak', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
