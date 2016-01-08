<div class="white-container">
    <legend class='rim2'>Tambah <b>Kurs Rp.</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Kursrp Ms'=>array('index'),
                'Create',
        );

        $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kurs Rp.  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kurs Rp. ', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>