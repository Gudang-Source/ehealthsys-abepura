<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelrem-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelrem_urutan'); ?>
            <?php echo $form->textFieldRow($model,'kelrem_kode',array('size'=>50,'maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelrem_nama',array('size'=>60,'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'kelrem_rate'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkboxRow($model,'kelrem_aktif',array('checked'=>true)); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
