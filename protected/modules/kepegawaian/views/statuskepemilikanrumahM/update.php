<div class="white-container">
    <legend class="rim2">Ubah Status <b>Kepemilikan Rumah</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Statuskepemilikanrumah Ms'=>array('index'),
            $model->statuskepemilikanrumah_id=>array('view','id'=>$model->statuskepemilikanrumah_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Status kepemilikan rumah ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Status kepemilikan rumah', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Status kepemilikan rumah', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert');
    ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>