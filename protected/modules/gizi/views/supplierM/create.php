<div class="white-container">
    <legend class="rim2">Tambah <b>Supplier</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfsupplier Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Supplier', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modObatSupplier'=>$modObatSupplier)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>