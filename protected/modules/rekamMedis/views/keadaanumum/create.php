<div class="white-container">
    <legend class="rim2">Tambah <b>Keadaan Umum</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmkeadaanumums'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Keadaan Umum ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKKeadaanumum', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Keadaan Umum', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>