<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'agunitkerja-m-search',
	'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kodeunitkerja',array('class'=>'span3 angkahurufs-only','maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'namaunitkerja',array('class'=>'span3 hurufs-only','maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'namalain',array('class'=>'span3 hurufs-only','maxlength'=>200)); ?>
        </td>
        
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'unitkerja_aktif'); ?>
        </td>
    </tr>
</table>
	
	
	

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
