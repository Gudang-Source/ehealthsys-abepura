<fieldset class="box">
	<legend class="rim">Tambah Kelompok Pemeriksaan</legend>
	<?php
	$this->breadcrumbs=array(
			'Rdkeadaan Masuk Ms'=>array('index'),
			'Create',
	);

	$arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Pemeriksaan Laboratorium ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
					//array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Pemeriksaan Laboratorium', 'icon'=>'list', 'url'=>array('index'))) ;
	//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Pemeriksaan Laboratorium', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

	$this->menu=$arrMenu;

	$this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
	<?php //$this->widget('UserTips',array('type'=>'create'));?>
</fieldset>