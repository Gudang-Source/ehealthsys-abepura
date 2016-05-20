<div class="white-container">
    <legend class='rim2'>Lihat <b>Penerimaan Umum</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kujenis Penerimaan Ms'=>array('index'),
            $model->jenispenerimaan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Penerimaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kelas', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Kelas', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Kelas', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenispenerimaan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Jenis Kelas','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenispenerimaan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Kelas', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jenispenerimaan_id',
                    'jenispenerimaan_kode',
                    'jenispenerimaan_nama',
                    'jenispenerimaan_namalain',
                     array(               // related city displayed as a link
                        'name'=>'jenispenerimaan_aktif',
                        'type'=>'raw',
                        'value'=>(($model->jenispenerimaan_aktif==1)? 'Aktif' : 'Tidak Aktif'),
                    ),

            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penerimaan Umum', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                    $this->createUrl('jenisPenerimaanM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>