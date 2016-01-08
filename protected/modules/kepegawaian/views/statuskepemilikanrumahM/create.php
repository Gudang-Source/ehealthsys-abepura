<div class="white-container">
    <legend class="rim2">Tambah Status <b>Kepemilikan Rumah</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Statuskepemilikanrumah Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Status kepemilikan rumah ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Status kepemilikan rumah', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Status kepemilikan rumah', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert');
    //$this->renderPartial('_tabMenu',array());
    ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>