<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'kelrem-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
                'focus'=>'#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelrem_urutan',array('size'=>3,'maxlength'=>3,'class'=>'span1')); ?>
            <?php echo $form->textFieldRow($model,'kelrem_kode',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'kelrem_nama',array('size'=>60,'maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'kelrem_desc',array('size'=>60,'maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'kelrem_singkatan',array('size'=>20,'maxlength'=>20)); ?>
            <?php echo $form->textFieldRow($model,'kelrem_rate'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kelrem_aktif'); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 
           'onKeypress'=>'return formSubmit(this,event)',
           'id'=>'btn_simpan',
    //            'onclick'=>'do_upload()',
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id.'/pegawaiM/admin'), 
        array('class'=>'btn btn-danger',
              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php
        $content = $this->renderPartial('../tips/tips',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>