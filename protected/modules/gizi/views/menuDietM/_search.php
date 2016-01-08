
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'gzmenudiat-m-search',
                'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'jenisdiet_id',
            CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
            array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
            'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'menudiet_nama',array('size'=>60,'maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'menudiet_namalain',array('size'=>60,'maxlength'=>200)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->textFieldRow($model,'jml_porsi',array('class'=>'span1')); ?>
        </td>
    </tr>
</table>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>