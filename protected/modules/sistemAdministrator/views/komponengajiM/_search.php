<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'komponengaji-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'nourutgaji',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'komponengaji_kode',array('class'=>'span3 angkahuruf-only','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'komponengaji_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'komponengaji_singkt',array('class'=>'span3 angkahuruf-only','maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->checkBoxRow($model,'ispotongan'); ?>
            <?php echo $form->checkBoxRow($model,'komponengaji_aktif', array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'komponengaji_id',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
