
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kujenis-penerimaan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#KUJenispenerimaanM_jenispenerimaan_kode',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'jenispenerimaan_kode',array('class'=>'span3 angkahuruf-only', 'onkeypress'=>"return nextFocus(this,event,'KUJenispenerimaanM_jenispenerimaan_kode','')", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'jenispenerimaan_nama',array('class'=>'span3 hurufs-only', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return nextFocus(this,event,'KUJenispenerimaanM_jenispenerimaan_nama','')", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'jenispenerimaan_namalain',array('class'=>'span3 hurufs-only', 'onkeypress'=>"return nextFocus(this,event,'KUJenispenerimaanM_jenispenerimaan_namalain','KUJenispenerimaanM_jenispenerimaan_namalain')", 'maxlength'=>50)); ?>
            <?php //echo $form->checkBoxRow($model,'jenispenerimaan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/jenisPenerimaanM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penerimaan Umum', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                $this->createUrl('jenisPenerimaanM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp;";?>
<?php
$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('KUJenispenerimaanM_jenispenerimaan_namalain').value = nama.value.toUpperCase();
    }
</script>