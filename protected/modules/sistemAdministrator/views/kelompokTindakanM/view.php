<div class="white-container">
    <legend class="rim2">Lihat <b>Kelompok Tindakan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Tindakan Ms'=>array('index'),
            $model->kelompoktindakan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelompok Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Tindakan', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelompoktindakan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kelompok Tindakan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelompoktindakan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Tindakan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'kelompoktindakan_id',
                    'kelompoktindakan_nama',
                    'kelompoktindakan_namalainnya',
                    'kelompoktindakan_persencyto',
                    'kelompoktindakan_urutan',
                    array(            
                                                'label'=>'Aktif',
                                                'type'=>'raw',
                                                'value'=>(($model->kelompoktindakan_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                            ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Tindakan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                        $this->createUrl('kelompokTindakanM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>