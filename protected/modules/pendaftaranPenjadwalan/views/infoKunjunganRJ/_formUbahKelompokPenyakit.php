<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'no_pendaftaran',array('readonly'=>true)); ?>
<div class="control-group ">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np','np',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($model,'ruangan_id',
        CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),
        array('empty'=>'-- Pilih --','disabled'=>'disabled')
    );
?>
<div class="control-group ">
    <?php echo CHtml::label('Kelompok Penyakit', 'jp', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('jp','jp',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($model,'jeniskasuspenyakit_id',
            CHtml::listData(
                $model->getJenisKasusPenyakitItems($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'
            ),
            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
        );
?>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $('#PPPendaftaranT_jeniskasuspenyakit_id').focus();
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaran').val();
        $.post("<?php echo ($menu == 'RD' ? $this->createUrl('getDataPendaftaranRD') : $this->createUrl('getDataPendaftaranRJ')); ?>", { pendaftaran_id: pendaftaran_id },
            function(data){
                $('#PPPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                $('#PPPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#PPPendaftaranT_ruangan_id').val(data.ruangan_id);
                $('#jp').val(data.jeniskasuspenyakit_nama);
                loadJenisPenyakit(data.ruangan_id);
            },
        "json");
    }
    loadDataPendaftaran();
    function loadJenisPenyakit(id_ruangan)
    {
        $.post("<?php echo $this->createUrl('getKasusPenyakit')?>", { id_ruangan: id_ruangan },
            function(data){
                $('#PPPendaftaranT_jeniskasuspenyakit_id').empty().append(data.listPenyakit);
            },
        "json");        
    }
</script>