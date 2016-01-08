<div class="white-container">
    <legend class="rim2">Lihat <b>Jabatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajabatan Ms'=>array('index'),
            $model->jabatan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jabatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jabatan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jabatan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jabatan', 'icon'=>'pencil','url'=>array('update','id'=>$model->jabatan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Jabatan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jabatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jabatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jabatan_id',
                    'jabatan_nama',
                    'jabatan_lainnya',
                    array(               // related city displayed as a link
                        'name'=>'gelarbelakang_aktif',
                        'type'=>'raw',
                        'value'=>(($model->jabatan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jabatan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                        $this->createUrl('jabatanM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>