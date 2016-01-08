<div class="white-container">
    <legend class="rim2">Lihat <b>Lokasi Aset</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Salokasiaset Ms'=>array('index'),
            $model->lokasi_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Lokasi Aset', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SALokasiasetM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SALokasiasetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SALokasiasetM', 'icon'=>'pencil','url'=>array('update','id'=>$model->lokasi_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SALokasiasetM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lokasi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  Lokasi Aset', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'lokasi_id',
                    'lokasiaset_kode',
                    'lokasiaset_namainstalasi',
                    'lokasiaset_namabagian',
                    'lokasiaset_namalokasi',
                    'lokasiaset_aktif',
            ),
    )); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Lokasi Aset', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
    $this->widget('UserTips',array('type'=>'view'));?>
</div>