<?php
$this->breadcrumbs=array(
	'Sapendidikankualifikasi Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kualifikasi Pendidikan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kualifikasi Pendidikan', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kualifikasi Pendidikan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset class="box">
    <legend class="rim">Tambah Kualifikasi Pendidikan</legend>
    <?php
    //$this->renderPartial('_tabMenu',array());
    echo $this->renderPartial('_form', array('model'=>$model));
    ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</fieldset>