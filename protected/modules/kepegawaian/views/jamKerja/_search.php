<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpjamkerja-m-search',
	'type'=>'horizontal',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll(array('order' => 'shift_nama')), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
            <?php echo $form->textFieldRow($model,'jamkerja_nama',array('class'=>'span3','maxlength'=>50)); ?>
            
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jammasuk',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'jampulang',array('class'=>'span3')); ?>
            
            <?php //echo $form->textFieldRow($model,'jammasukistirahat',array('class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($model,'jammulaiscanmasuk',array('class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($model,'jamakhirscanmasuk',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jamisitrahat',array('class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($model,'jammulaiscanplng',array('class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($model,'jamakhirscanplng',array('class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($model,'toleransiterlambat',array('class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($model,'toleransiplgcpt',array('class'=>'span3')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'jamkerja_aktif'); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'jamkerja_id',array('class'=>'span3')); ?>

            
            
            
            

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
