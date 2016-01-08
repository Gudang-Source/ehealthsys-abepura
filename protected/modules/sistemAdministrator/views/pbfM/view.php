<div class="white-container">
    <legend class="rim2">Lihat <b>Pbf</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfpbf Ms'=>array('index'),
            $model->pbf_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pbf ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pbf', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pbf', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pbf', 'icon'=>'pencil','url'=>array('update','id'=>$model->pbf_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Pbf','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pbf_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pbf', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'pbf_id',
                    'pbf_kode',
                    'pbf_nama',
                    'pbf_singkatan',
                    'pbf_alamat',
                    'pbf_propinsi',
                    'pbf_kabupaten',
                    array(               // related city displayed as a link
                        'name'=>'pbf_aktif',
                        'type'=>'raw',
                        'value'=>(($model->pbf_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pbf', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
</div>