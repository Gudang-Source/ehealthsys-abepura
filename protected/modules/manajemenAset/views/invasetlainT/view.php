<div class="white-container">
    <legend class="rim2">Lihat Aset <b>Tetap Lainnya</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Guinvasetlain Ts'=>array('index'),
            $model->invasetlain_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Aset Tetap Lainnya', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvasetlainT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvasetlainT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' MAInvasetlainT', 'icon'=>'pencil','url'=>array('update','id'=>$model->invasetlain_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' MAInvasetlainT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->invasetlain_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Aset Tetap Lainnya', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'invasetlain_id',
		'asal.asalaset_nama',
		'barang.barang_nama',
                array(
                    'label'=>'Gambar Barang',
                    'type'=>'raw',
                    'value'=>CHtml::image(Params::urlBarangDirectory().$model->barang->barang_image,'', array('style'=>'max-height:120px; max-width:120px;')),
                ),
		'lokasi.lokasiaset_namalokasi',
		'pemilik.pemilikbarang_nama',
		'invasetlain_kode',
		'invasetlain_noregister',
		'invasetlain_namabrg',
		'invasetlain_judulbuku',
		'invasetlain_spesifikasibuku',
		'invasetlain_asalkesenian',
		'invasetlain_jumlah',
		'invasetlain_thncetak',
		'invasetlain_harga',
		'invasetlain_tglguna',
		'invasetlain_akumsusut',
		'invasetlain_ket',
		'invasetlain_penciptakesenian',
		'invasetlain_bahankesenian',
		'invasetlain_jenishewan_tum',
		'invasetlain_ukuranhewan_tum',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
    )); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>