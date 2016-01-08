

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'indexing-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>"return requiredCheck(this);"),
                'focus'=>'#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'kelrem_id',CHtml::listData($model->getKelremItems(),'kelrem_id','kelrem_nama'),array('empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'indexing_urutan'); ?>
            <?php echo $form->textFieldRow($model,'indexing_nama',array('size'=>60,'maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'indexing_singk',array('size'=>30,'maxlength'=>30)); ?>
            <?php echo $form->textFieldRow($model,'indexing_nilai'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'indexing_aktif'); ?>
        </td>
    </tr>
</table>        

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id.'/gelarBelakangM/admin'), 
        array('class'=>'btn btn-danger',
              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php
        $content = $this->renderPartial('../tips/tips',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
