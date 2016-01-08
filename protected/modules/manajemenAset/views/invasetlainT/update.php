<div class="white-container">
	<legend class="rim2">Ubah Inventarisasi <b>Aset Tetap Lainnya</b></legend>
<?php
$this->breadcrumbs=array(
	'Guinvasetlain Ts'=>array('index'),
	$model->invasetlain_id=>array('view','id'=>$model->invasetlain_id),
	'Update',
);
$this->widget('bootstrap.widgets.BootAlert');
$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Aset Tetap Lainnya', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvasetlainT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvasetlainT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' MAInvasetlainT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->invasetlain_id))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Aset Tetap Lainnya', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modBarang'=>$modBarang,'data'=>$data,'dataAsalAset'=>$dataAsalAset , 'dataLokasi'=>$dataLokasi)); ?>
</div>