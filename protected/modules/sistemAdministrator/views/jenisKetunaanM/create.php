<div class="row-fluid">
  <div class="span12"><legend class="rim">Tambah Jenis Ketunaan</legend><br />
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmjenis Ketunaan Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Ketunaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisKetunaanM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Ketunaan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>