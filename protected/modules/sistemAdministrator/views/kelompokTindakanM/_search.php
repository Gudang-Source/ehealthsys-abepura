<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelompok-tindakan-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelompoktindakan_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelompoktindakan_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php //echo $form->textFieldRow($model,'kelompoktindakan_persencyto',array('class'=>'span1','maxlength'=>3)); ?>
            <div class="control-group">
                <?php echo $form->labelex($model,'Cyto',array('class'=>"control-label required")) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kelompoktindakan_persencyto',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> %
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'kelompoktindakan_aktif', array('checked'=>'$data->kelompoktindakan_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kelompoktindakan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kelompoktindakan_urutan',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
