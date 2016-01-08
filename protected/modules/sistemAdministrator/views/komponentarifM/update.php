
<?php
$this->breadcrumbs=array(
	'Sakomponen Tarif Ms'=>array('index'),
	$model->komponentarif_id=>array('view','id'=>$model->komponentarif_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Komponen Tarif ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Komponen Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Tarif', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Komponen Tarif', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->komponentarif_id))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Tarif', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modKomponenTarifInstalasi'=>$modKomponenTarifInstalasi)); ?>

<?php //$this->widget('UserTips',array('type'=>'update'));?>