<!--<div class='white-container'>
    <legend class='rim2'>Tambah Jurnal <b>Rekening Sumber Dana</b></legend>-->
<fieldset class = "box">
    <legend class = "rim">Tambah Jurnal Rekening Sumber Dana</legend>
    <?php
    /*
    $this->breadcrumbs=array(
            'Jurnal Rekening Sumber Dana'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rekening Sumber Dana ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Sumber Dana', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;
*/
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<!--</div>-->
</fieldset>