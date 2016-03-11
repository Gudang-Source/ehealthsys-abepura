<fieldset class="box">
    <legend class="rim">Lihat Satuan Kecil</legend>
    <?php
    $this->breadcrumbs=array(
            'Gfsatuan Kecil Ms'=>array('index'),
            $model->satuankecil_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Satuan Kecil ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Satuan Kecil', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Satuan Kecil', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Satuan Kecil', 'icon'=>'pencil','url'=>array('update','id'=>$model->satuankecil_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Satuan Kecil','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->satuankecil_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Satuan Kecil', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'satuankecil_id',
                    'satuankecil_nama',
                    'satuankecil_namalain',
                    array(               // related city displayed as a link
                        'name'=>'satuankecil_aktif',
                        'type'=>'raw',
                        'value'=>(($model->satuankecil_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>

    
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Satuan Kecil', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                    $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>