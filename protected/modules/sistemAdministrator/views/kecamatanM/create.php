<div class="white-container">
    <legend class="rim2">Tambah <b>Kecamatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakecamatan Ms'=>array('index'),
            'Create',
    );


    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kecamatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kecamatan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kecamatan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'latitude'=>$latitude,'longitude'=>$longitude,)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>