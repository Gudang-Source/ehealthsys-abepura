<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Nilai</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Ubah Nilai</legend>
    <?php
    $this->breadcrumbs=array(
            'Nilai Ms'=>array('index'),
            $model->nilai_id=>array('view','id'=>$model->nilai_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Nilai', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' NilaiM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' NilaiM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' NilaiM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->nilai_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Nilai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<!--</div>-->
</fieldset>