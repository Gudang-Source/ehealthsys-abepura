<!--<div class="white-container">
    <legend class="rim2">Tambah <b>Komponen Gaji</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Tambah Komponen Gaji</legend>
    <?php
    $this->breadcrumbs=array(
            'Komponengaji Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KomponengajiM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'   Komponen gaji', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view. '_form', array('model'=>$model)); ?>
<!--</div>-->
</fieldset>