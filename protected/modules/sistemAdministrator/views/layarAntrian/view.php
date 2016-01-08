<div class="white-container">
    <legend class="rim2">Lihat Data <b>Layar Antrian</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Salayarantrian Ms'=>array('index'),
            $model->layarantrian_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                            'layarantrian_id',
                    'layarantrian_jenis',
                    'layarantrian_nama',
                    'layarantrian_judul',
                    'layarantrian_runningtext',
    //		'layarantrian_latarbelakang',
                    array(
                        'label'=>'Latar Belakang',
                        'type'=>'raw',
                        'value'=>'<img src="'.Params::urlBackgroundAntrianThumbs().'kecil_'.$model->layarantrian_latarbelakang.'"></img>',
                    ),
                    //'layarantrian_maksitem',
                    //'layarantrian_itemhigh',
                    //'layarantrian_itemwidth',
                    //'layarantrian_intrefresh',
                    //'layarantrian_aktif',
                ),
        )); ?>
        </div>
        <div class="span6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                            //'layarantrian_id',
                    //'layarantrian_jenis',
                    //'layarantrian_nama',
                    //'layarantrian_judul',
                    //'layarantrian_runningtext',
                    //'layarantrian_latarbelakang',
                    'layarantrian_maksitem',
                    'layarantrian_itemhigh',
                    'layarantrian_itemwidth',
                    'layarantrian_intrefresh',
    //		'layarantrian_aktif',
                    array(
                        'label'=>'Status Layar Antrian',
                        'type'=>'raw',
                        'value'=>(($model->layarantrian_aktif == TRUE) ? "Aktif" : "Tidak Aktif"),
                    ),
                ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->layarantrian_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Data Layar Antrian',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php 
            $content = $this->renderPartial($this->path_view.'tips/tipsView',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi', 'content'=>$content));
        ?>
        </div>
    </div>
</div>