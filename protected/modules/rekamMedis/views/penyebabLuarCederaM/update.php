<div class='white-container'>
    <legend class='rim2'>Ubah Penyebab <b>Luar Cedera</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmpenyebab Luar Cedera Ms'=>array('index'),
            $model->penyebabluarcedera_id=>array('view','id'=>$model->penyebabluarcedera_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Penyebab Luar Cedera ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKPenyebabLuarCederaM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKPenyebabLuarCederaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RKPenyebabLuarCederaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->penyebabluarcedera_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penyebab Luar Cedera', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>