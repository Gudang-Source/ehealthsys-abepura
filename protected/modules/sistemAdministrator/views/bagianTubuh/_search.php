<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabagiantubuh-m-search',
	'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'namabagtubuh',array('class'=>'span3','maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'bagtubuh_namalain',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kordinat_x',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'kordinat_y',array('class'=>'span3')); ?>
        </td>
        <td style="padding-left:50px;">
            <?php echo $form->checkBoxRow($model,'bagiantubuh_aktif'); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'bagiantubuh_id',array('class'=>'span3')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
