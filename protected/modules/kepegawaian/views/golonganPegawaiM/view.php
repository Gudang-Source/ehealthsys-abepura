<!--<div class="white-container">
    <legend class="rim2">Lihat <b>Golongan Pegawai</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Lihat Golongan Pegawai</legend>
    <?php
    $this->breadcrumbs=array(
            'Sagolongan Pegawai Ms'=>array('index'),
            $model->golonganpegawai_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Golongan Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Golongan Pegawai', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan Pegawai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Golongan Pegawai', 'icon'=>'pencil','url'=>array('update','id'=>$model->golonganpegawai_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Golongan Pegawai','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->golonganpegawai_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Pegawai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'golonganpegawai_id',
                    'golonganpegawai_nama',
                    'golonganpegawai_namalainnya',
					'golonganpegawai_urutan',
                    array(             
                        'name'=>'golonganpegawai_aktif',
                        'type'=>'raw',
                        'value'=>(($model->golonganpegawai_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Golongan Pegawai', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                        $this->createUrl('golonganPegawaiM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
<!--</div>-->