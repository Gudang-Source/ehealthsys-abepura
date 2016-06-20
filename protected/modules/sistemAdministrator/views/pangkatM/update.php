<?php
    if ($this->hasTab):
?>
<fieldset class="box row-fluid">
    <legend class="rim">Ubah Pangkat</legend>
<?php
    else:
?>
    <div class="white-container">
    <legend class="rim2">Ubah <b>Pangkat</b></legend>
<?php
    endif;
?>
<?php
$this->breadcrumbs=array(
	'Sapangkat Ms'=>array('index'),
	$model->pangkat_id=>array('view','id'=>$model->pangkat_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pangkat #'.$model->pangkat_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pangkat', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pangkat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pangkat', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pangkat_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pangkat', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>
</fieldset>