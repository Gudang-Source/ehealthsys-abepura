<div class="row-fluid">
  <div class="span12"><legend class="rim">Tambah Jenis Infeksi</legend><br />
  </div>
</div>

<?php
$this->breadcrumbs=array(
	'Rmjenis Infeksi Nosokomial Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Infeksi Nosokomial ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisInfeksiNosokomialM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Infeksi Nosokomial', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>