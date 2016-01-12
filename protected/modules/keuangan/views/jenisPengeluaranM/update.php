<div class="white-container">
    <legend class='rim2'>Tambah <b>Pengeluaran Umum</b></legend>
<?php
//$this->breadcrumbs=array(
//	'Kujenis Pengeluaran Ms'=>array('index'),
//	$model->jenispenerimaan_id=>array('view','id'=>$model->jenispenerimaan_id),
//	'Update',
//);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Pengeluaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kelas', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Kelas', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Kelas', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jenispenerimaan_id))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Kelas', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>