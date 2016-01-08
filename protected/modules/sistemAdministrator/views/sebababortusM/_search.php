<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pssebababortus-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'kelsebababortus_id',  CHtml::listData($model->KelSebabAbortusItems, 'kelsebababortus_id', 'kelsebababortus_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'sebababortus_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'sebababortus_namalain',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'sebababortus_aktif', array('checked'=>'$data->sebababortus_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'sebababortus_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kelsebababortus_id',array('class'=>'span3')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
