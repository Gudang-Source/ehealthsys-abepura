<div class="white-container">
    <legend class="rim2">Ubah <b>Pemilik Barang</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapemilikbarang Ms'=>array('index'),
            $model->pemilikbarang_id=>array('view','id'=>$model->pemilikbarang_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pemilik Barang', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPemilikbarangM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAPemilikbarangM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAPemilikbarangM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pemilikbarang_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemilik Barang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php // echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</div>