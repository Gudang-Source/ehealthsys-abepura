<div class="white-container">
    <legend class="rim2">Lihat <b>Klasifikasi Fitnes</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Mcklasifikasifitnes Ms'=>array('index'),
            $model->klasifikasifitnes_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span4">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'klasifikasifitnes_id',
                                    'age_elev',
                                    'lama_menit',
                                    'workload_kph',
                                    'estimasirate',
                            ),
        )); ?>
        </div>
        <div class="span4">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'max_intake',
                                    'umur_min',
                                    'umur_maks',
                                    'klasifikasifitnes',
                                    'functional_class',
                            ),
        )); ?>
        </div>
        <div class="span4">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'walking_kmhr',
                                    'jogging_kmhr',
                                    'bicycling_kmhr',
                                    'other_sports',
                                    array(
                                            'name'=>'klasifikasifitnes_aktif',
                                            'type'=>'raw',
                                            'value'=>(($model->klasifikasifitnes_aktif) ? "Aktif" : "Tidak Aktif"),
                                    ),
									'jeniskelamin',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->klasifikasifitnes_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Klasifikasi Fitnes',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php
                    $content = $this->renderPartial('../tips/view',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </div>
</div>