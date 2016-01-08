<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmsys-dia-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'systolic_min',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'systolic_max',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'diastolic_min',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'diastolic_max',array('class'=>'span3')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'sysdia_aktif',array('checked'=>'$data->sysdia_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'sysdia_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'kelompokumur_id',array('class'=>'span3')); ?>

            
            

	<?php //echo $form->textFieldRow($model,'sysdia_range',array('class'=>'span3','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'sysdia_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php //echo $form->textAreaRow($model,'sysdia_desc',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
