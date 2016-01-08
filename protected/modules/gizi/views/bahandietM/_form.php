
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gzbahandiet-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#BahandietM_bahandiet_nama',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<p class="help-block">Bagian dengan tanda <span class="required">*</span> harus diisi.</p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'bahandiet_nama',array('onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>60,'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'bahandiet_namalain',array('onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>60,'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'bahandiet_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->error($model,'bahandiet_aktif'); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeyUp'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                Yii::app()->createUrl($this->module->id.'/bahandietM/admin'), 
                array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bahan Diet', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                $this->createUrl('bahandietM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php
        $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('BahandietM_bahandiet_namalain').value = nama.value.toUpperCase();
    }
</script>