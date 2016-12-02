<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sagolongan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'golongan_kode'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
            
            <?php echo $form->textFieldRow($model,'golongan_kode',array('readonly'=>TRUE, 'class'=>'span1 numbers-only','onkeyup'=>'setKode(this);', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2, 'style' => 'text-align:right;')); ?>
            <?php echo $form->textFieldRow($model,'golongan_nama',array('onkeyup' => 'namaLain(this)' ,'class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'golongan_namalainnya',array('class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'golongan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '',
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                <?php //$this->widget('UserTips',array('type'=>'update'));?>
		<?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Golongan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial($this->path_tips.'detailTips',array('tips'=>$tips),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
?></div>

<?php $this->endWidget(); ?>

<script>
function namaLain(obj){
    $("#<?php echo Chtml::activeId($model, 'golongan_namalainnya') ?>").val($(obj).val());
}
</script>


