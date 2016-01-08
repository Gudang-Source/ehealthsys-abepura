<div class='white-container'>
    <legend class='rim2'>Ubah <b>Kurs Rp.</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Kursrp Ms'=>array('index'),
                $model->kursrp_id=>array('view','id'=>$model->kursrp_id),
                'Update',
        );

        $arrMenu = array();
//                        array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kurs Rp. ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kurs Rp. ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>
    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>