<?php
$this->breadcrumbs=array(
        'gzbahanmakanan Ms'=>array('index'),
        'Create',
);
//
//$arrMenu = array();
////                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
////                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Makanan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
//
//$this->menu=$arrMenu;
?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>