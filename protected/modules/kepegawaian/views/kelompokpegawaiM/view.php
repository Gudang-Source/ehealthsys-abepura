<!--<div class="white-container">
    <legend class="rim2">Lihat <b>Kelompok Pegawai</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Lihat Kelompok Pegawai</legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompokpegawai Ms'=>array('index'),
            $model->kelompokpegawai_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelompok Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Pegawai', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Pegawai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Pegawai', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelompokpegawai_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kelompok Pegawai','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelompokpegawai_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Pegawai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'kelompokpegawai_id',
                    'kelompokpegawai_nama',
                    'kelompokpegawai_namalainnya',
                    'kelompokpegawai_fungsi',
                    'kelompokpegawai_aktif',
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Pegawai', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                        $this->createUrl('kelompokpegawaiM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
<!--</div>-->