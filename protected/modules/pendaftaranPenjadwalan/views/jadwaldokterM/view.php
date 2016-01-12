<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Rdjadwaldokter Ms'=>array('index'),
            $model->jadwaldokter_id,
    );


    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jadwaldokter_id',
                    'instalasi.instalasi_nama',
                    'ruangan.ruangan_nama',
                    'pegawai.nama_pegawai',
                    'jadwaldokter_hari',
                    'jadwaldokter_buka',
                    'jadwaldokter_mulai',
                    'jadwaldokter_tutup',
                    'maximumantrian',
            ),
    )); ?>

    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update&id='.$model->jadwaldokter_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Dokter',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</div>