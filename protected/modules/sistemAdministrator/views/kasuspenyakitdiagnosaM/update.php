<div class="white-container">
    <legend class="rim2">Ubah Kasus <b>Penyakit Diagnosa</b></legend>
<?php
$this->breadcrumbs=array(
	'RIkasuspenyakitdiagnosa Ms'=>array('index'),
	$model->jeniskasuspenyakit_id=>array('view','id'=>$model->jeniskasuspenyakit_id),
	'Update',
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Diagnosa Kasus Penyakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Kasus Penyakit ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modDetails'=>$modDetails)); ?>
