<fieldset class="box">
    <legend class="rim">Ubah Therapi Obat</legend>
    <?php
    $this->breadcrumbs=array(
            'Gftherapi Obat Ms'=>array('index'),
            $model->therapiobat_id=>array('view','id'=>$model->therapiobat_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Therapi Obat', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Therapi Obat', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Therapi Obat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Therapi Obat', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->therapiobat_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Therapi Obat', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>