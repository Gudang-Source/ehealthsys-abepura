<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapendidikankualifikasi-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#KPPendidikankualifikasiM_pendkualifikasi_kode',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class = "span4">
        <div class="control-group">
                <?php echo CHtml::label('Kode Pendidikan Kualifikasi','Kode Pendidikan Kualifikasi', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'pendkualifikasi_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label('Nama Kualifikasi Pendidikan <span class="required">*</span>','Nama Kualifikasi Pendidikan', array('class'=>'control-label required')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'pendkualifikasi_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label('Nama Kualifikasi Pendidikan Lainnya','Nama Kualifikasi Pendidikan Lainnya', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'pendkualifikasi_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'pendidikan_id', CHtml::listData(PendidikanM::model()->findAll('pendidikan_aktif = true'), 'pendidikan_id', 'pendidikan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required','onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="span4">
        <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required','onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
                <?php echo $form->labelEx($model,'jmlkeblaki', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'jmlkeblaki',array('class'=>'span1 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;' )); ?>
                         <?php echo CHtml::label('Orang','Orang') ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo $form->labelEx($model,'jmlkebperempuan', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'jmlkebperempuan',array('class'=>'span1 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;')); ?> 
                        <?php echo CHtml::label('Orang','Orang') ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label('Status Aktif','Status Aktif', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->checkBox($model,'pendkualifikasi_aktif',array('checked'=>'checked')); ?>
                </div>
        </div>
    </div>
    <div class="span4">
        <?php echo $form->textAreaRow($model,'pendkualifikasi_keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
	
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/pendidikankualifikasiM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kualifikasi Pendidikan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";

                            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('KPPendidikankualifikasiM_pendkualifikasi_namalainnya').value = nama.value.toUpperCase();
    }
</script>