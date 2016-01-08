<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Pulang</b></legend>
    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasienPulang-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasienPulang-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    //echo Yii::app()->user->getState('ruangan_id');
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Pulang</b></h6>
        <?php echo $this->renderPartial('_tablePasienPulang', array('modPasienYangPulang'=>$modPasienYangPulang)); ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('modPasienYangPulang'=>$modPasienYangPulang)); ?>
    <?php 
    // Dialog untuk batal Rawat Darurat =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBatalPulang',
        'options'=>array(
            'title'=>'Pembatalan Pulang Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>500,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" name="iframeBatalPulang" width="100%" height="550">
    </iframe>
    <?php $this->endWidget(); ?>
</div>