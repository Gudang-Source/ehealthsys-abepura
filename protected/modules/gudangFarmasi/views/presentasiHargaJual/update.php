<div class="white-container">
    <legend class="rim2">Konfigurasi <b>Farmasi</b></legend>
<?php
$this->breadcrumbs=array(
	'Gfkonfigfarmasi Ks'=>array('index'),
	$model->konfigfarmasi_id=>array('view','id'=>$model->konfigfarmasi_id),
	'Update',
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Konfigurasi Farmasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAKonfigfarmasiK', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAKonfigfarmasiK', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAKonfigfarmasiK', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->konfigfarmasi_id))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Konfigurasi Farmasi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>