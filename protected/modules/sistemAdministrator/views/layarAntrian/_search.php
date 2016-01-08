<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'salayarantrian-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
	<?php //echo $form->textFieldRow($model,'layarantrian_id',array('class'=>'span3')); ?>
        <td>
	<?php echo $form->textFieldRow($model,'layarantrian_jenis',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'layarantrian_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'layarantrian_judul',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
        <td>
	<?php echo $form->textAreaRow($model,'layarantrian_runningtext',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>
        
        
	<?php // echo $form->textFieldRow($model,'layarantrian_latarbelakang',array('class'=>'span3','maxlength'=>300)); ?>

	<?php echo $form->textFieldRow($model,'layarantrian_maksitem',array('class'=>'span3')); ?>

        </td>
        <td>
	<?php echo $form->textFieldRow($model,'layarantrian_itemhigh',array('class'=>'span3')); ?>
            
	<?php echo $form->textFieldRow($model,'layarantrian_itemwidth',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'layarantrian_intrefresh',array('class'=>'span3')); ?>

	<?php echo $form->checkBoxRow($model,'layarantrian_aktif'); ?>
        </td>
    </tr>
</table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
