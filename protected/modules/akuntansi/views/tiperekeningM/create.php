<div class='white-container'>
    <legend class='rim2'>Tambah <b>Tipe Rekening</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Tiperekening Ms'=>array('index'),
                'Create',
        );

        $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Rekening ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Rekening', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>