<div class='white-container'>
    <legend class='rim2'>Ubah <b>Jenis Jurnal</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Jenisjurnal Ms'=>array('index'),
                $model->jenisjurnal_id=>array('view','id'=>$model->jenisjurnal_id),
                'Update',
        );

        $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Jurnal ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Jurnal ', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Jurnal ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Jurnal ', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jenisjurnal_id))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Jurnal ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>