<div class="white-container">
    <legend class="rim2">Lihat <b>Keadaan Umum</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmkeadaanumums'=>array('index'),
            $model->keadaanumum_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Keadaan Umum ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKKeadaanumum', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKKeadaanumum', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKKeadaanumum', 'icon'=>'pencil','url'=>array('update','id'=>$model->keadaanumum_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKKeadaanumum','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->keadaanumum_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Keadaan Umum', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'keadaanumum_id',
                    'keadaanumum_nama',
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Keadaan Umum', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                        $this->createUrl('keadaanumum/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>