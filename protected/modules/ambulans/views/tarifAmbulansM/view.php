<div class="white-container">
    <legend class="rim2">Lihat <b>Tarif Ambulans</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Satarifambulans Ms'=>array('index'),
            $model->tarifambulans_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tarif Ambulans ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tarif Ambulans', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Makanan', 'icon'=>'pencil','url'=>array('update','id'=>$model->bahanmakanan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Bahan Makanan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->bahanmakanan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tarif Ambulans', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'tarifambulans_id',
                    'daftartindakan_id',
                    'tarifambulans_kode',
                    'kepropinsi_nama',
                    'kekabupaten_nama',
                    'kekecamatan_nama',
                    'kekelurahan_nama',
                    'jmlkilometer',
                    'tarifperkm',
                    'tarifambulans',
            ),
    )); ?>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->tarifambulans_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tarif Ambulans',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</div>