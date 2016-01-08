<div class="white-container">
    <legend class="rim2">Ubah Inventarisasi <b>Peralatan dan Mesin</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Guinvperalatan Ts'=>array('index'),
            $model->invperalatan_id=>array('view','id'=>$model->invperalatan_id),
            'Update',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Inventarisasi Peralatan dan Mesin', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvperalatanT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvperalatanT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' MAInvperalatanT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->invperalatan_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Peralatan dan Mesin', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'data'=>$data,'dataAsalAset'=>$dataAsalAset , 'dataLokasi'=>$dataLokasi,'modBarang'=>$modBarang)); ?>
</div>