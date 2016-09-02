<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ptkp-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php // echo $form->textFieldRow($model,'tglberlaku',array('class'=>'span5')); ?>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'tglberlaku', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php $this->widget('MyDateTimePicker',array(
						'model'=>$model,
						'attribute'=>'tglberlaku',
						'mode'=>'date',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
						),
						'htmlOptions'=>array('readonly'=>true,
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'class'=>'dtPicker3',
						),
					)); ?> 
				</div>
			</div>
            <?php echo $form->dropDownListRow($model,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'jmltanggunan',array('class'=>'span5 numbers-only','maxlength'=>100, 'style'=>'text-align:right;')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'wajibpajak_thn',array('class'=>'span5 numbers-only','maxlength'=>20, 'style'=>'text-align:right;')); ?>
            <?php echo $form->textFieldRow($model,'wajibpajak_bln',array('class'=>'span5 numbers-only','maxlength'=>20, 'style'=>'text-align:right;')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'berlaku', array('checked'=>'berlaku')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
