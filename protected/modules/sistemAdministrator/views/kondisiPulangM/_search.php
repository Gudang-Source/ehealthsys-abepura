<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rdkondisi-pulang-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'lookup_aktif',array('checked'=>true)); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'lookup_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'lookup_type',array('class'=>'span3','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_value',array('class'=>'span3','maxlength'=>200)); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
