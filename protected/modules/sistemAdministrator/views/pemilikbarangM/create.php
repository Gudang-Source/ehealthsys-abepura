<div class="white-container">
    <legend class="rim2">Tambah <b>Pemilik Barang</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapemilikbarang Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pemilik Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPemilikbarangM', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemilik Barang', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</div>