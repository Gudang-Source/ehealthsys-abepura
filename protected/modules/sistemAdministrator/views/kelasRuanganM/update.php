<div class="row-fluid">
  <div class="span12"><legend class="rim">Ubah Kelas Ruangan</legend><br />
  </div>
</div>

<?php // $this->renderPartial('_tab'); ?>
<?php
$this->breadcrumbs=array(
	'Ppruangan Ms'=>array('index'),
	$model->ruangan_id=>array('view','id'=>$model->ruangan_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelas Ruangan '/*.$model->ruangan_id*/, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelas Ruangan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->ruangan_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Ruangan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model, 'modRuangan'=>$modPelayanan)); ?>
