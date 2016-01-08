<fieldset class="box row-fluid">
    <legend class="rim">Tambah Kelompok Diagnosa</legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Diagnosa Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Diagnosa ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Diagnosa', 'icon'=>'list', 'url'=>array('index'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Diagnosa', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>