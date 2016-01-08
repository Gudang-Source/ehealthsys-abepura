<div class="row-fluid">
  <div class="span12"><legend class="rim">Tambah Lokasi Rak</legend><br />
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmlokasi Raks'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Lokasi Rak ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SALokasirakM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Lokasi Rak', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
