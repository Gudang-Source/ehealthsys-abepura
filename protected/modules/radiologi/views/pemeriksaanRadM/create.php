<div class="white-container">
    <legend class="rim2">Tambah <b>Pemeriksaan Radiologi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapemeriksaan Rad Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pemeriksaaan Radiologi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPemeriksaanRadM', 'icon'=>'list', 'url'=>array('index'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemeriksaaan Radiologi', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modReferensiHasil'=>$modReferensiHasil,)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>