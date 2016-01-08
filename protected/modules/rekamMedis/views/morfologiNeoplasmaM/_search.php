<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmmorfologi-neoplasma-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'morfologineoplasma_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'morfologineoplasma_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'morfologineoplasma_aktif',array('checked'=>'$data->morfologineoplasma_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'morfologineoplasma_id',array('class'=>'span3')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
