<fieldset class="box row-fluid">
    <legend class="rim">Ubah Detail Napza</legend>
    <?php
    $this->breadcrumbs=array(
            'Sadetailnapza Ms'=>array('index'),
            $model->detailnapza_id=>array('view','id'=>$model->detailnapza_id),
            'Update',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Detail Napza ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SADetailnapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SADetailnapzaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SADetailnapzaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->detailnapza_id))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Detail Napza', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
</fieldset>