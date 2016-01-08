
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapemilikbarang-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'pemilikbarang_kode'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php //Echo CHtml::hiddenField('tempKode', $model->pemilikbarang_kode); ?>
            <?php echo $form->textFieldRow($model,'pemilikbarang_kode',array('class'=>'span1 ','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,)); ?>
            <?php echo $form->textFieldRow($model,'pemilikbarang_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'pemilikbarang_namalainnya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->checkBoxRow($model,'pemilikbarang_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                 <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                       '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php //$this->widget('UserTips',array('type'=>'create'));?>
        <?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pemilik Barang', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$this->widget('UserTips',array('content'=>'')); 
?>
        </div>

<?php $this->endWidget(); ?>
<?php 
//Yii::app()->clientScript->registerScript('head','
//    function setKode(obj){
//        var value = $("#tempKode").val();
//        var objValue = $(obj).val();
//        if (objValue < value){
//           $(obj).val(value);
//        }
//    }
//',  CClientScript::POS_HEAD); ?>
<?php //JS;
//Yii::app()->clientScript->registerScript('jsBarang',$jscript, CClientScript::POS_BEGIN);
//
//$js = <<< JS
//$('.numbersOnly').keyup(function() {
//var d = $(this).attr('numeric');
//var value = $(this).val();
//var orignalValue = value;
//value = value.replace(/[0-9]*/g, "");
//var msg = "Only Integer Values allowed.";
//
//if (d == 'decimal') {
//value = value.replace(/\./, "");
//msg = "Only Numeric Values allowed.";
//}
//
//if (value != '') {
//orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
//$(this).val(orignalValue);
//}
//});
//JS;
//Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>
