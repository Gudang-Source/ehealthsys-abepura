<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'sakabupaten-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'propinsi_id',  CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kabupaten_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kabupaten_aktif',array('checked'=>'$data->kabupaten_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kabupaten_id',array('class'=>'span5')); ?>

	<?php //echo $form->dropDownListRow($model,'propinsi_nama',array('class'=>'span3')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
