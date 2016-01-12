
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kujenis-pengeluaran-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#KUJenispengeluaranM_jenispengeluaran_kode',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'jenispengeluaran_kode',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'KUJenispengeluaranM_jenispengeluaran_kode','')", 'maxlength'=>25)); ?>
            <?php echo $form->textFieldRow($model,'jenispengeluaran_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return nextFocus(this,event,'KUJenispengeluaranM_jenispengeluaran_nama','')", 'maxlength'=>25)); ?>
            <?php echo $form->textFieldRow($model,'jenispengeluaran_namalain',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'KUJenispengeluaranM_jenispengeluaran_namalain','KUJenispengeluaranM_jenispengeluaran_namalain')", 'maxlength'=>25)); ?>
            <?php //echo $form->checkBoxRow($model,'jenispengeluaran_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/jenisPengeluaranM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pengeluaran', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                $this->createUrl('jenisPengeluaranM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
<?php
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('KUJenispengeluaranM_jenispengeluaran_namalain').value = nama.value.toUpperCase();
    }
</script>