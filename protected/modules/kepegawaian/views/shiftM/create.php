<div class="white-container">
    <legend class="rim2">Tambah <b>Shift</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Shift Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Shift ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    // array_push($arrMenu,array('label'=>Yii::t('mds','List').' Shift ', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' ShiftM', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>