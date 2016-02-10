<div class="white-container">
    <legend class="rim2">Tambah <b>Tarif Tindakan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Satarif Tindakan Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tarif Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tarif Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tarif Tindakan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modDetails'=>$modDetails, 'lists'=>$lists, 'isCreate'=>$isCreate)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>