<div class='white-container'>
    <legend class='rim2'>Tambah Jurnal <b>Rekening Penerimaan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Matauang Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rek Penerimaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'Jurnal Rek Penerimaan ', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>


    <?php echo $this->renderPartial('_tabMenu',array()); ?>
    <div class="biru">
        <div class="white">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'modDetails'=>$modDetails,)); ?>
        </div>
    </div>
</div>