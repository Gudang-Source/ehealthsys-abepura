<div class='white-container'>
    <legend class='rim2'>Ubah <b>Tipe Rekening</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Tiperekening Ms'=>array('index'),
                $model->tiperekening_id=>array('view','id'=>$model->tiperekening_id),
                'Update',
        );

        $arrMenu = array();
//                        array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tipe Rekening ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Rekening ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 

    ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>