<fieldset class="white-container">
    <legend class="rim2">Ubah <b>Hari Kerja Golongan</b></legend>
<?php /*
$this->breadcrumbs=array(
	'Hari Kerja Golongan Ms'=>array('index'),
	$model->harikerjagol_id=>array('view','id'=>$model->harikerjagol_id),
	'Update',
);

$arrMenu = array();
array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Hari Kerja Golongan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
(Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Hari Kerja Golongan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;
*/

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php //$this->widget('TipsMasterData',array('type'=>'update'));?>
</fieldset>