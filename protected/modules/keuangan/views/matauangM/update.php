<div class="white-container">
    <legend class='rim2'>Ubah <b>Mata Uang</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Matauang Ms'=>array('index'),
                $model->matauang_id=>array('view','id'=>$model->matauang_id),
                'Update',
        );

        $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Mata Uang', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Mata Uang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>