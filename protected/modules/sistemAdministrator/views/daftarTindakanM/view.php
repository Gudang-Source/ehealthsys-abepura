<div class="white-container">
    <legend class="rim2">Lihat <b>Daftar Tindakan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadaftar Tindakan Ms'=>array('index'),
            $model->daftartindakan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').'  Daftar Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Daftar Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Daftar Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Daftar Tindakan', 'icon'=>'pencil','url'=>array('update','id'=>$model->daftartindakan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Daftar Tindakan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->daftartindakan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Daftar Tindakan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'daftartindakan_id',
                     array(
                         'name'=>'komponenunit_nama',
                         'type'=>'raw',
                         'value'=>$model->komponenunit->komponenunit_nama,
                     ),
                     array(
                         'name'=>'kategoritindakan_nama',
                         'type'=>'raw',
                         'value'=>$model->kategoritindakan->kategoritindakan_nama,
                     ),
                      array(
                         'name'=>'kelompoktindakan_nama',
                         'type'=>'raw',
                         'value'=>$model->kelompoktindakan->kelompoktindakan_nama,
                     ),
                    'daftartindakan_kode',
                    'daftartindakan_nama',
                     array(               // related city displayed as a link
                        'name'=>'daftartindakan_aktif',
                        'type'=>'raw',
                        'value'=>(($model->daftartindakan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
                    'tindakanmedis_nama',
                    'daftartindakan_namalainnya',
                    'daftartindakan_katakunci',
                     array(
                         'label'=>'Ruangan',
                         'type'=>'raw',
                         'value'=>$this->renderPartial('_ruangan',array('daftartindakan_id'=>$model->daftartindakan_id),true),
                     ),
                    array(               // related city displayed as a link
                        'name'=>'daftartindakan_karcis',
                        'type'=>'raw',
                        'value'=>(($model->daftartindakan_karcis==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
                    array(               // related city displayed as a link
                        'name'=>'daftartindakan_visite',
                        'type'=>'raw',
                        'value'=>(($model->daftartindakan_visite==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
                    array(               // related city displayed as a link
                        'name'=>'daftartindakan_konsul',
                        'type'=>'raw',
                        'value'=>(($model->daftartindakan_konsul==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
                    array(               // related city displayed as a link
                        'name'=>'daftartindakan_akomodasi',
                        'type'=>'raw',
                        'value'=>(($model->daftartindakan_akomodasi==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),

            ),
    )); ?>

    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Daftar Tindakan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
    $this->widget('UserTips',array('type'=>'view'));
    ?>
</div>