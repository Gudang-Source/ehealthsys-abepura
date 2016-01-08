
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gzjeniswaktu-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#JenisWaktuM_jeniswaktu_nama',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<?php $waktu=explode(':', $model->jeniswaktu_jam);
?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jeniswaktu_nama',array('onkeyup'=>"namaLain(this)",'onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>50,'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jeniswaktu_namalain',array('onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>50,'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-label">Jam <span class="required">*</span></div>
            <div class="controls">
                <?php echo CHtml::textField('jam',(!empty($model->jeniswaktu_jam) ? $waktu[0]: ""),array('onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>20,'maxlength'=>2,'style'=>'width:30px;', 'placeholder'=>"Jam")); ?> :
                <?php echo CHtml::textField('menit',(!empty($model->jeniswaktu_jam) ? $waktu[1] : ""),array('onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>20,'maxlength'=>2,'style'=>'width:30px;', 'placeholder'=>"Menit")); ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'jeniswaktu_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>          
<?php //echo $form->textFieldRow($model,'jeniswaktu_nourut',array('class'=>'span2','style'=>'width:50px;')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeyUp'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                Yii::app()->createUrl($this->module->id.'/jenisWaktuM/admin'), 
                array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Waktu', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                $this->createUrl('jenisWaktuM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php
        $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script>

    $("#jam").keypress(function (e){
          var charCode = (e.which) ? e.which : e.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
          }
    });
    $("#menit").keypress(function (e){
          var charCode = (e.which) ? e.which : e.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
          }
    });

    function namaLain(nama)
    {
        document.getElementById('JenisWaktuM_jeniswaktu_namalain').value = nama.value.toUpperCase();
    }
</script>