<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saperanpengguna-k-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'peranpenggunanama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'peranpenggunanamalain',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'peranpengguna_aktif'); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'peranpengguna_id',array('class'=>'span3')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
