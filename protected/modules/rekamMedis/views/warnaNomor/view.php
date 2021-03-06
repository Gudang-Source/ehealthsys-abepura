<div class="white-container">
    <legend class="rim2">Lihat <b>Warna Nomor</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmwarna Nomors'=>array('index'),
            $model->warnanomorrm_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Warna Nomor', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKWarnaNomor', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKWarnaNomor', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKWarnaNomor', 'icon'=>'pencil','url'=>array('update','id'=>$model->warnanomorrm_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKWarnaNomor','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->warnanomorrm_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Warna Nomor', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'warnanomorrm_id',
                    'warnanomorrm_angka',
                    'warnanomorrm_warna',
                    'warnanomorrm_kodewarna',
                                    array(
                                        'label'=>'Aktif',
                                        'value'=>(($model->warnanomorrm_aktif==1)? "Ya" : "Tidak"),
                                    )
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Warna Nomor', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('warnaNomor/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>