<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelompok-diagnosa-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelompokdiagnosa_nama',array('class'=>'span4','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelompokdiagnosa_namalainnya',array('class'=>'span4','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kelompokdiagnosa_aktif',array('checked'=>'kelompokdiagnosa_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kelompokdiagnosa_id',array('class'=>'span5')); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
