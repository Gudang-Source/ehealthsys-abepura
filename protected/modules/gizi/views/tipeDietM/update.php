<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Tipe Diet</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Ubah <b>Tipe Diet</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gztipediet Ms'=>array('index'),
            $model->tipediet_id=>array('view','id'=>$model->tipediet_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tipe Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tipe Diet', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tipe Diet', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->tipediet_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<!--</div>-->
</fieldset>