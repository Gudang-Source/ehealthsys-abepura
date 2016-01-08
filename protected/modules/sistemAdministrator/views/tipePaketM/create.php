<div class="white-container">
	<legend class="rim2">Tambah <b>Tipe Paket</b></legend>
	<?php
	$this->breadcrumbs=array(
		'Satipe Paket Ms'=>array('index'),
		'Create',
	);

//	$arrMenu = array();
//					array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Paket ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//	//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tipe Paket', 'icon'=>'list', 'url'=>array('index'))) ;
//	//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Paket', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
//
//	$this->menu=$arrMenu;

	$this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
	<?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>