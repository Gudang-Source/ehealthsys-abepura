<div class="white-container">
    <legend class="rim2">Lihat Data <b>Pesan Kamar</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
//		'bookingkamar_id',
                'bookingkamar_no',
                'pasien.no_rekam_medik',
                'pasien.nama_pasien',
                'pendaftaran.no_pendaftaran',
		'kelaspelayanan.kelaspelayanan_nama',
		'kamarruangan.kamarruangan_nokamar',
		'ruangan.ruangan_nama',
		'tglbookingkamar',
		'statusbooking',
		'keteranganbooking',
//		'create_time',
//		'update_time',
//		'create_loginpemakai_id',
//		'update_loginpemakai_id',
//		'create_ruangan',
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="icon-arrow-left icon-white"></i>')), 
            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/admin'), 
            array('class'=>'btn btn-primary',)); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>