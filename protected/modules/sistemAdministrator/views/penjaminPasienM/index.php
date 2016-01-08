<?php
$this->breadcrumbs=array(
	'Sapenjamin Pasien Ms',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Penjamin Pasien', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Penjamin', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penjamin Pasien', 'icon'=>'file', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>$this->path_view.'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/PenjaminPasienM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>