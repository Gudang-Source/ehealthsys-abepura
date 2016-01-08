<div class="white-container">
    <legend class="rim2">Ubah Inventarisasi <b>Jalan Irigasi dan Jaringan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Guinvjalan Ts'=>array('index'),
            $model->invjalan_id=>array('view','id'=>$model->invjalan_id),
            'Update',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    //$this->renderPartial('/_dataBarang', array('modBarang' => $modBarang ,));
    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Inventarisasi Jalan Irigasi dan Jaringan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvjalanT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvjalanT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' MAInvjalanT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->invjalan_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Jalan Irigasi dan Jaringan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modBarang'=>$modBarang)); ?>
</div>