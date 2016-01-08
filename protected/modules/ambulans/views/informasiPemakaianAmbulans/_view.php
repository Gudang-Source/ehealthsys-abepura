<div class="row-fluid">
    <div class="span6">
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'no_rekam_medik',
                    'pemakai_nama',
                    'nama_pasien',
                    'tempattujuan',
                    'alamattujuan',
                    array(
                        'name'=>'No. Mobile / Telepon',
                        'value'=>$model->nomobile." / ".$model->notelepon,
                    ),
                    array(
                        'name'=>$model->getAttributeLabel('supir_id'),
                        'value'=>$model->supir_nama,
                    ),
                    array(
                        'name'=>'Paramedis',
                        'value'=>(isset($model->paramedis1_nama) ? $model->paramedis1_nama : "")." | ".(isset($model->paramedis2_nama) ? $model->paramedis2_nama : ""),
                    ),
                    
            ),
    )); ?>
    </div>
    <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                    array(
                            'name'=>'Km Awal / Km Akhir',
                            'value'=> number_format($model->kmawal)."/".number_format($model->kmakhir),
                        ),
                    array(
                        'name'=>'jumlahkm',
                        'value'=>number_format($model->jumlahkm),
                    ),
                    array(
                        'name'=>'tarifperkm',
                        'value'=>number_format($model->tarifperkm),
                    ),
                    array(
                        'name'=>'totaltarifambulans',
                        'value'=>number_format($model->totaltarifambulans),
                    ),
                    array(
                        'name'=>'tglkembaliambulans',
                        'value'=>MyFormatter::formatDateTimeForUser($model->tglkembaliambulans),
                    ),
                ),
        )); ?>
    </div>
</div>