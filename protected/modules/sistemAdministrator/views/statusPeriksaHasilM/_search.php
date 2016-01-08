<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rdkeadaan-masuk-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class='control-group'>
                <?php echo $form->labelEx($model,'Keadaan / Kondisi', array('class'=>'control-label')) ?>
                <div class="controls">
                     <?php echo $form->textField($model,'lookup_name',array('class'=>'span3', 'maxlength'=>200)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'lookup_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'lookup_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'lookup_type',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_value',array('class'=>'span5','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span5','maxlength'=>50)); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
