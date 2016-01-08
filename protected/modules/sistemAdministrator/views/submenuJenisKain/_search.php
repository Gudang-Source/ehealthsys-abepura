<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabahanlinen-m-search',
	'type'=>'horizontal',
)); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'bahanlinen_nama',array('class'=>'span3','maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'bahanlinen_namalain',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'suhurekomendasi',array('class'=>'span3','maxlength'=>10)); ?>
            <?php echo $form->checkBoxRow($model,'bahanlinen_aktif'); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'bahanlinen_id',array('class'=>'span3')); ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
