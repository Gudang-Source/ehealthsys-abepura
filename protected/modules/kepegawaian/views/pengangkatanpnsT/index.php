
<?php
$this->breadcrumbs=array(
	'Kppengangkatanpns Ts'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pengangkatan Pegawai Negeri Sipil ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPengangkatanpnsT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPengangkatanpnsT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'modPegawai'=>$modPegawai, 'modUsulan'=>$modUsulan, 'modPers'=>$modPers, 'modRealisasi'=>$modRealisasi)); ?>
