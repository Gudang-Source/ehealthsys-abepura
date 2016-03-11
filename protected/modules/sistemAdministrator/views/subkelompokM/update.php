<div class="white-container">
    <legend class="rim2">Ubah <b>Sub Kelompok</b></legend>
<?php
$this->breadcrumbs=array(
	'Sasubkelompok Ms'=>array('index'),
	$model->subkelompok_id=>array('view','id'=>$model->subkelompok_id),
	'Update',
);

$arrMenu = array();
                //array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sub Kelompok', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASubkelompokM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASubkelompokM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SASubkelompokM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->subkelompok_id))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sub Kelompok', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
</div>