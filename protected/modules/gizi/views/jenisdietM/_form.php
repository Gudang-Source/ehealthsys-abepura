
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gzjenisdiet-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#JenisdietM_jenisdiet_nama',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jenisdiet_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)",'onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>50,'maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenisdiet_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'size'=>50,'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textAreaRow($model,'jenisdiet_keterangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'rows'=>6, 'cols'=>50)); ?>
        </td>
        <td>
            <div class="control-group">
                <label class="control-label">Catatan</label>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'jenisdiet_catatan','name'=>'jenisdiet_catatan','toolbar'=>'mini','width'=>'50px','height'=>'100px')) ?>
                </div>
            </div>
        </td>
    </tr>
</table>  
<?php /* echo $form->textAreaRow($model,'jenisdiet_catatan',array('class'=>'ext.redactorjs.Redactor','id'=>'redactor_content1','rows'=>6, 'cols'=>50)); */ ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeyUp'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                Yii::app()->createUrl($this->module->id.'/JenisdietM/admin'), 
                array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Diet', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                $this->createUrl('JenisdietM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php
        $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('JenisdietM_jenisdiet_namalainnya').value = nama.value.toUpperCase();
    }
</script>