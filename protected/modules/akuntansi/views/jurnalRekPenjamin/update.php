<!--<div class='white-container'>
    <legend class='rim2'>Ubah <b>Rekening Penjamin</b></legend>-->
<fieldset class ="box">
    <legend class = "rim">Ubah Rekening Penjamin</legend>
<?php
/*
$this->breadcrumbs=array(
	'Jurnal Rekening Penjamin Ms'=>array('index'),
	$model->penjamin_id=>array('view','id'=>$model->penjamin_id),
	'Update',
); */

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jurnal Rekening Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Penjamin ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model, 'modPenjamin'=>$modPenjamin)); ?>
<!--</div>-->
</fieldset>