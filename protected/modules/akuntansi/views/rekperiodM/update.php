<div class='white-container'>
    <legend class='rim2'>Ubah <b>Periode Akuntansi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rekperiod Ms'=>array('index'),
            $model->rekperiod_id=>array('view','id'=>$model->rekperiod_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Rekening Periode', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Rekening Periode', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Rekening Periode', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rekening Periode', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>