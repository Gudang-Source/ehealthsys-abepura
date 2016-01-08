<div class="white-container">
    <legend class="rim2">Ubah <b>Diagnosa Obat</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Fadiagnosaobat Ms'=>array('index'),
        'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Diagnosa Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Obat ', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modDetails'=>$modDetails)); ?>
</div>